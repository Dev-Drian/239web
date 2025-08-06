<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $clients = Client::query();
        if ($search) {
            $clients->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhere('highlevel_id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('status_filter')) {
            $clients->where('status', $request->status_filter);
        }

        $clients->orderByRaw("status = 'active' DESC")
            ->orderByRaw("CASE WHEN name IS NULL OR name = '' THEN 1 ELSE 0 END ASC")
            ->orderBy('name', 'asc');

        if ($request->filled('subscriptions')) {
            $subscription = $request->input('subscriptions');
            $clients->whereJsonContains('subscriptions', $subscription)
                ->where('status', 'active');
        }
        $clients = $clients->paginate(10);

        $this->load_client();
        $ids = $this->compareHighLevelIds();

        return view('clients.index', compact('clients', 'ids'));

        return view('clients.index', compact('clients', 'ids'));
    }

    public function load_client()
    {
        $locations =  $this->fetchLocations();

        foreach ($locations as $location) {
            Client::firstOrCreate(
                ['highlevel_id' => $location['id']], // condición de búsqueda
                [
                    'website' => $location['website'] ?? '',
                    'address' => $location['address'] ?? '',
                    'city' => $location['city'] ?? '',
                    'email' => $location['email'] ?? '',
                    'name' => $location['name'] ?? '',
                    'remote_page_id' => ' ',
                ]
            );
        }

        return response()->json(['message' => 'Clients updated successfully']);
    }


    public function pressRelease(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->press_release = $request->input('press_release');
        $client->save();
        return response()->json(['success' => true]);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'highlevel_id' => 'required|string|unique:clients,highlevel_id'
        ]);;

        $client = new Client();
        $client->highlevel_id = $validated['highlevel_id'];
        $client->status = 'active';
        $client->save();

        return redirect()->route('client.show', compact('client'));
    }

    public function fetchLocations()
    {
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55X2lkIjoiZkpNRTdKM1dkN041OXg4UkxxRVUiLCJ2ZXJzaW9uIjoxLCJpYXQiOjE2NDIwOTgyMjYxMjYsInN1YiI6IndZTWVBNnR3cXR1T1pWWmtHWjZNIn0.GMKtDJadSGxW4gNLlcnjw8b51WYzc_TE_TFliWKmsjg'
        // ])->get('https://rest.gohighlevel.com/v1/locations/');
        $response['locations'] = [];

        return  $response['locations'];
    }

    public function compareHighLevelIds()
    {
        $locations = $this->fetchLocations();
        $api_ids = array_column($locations, 'id');

        $db_ids = Client::pluck('highlevel_id')->toArray();

        $new_ids = array_diff($api_ids, $db_ids);
        $missing_ids = array_diff($db_ids, $api_ids);

        // Log the new and missing IDs
        foreach ($new_ids as $new_id) {
            Log::info('New HighLevel ID: ' . $new_id);
        }

        foreach ($missing_ids as $missing_id) {
            Log::info('Missing HighLevel ID: ' . $missing_id);
        }

        return $data =  [
            'total_api_ids' => count($api_ids),
            'total_db_ids' => count($db_ids),
            'new_ids' => $new_ids,
            'missing_ids' => $missing_ids,
        ];
    }


    public function create(Request $request)
    {
        $client = new Client();
        $client->highlevel_id = $request->input('highlevel_id');
        $client->website = $request->input('website');
        $client->address = $request->input('address');
        $client->city = $request->input('city');
        $client->email = $request->input('email');
        $client->status = $request->input('status');
        $client->name = $request->input('name');
        $client->rol = "client";
        $client->save();

        return redirect()->route('client.index')->with('message', 'Client created successfully');
    }


    public function sync_client()
    {
        try {
            // Fetch data from the API
            $response = Http::get('https://clients.limopartner.com/new/sync_client.php');
            $clients = $response->json();

            foreach ($clients as $clientData) {
                $client = Client::firstOrNew(['highlevel_id' => $clientData['user_hl_id']]);

                $client->name = !empty($clientData['name']) ? $clientData['name'] : $client->name;
                $client->email = !empty($clientData['business_email']) ? $clientData['business_email'] : $client->email;
                $client->website = !empty($clientData['website']) ? $clientData['website'] : $client->website;
                $client->address = !empty($clientData['formatted_address']) ? $clientData['formatted_address'] : $client->address;
                $client->city = !empty($clientData['city']) ? $clientData['city'] : $client->city;
                $client->status = 'active';

                // Handle JSON fields - only update if new data exists
                if (!empty($clientData['services'])) {
                    $client->services = explode(',', $clientData['services']);
                }

                if (!empty($clientData['areas'])) {
                    $client->areas = explode(',', $clientData['areas']);
                }

                if (!empty($clientData['vehicles'])) {
                    $client->cars = $clientData['vehicles'];
                }

                $client->save();
                // Update or create client location
                /* if ($clientData['place_id']) {
                    $location = $client->location()->updateOrCreate(
                        ['client_id' => $client->id],
                        [
                            'place_id' => $clientData['place_id'],
                            'formatted_address' => $clientData['formatted_address'],
                            'formatted_phone_number' => $clientData['formatted_phone_number'],
                            'lat' => $clientData['lat'],
                            'lng' => $clientData['lng'],
                            'street_number' => $clientData['street_number'],
                            'route' => $clientData['route'],
                            'gmburl' => $clientData['gmburl'],
                            'weekday_text' => json_decode($clientData['weekday_text'] ?? '[]'),
                            'county' => $clientData['county']
                        ]
                    );
                } */

                // Update or create client SEO
                /*  $client->seo()->updateOrCreate(
                    ['client_id' => $client->id],
                    [
                        'keywords' => $clientData['keywords'],
                        'description_short' => $clientData['description_short'],
                        'description_long' => $clientData['description_long'],
                        'spun_description' => $clientData['spun_description'],
                        'blog_post' => $clientData['blog_post'],
                        'seo_email' => $clientData['seo_email']
                    ]
                ); */
            }
            return redirect()->route('client.index')->with('succeess', 'Clients synchronized successfully');
        } catch (\Exception $e) {
            Log::error('Client sync error: ' . $e->getMessage());
            return $e->getMessage();
            return redirect()->route('client.index')->with('error', 'Error synchronizing clients: ' . $e->getMessage());
        }
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function seoTable()
    {
        $clients = Client::with([
            'clientSocialProfiles',
            'clientExtra',
            'clientSeo',
            // 'pressReleases',
            'clientCitationSubmissions',
        ])
            ->whereJsonContains('subscriptions', 'seo')
            ->where('status', 'active')
            ->paginate(10);
        return view('components.client.seo-table', compact('clients'));
    }

    public function update(Request $request, Client $client)
    {
        //return $request;
        $client->update($request->only([
            'name',
            'email',
            'website',
            'status',
            'premium',
            'credits',
            'address',
            'city',
            'primary_city',
            'extra_service',
            'airports',
        ]) + [
            'services' => array_column($request->input('services', []), 'name'),
            'areas' => $request->input('areas', []),
            'cars' => $request->input('cars', []), // Asegúrate que venga como array
            'subscriptions' => $request->input('subscriptions', []),
        ]);


        $details = [];

        // Handle file uploads
        $fileFields = ['logo', 'video', 'photo1', 'photo2'];

        foreach ($fileFields as $field) {
            if ($request->hasFile("details.{$field}_file")) {
                $file = $request->file("details.{$field}_file");
                // Obtener la extensión del archivo desde el nombre original
                $extension = $file->getClientOriginalExtension();

                // Generar ruta relativa basada en la fecha actual
                $relativePath = 'uploads/' . Carbon::now()->format('Y/m') . '/';

                // Crear directorio si no existe
                if (!File::exists(public_path($relativePath))) {
                    File::makeDirectory(public_path($relativePath), 0755, true);
                }

                // Generar nombre de archivo único
                $fileName = uniqid('doc-') . '-' . $field . '.' . $extension;
                $fullPath = public_path($relativePath . $fileName);

                // Guardar el archivo
                file_put_contents($fullPath, file_get_contents($file->getRealPath()));

                // Guardar la URL pública
                $details["{$field}_url"] = url($relativePath . $fileName);
            }
        }
        $client->clientDetails()->updateOrCreate([], $request->details);
        $client->clientSeo()->updateOrCreate([], $request->seo);
        $client->clientExtra()->updateOrCreate([], $request->citation);
        // $client->clientLocations()->updateOrCreate([], $request->location);

        if ($client->clientLocations) {
            $client->clientLocations->update([
                'formatted_phone_number' => $request->details['phone'],
                'formatted_address' => $request->location['address'],
                'gmburl' => $request->location['gmburl'],
                'lat' => is_numeric($request->location['latitude']) ? (float)$request->location['latitude'] : null,
                'lng' => is_numeric($request->location['longitude']) ? (float)$request->location['longitude'] : null,
                'weekday_text' => json_encode(explode("\n", trim($request->location['weekday_text'])))
            ]);
        } else {
            $client->clientLocations()->create([
                'formatted_phone_number' => $request->details['phone'],
                'formatted_address' => $request->location['address'],
                'gmburl' => $request->location['gmburl'],
                'lat' => is_numeric($request->location['latitude']) ? (float)$request->location['latitude'] : null,
                'lng' => is_numeric($request->location['longitude']) ? (float)$request->location['longitude'] : null,
                'weekday_text' => json_encode(explode("\n", trim($request->location['weekday_text'])))
            ]);
        }
        $client->clientSocial()->updateOrCreate(
            ['client_id' => $client->id], // Condiciones de búsqueda
            ['social_links' => json_encode(explode("\n", $request->social_media))] // Valores a guardar
        );

        // Actualizar social media links: primero eliminar todos y luego agregar el nuevo si se envía (lógica vieja)
        if ($request->filled('social_type') && $request->filled('social_url')) {
            $client->clientSocials()->delete();
            $client->clientSocials()->create([
                'type' => $request->input('social_type'),
                'url' => $request->input('social_url'),
            ]);
        }

        // Guardar todos los social media enviados como array en la nueva tabla y relación
        if ($request->filled('social_media_array')) {
            $client->clientSocialProfiles()->delete();
            $socials = json_decode($request->input('social_media_array'), true);
            if (is_array($socials)) {
                foreach ($socials as $social) {
                    if (
                        isset($social['type'], $social['url']) &&
                        !empty($social['type']) &&
                        !empty($social['url']) &&
                        filter_var($social['url'], FILTER_VALIDATE_URL)
                    ) {
                        $client->clientSocialProfiles()->create([
                            'type' => $social['type'],
                            'url' => $social['url'],
                        ]);
                    }
                }
            }
        }

        // Update client details
        $client->clientDetails()->updateOrCreate(
            ['client_id' => $client->id],
            $details
        );

        $client->clientSeo()->updateOrCreate(
            ['client_id' => $client->id],
            $request->seo
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Client updated successfully'
            ]);
        }

        return redirect()->route('client.show', ['client' => $client, 'tab' => $request->active_tab])->with('message', 'Client updated successfully');
    }

    public function saveUploadedFile($file, $type)
    {
        // Validate file
        if (!$file || !$file->isValid()) {
            return null;
        }

        // Define relative path with year and month
        $relativePath = 'uploads/clients/' . Carbon::now()->format('Y/m') . '/';

        // Generate unique filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid('doc-') . '-' . $type . '.' . $extension;

        // Full path for storing
        $fullPath = public_path($relativePath);

        // Ensure directory exists
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // Move uploaded file
        $file->move($fullPath, $fileName);

        // Return public URL
        return url($relativePath . $fileName);
    }


    public function updateStatus(Request $request)
    {
        $client = Client::where('highlevel_id', $request->input('highlevel_id'))->first();
        $client->status = $request->input('status');
        $client->save();

        return redirect()->route('client.index')->with('message', 'Status updated successfully');
    }

    public function updaupdateSelectPage(Request $request)
    {
        $client = Client::where('highlevel_id', $request->input('highlevel_id'))->first();
        if (!$client) return response()->json(array('message' => 'Client not found'), 404);
        $client->selected_pages = $request->input('pages'); // Laravel convierte automáticamente a JSON
        $client->save();

        return response()->json([
            'message' => 'Selected pages updated successfully',
            'pages' => $client->selected_pages // Devolvemos las páginas actualizadas
        ]);
    }

    public function updateRemotePageId(Request $request)
    {
        $client = Client::where('highlevel_id', $request->input('highlevel_id'))->first();
        $client->remote_page_id = $request->input('remote_page_id');
        $client->save();

        return redirect()->route('client.index')->with('message', 'Remote Page ID updated successfully');
    }

    public function delete(Request $request)
    {
        Client::where('highlevel_id', $request->input('highlevel_id'))->delete();

        return redirect()->route('client.index')->with('message', 'Client deleted successfully');
    }
}
