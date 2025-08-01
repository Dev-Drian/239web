<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDetail;
use App\Models\ClientExtradata;
use App\Models\ClientSeo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CitationController extends Controller
{


    public function index()
    {

        $clients = Client::with(['clientDetails', 'clientLocations', 'clientSeo', 'clientSocial'])
            ->get();
        return view('citations.index', compact('clients'));
    }


    public function show(Request $request)
    {
        $client = Client::with(['clientDetails', 'clientLocations', 'clientSeo', 'clientSocial'])
            ->findOrFail($request->client_id);

        return view('citations.show', compact('client'));
    }

    public function processCitationOrder(Request $request)
    {


        DB::beginTransaction();
        try {
            $clientId = $request->input('client_id');
            $client = Client::with(['clientDetails', 'clientLocations', 'clientSeo', 'clientSocial', 'clientExtra'])
                ->findOrFail($clientId);

            // Actualizar datos principales del cliente
            $client->update([
                'email' => $request->email,
                'name' => $request->business_name,
                'website' => $request->website_url,
                'address' => $request->address_line1,
                'city' => $request->city,
                'rol' => 'client', // Valor por defecto
            ]);
            $businessHours = explode("\n", $request->business_hours);
            $businessHours = array_map('trim', $businessHours); // Limpia espacios
            $businessHours = array_filter($businessHours); // Elimina líneas vacías



            // Actualizar o crear clientLocations
            $clientLocations = $client->clientLocations()->updateOrCreate(
                ['client_id' => $clientId],
                [
                    'formatted_phone_number' => $request->phone_number,
                    'formatted_address' => $request->address_line1,


                    'weekday_text' => json_encode(array_values($businessHours)), // array_values reindexa el array

                ]
            );

            // Actualizar o crear clientDetails
            $clientDetails = $client->clientDetails()->updateOrCreate(
                ['client_id' => $clientId],
                [
                    'year_found' => $request->year_founded,
                    'employees' => $request->num_employees,
                    'logo_url' => $request->logo_url,
                    'video_url' => $request->video_url,
                    'photo1_url' => $request->photo1_url,
                    'photo2_url' => $request->photo2_url,
                    'phone' => $request->phone_number,
                    'full_name' => $request->name
                ]
            );

            // Actualizar o crear clientSeo (usando los datos directamente del request)
            $clientSeo = $client->clientSeo()->updateOrCreate(
                ['client_id' => $clientId],
                [
                    'keywords' => $request->keywords,
                    'description_short' => $request->short_description,
                    'description_long' => $request->long_description,
                    'spun_description' => $request->spun_description,
                    'seo_email' => $request->seo_email,
                ]
            );

            // Actualizar o crear clientExtra
            $clientExtra = $client->clientExtra()->updateOrCreate(
                ['client_id' => $clientId],
                [
                    'owner_name' => $request->owner_name,
                    'business_fax' => $request->business_fax,
                    'directory_list' => $request->directory_list,
                    'instructions_notes' => $request->instructions_notes,
                    'number_of_citations' => $request->num_citations,
                    'photo_url3' => $request->photo3_url,
                    'zip' => $request->zip_code,
                    'state' => $request->state,
                    'address_line2' => $request->address_line2,
                ]
            );
            // Actualizar o crear clientSocial
            $clientSocial = $client->clientSocial()->updateOrCreate(
                ['client_id' => $clientId],
                [
                    'social_links' => $request->social_media_links ?
                        json_encode(
                            is_array($request->social_media_links) ?
                                $request->social_media_links :
                                array_map('trim', explode(',', $request->social_media_links))
                        ) : null,
                ]
            );

            // Obtener idstamp del formulario externo
            $url = "https://kalisekj.wufoo.com/forms/m19f81p40v8r4wl/";


            // Preparar datos para el formulario externo (usando datos del request directamente)
            $validCountries = ['USA', 'Canada', 'Australia'];
            $country = $request->country ?? 'USA'; // Valor por defecto: USA

            $postData = [
                'Field44' => $request->email,
                'Field55' => $request->name,
                'Field4' => in_array($country, $validCountries) ? $country : 'Other',
                'Field5' => !in_array($country, $validCountries) ? $country : '', // Nuevo Field5
                'Field14' => $request->website_url,
                'Field19' => $request->business_name,
                'Field17' => $request->keywords,
                'Field21' => $request->short_description,
                'Field57' => $request->long_description,
                'Field59' => $request->spun_description,
                'Field39' => $request->social_media_links,
                'Field46' => $request->address_line1,
                'Field50' => $request->zip_code,
                'Field25' => $request->business_fax,
                'Field24' => $request->business_fax,
                'Field48' => $request->city,
                'Field23' => $request->seo_email,
                'Field10' => $request->num_citations . '200 Local Citations [TAT 13 Days]',
                // Field51 se eliminó (ya no se usa para el país)
                'Field26' => $request->year_founded,
                'Field27' => $request->num_employees,
                'Field18' => $request->business_hours,
                'Field30' => $request->video_url,
                'Field29' => $request->logo_url,
                'Field37' => $request->photo1_url,
                'Field36' => $request->photo2_url,
                'Field22' => $request->owner_name,
                'Field47' => $request->address_line2,
                'Field49' => $request->state,
                'Field41' => $request->directory_list,
                'Field42' => $request->instructions_notes,
            ];
            // Enviar formulario externo
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode >= 400) {
                throw new \Exception("HTTP error: $httpCode - $response");
            }

            curl_close($ch);

            // Registrar el envío de citación
            $client->clientCitationSubmissions()->create([
                'submitted_at' => now(),
                'form_response' => $response,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data saved and form submitted successfully',
                'view' => $response,
                'client_data' => $client->load(['clientDetails', 'clientLocations', 'clientSeo', 'clientSocial', 'clientExtra'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving data and submitting form: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error processing the request',
                'error' => $e->getMessage(),
                'request_data' => $request->all() // For debugging
            ], 500);
        }
    }
}
