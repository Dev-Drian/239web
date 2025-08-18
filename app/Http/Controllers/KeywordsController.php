<?php

namespace App\Http\Controllers;

use App\Livewire\Keywords\Keywords;
use App\Models\Batche;
use App\Models\BatchKeyword;
use App\Models\KeywordTracker;
use App\Models\KeywordTrackerItem;
use App\Models\City;
use App\Models\CityExcel;
use App\Models\Client;
use App\Services\ValueSerpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KeywordsController extends Controller
{
    //index para  auth
    public function index()
    {

        $cities  = City::all();

        return view('keywords.index', compact('cities'));
    }


    public function show($id)
    {
        // Buscar el cliente por highlevel_id
        $client = Client::where('highlevel_id', $id)->first();

        // Si el cliente no existe, mostrar la vista de error 404
        if (!$client) {
            return view('clients.client_404');
        }

        // Obtener los batches del cliente
        $batches = $client->batches;

        // Si no hay batches, inicializar $keywordsData como vacío y mostrar un mensaje en la vista
        $keywordsData = [];

        if ($batches->isEmpty()) {
            // Pasar un mensaje a la vista indicando que no hay batches
            return view('keywords.show', [
                'client' => $client,
                'batches' => $batches,
                'keywordsData' => $keywordsData,
                'message' => 'No hay batches disponibles para este cliente.'
            ]);
        }

        // Si hay batches, procesar los datos
        foreach ($batches as $batch) {
            foreach ($batch->keyword as $keyword) {
                if (!isset($keywordsData[$keyword->keyword])) {
                    $keywordsData[$keyword->keyword] = [
                        'keyword' => $keyword->keyword,
                        'positions' => [],
                        'cpcs' => [],
                        'volumes' => [],
                        'urls' => [],
                        'dates' => [],
                    ];
                }

                $keywordsData[$keyword->keyword]['positions'][] = $keyword->position;
                $keywordsData[$keyword->keyword]['cpcs'][] = $keyword->cpc;
                $keywordsData[$keyword->keyword]['volumes'][] = $keyword->search_volume;
                $keywordsData[$keyword->keyword]['urls'][] = $keyword->url ?? '#';
                $keywordsData[$keyword->keyword]['dates'][] = $keyword->date;
            }
        }

        // Convertir el array asociativo a un array indexado
        $keywordsData = array_values($keywordsData);

        // Pasar los datos a la vista
        return view('keywords.show', compact('client', 'batches', 'keywordsData'));
    }

    // Save or update keyword tracker (config + keywords/items)
    public function saveTracker(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'device' => 'nullable|string|in:desktop,mobile',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:255',
            'items' => 'nullable|array',
            'items.*.keyword' => 'required_with:items|string|max:255',
            'items.*.last_position' => 'nullable|string|max:255',
            'items.*.previous_position' => 'nullable|string|max:255',
            'items.*.accumulated' => 'nullable|string|max:255',
            'items.*.searches' => 'nullable|integer',
            'items.*.url' => 'nullable|string|max:2048',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $clientId = $user->client_id ?? null;

        return DB::transaction(function () use ($validated, $user, $clientId) {
            $tracker = KeywordTracker::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'client_id' => $clientId,
                    'url' => $validated['url'],
                    'city' => $validated['city'] ?? null,
                    'device' => $validated['device'] ?? null,
                ]
            );

            $keywords = collect($validated['keywords'] ?? [])->filter()->map(fn ($k) => trim($k))->unique()->values();
            $itemsInput = collect($validated['items'] ?? [])->keyBy(function ($item) {
                return strtolower(trim($item['keyword'] ?? ''));
            });

            if ($keywords->isNotEmpty()) {
                // Remove items not present in new keyword list
                KeywordTrackerItem::where('keyword_tracker_id', $tracker->id)
                    ->whereNotIn('keyword', $keywords)
                    ->delete();

                // Upsert each keyword
                foreach ($keywords as $kw) {
                    $key = strtolower($kw);
                    $payload = [
                        'keyword_tracker_id' => $tracker->id,
                        'keyword' => $kw,
                    ];

                    if ($itemsInput->has($key)) {
                        $extra = $itemsInput->get($key);
                        $payload = array_merge($payload, [
                            'last_position' => $extra['last_position'] ?? null,
                            'previous_position' => $extra['previous_position'] ?? null,
                            'accumulated' => $extra['accumulated'] ?? null,
                            'searches' => $extra['searches'] ?? null,
                            'url' => $extra['url'] ?? null,
                            'last_tracked_at' => now(),
                        ]);
                    }

                    KeywordTrackerItem::updateOrCreate(
                        [
                            'keyword_tracker_id' => $tracker->id,
                            'keyword' => $kw,
                        ],
                        $payload
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Tracker saved',
                'tracker_id' => $tracker->id,
            ]);
        });
    }

    // Load current user's keyword tracker with items
    public function getTracker()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $tracker = KeywordTracker::with(['items' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])->where('user_id', $user->id)->first();

        if (!$tracker) {
            return response()->json([
                'success' => true,
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'url' => $tracker->url,
                'city' => $tracker->city,
                'device' => $tracker->device,
                'keywords' => $tracker->items->pluck('keyword')->values(),
                'items' => $tracker->items->map(function ($item) {
                    return [
                        'keyword' => $item->keyword,
                        'last_position' => $item->last_position,
                        'previous_position' => $item->previous_position,
                        'accumulated' => $item->accumulated,
                        'searches' => $item->searches,
                        'url' => $item->url,
                        'last_tracked_at' => optional($item->last_tracked_at)->toDateTimeString(),
                    ];
                })->values(),
            ],
        ]);
    }
    //service for value
    protected $valueSerpService;

    public function __construct(ValueSerpService $valueSerpService)
    {
        $this->valueSerpService = $valueSerpService;
    }

    //index for client
    public function index_guest($id)
    {

        $client = Client::where('highlevel_id', $id)->first();
        if (!$client) {
            return view('clients.client_404');
        }


        $cities  = CityExcel::all();

        return view('keywords.index_guest', compact('cities', 'client'));
    }

    //procfces keyword with value serp
    public function processKeyword(Request $request, $id)
    {
        //client fo highlevel_id
        $client = Client::where('highlevel_id', $id)->first();
        if (!$client) {
            return view('clients.client_404');
        }

        //credit validation
        if ($client->credits <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes creditos disponibles'
            ], 500);
        }


        try {
            $request->validate([
                'keyword' => 'required|string|max:255',
                'searchUrl' => 'required|string|max:255',
                'location' => 'required|string|max:255'
            ]);

            //register keyword in cache
            $cacheKey = md5($request->keyword . $request->searchUrl . $request->location);
            $client->credits = $client->credits - 1;

            //save changes in client table
            $client->save();
            //check if keyword is already in batch omit the process and return the result

            if (Cache::has($cacheKey)) {
                return response()->json([
                    'status' => 'success',
                    'data' => Cache::get($cacheKey),
                    'source' => 'cache',
                    'credits' => $client->credits

                ]);
            }

            //process keyword with value serp
            $result = $this->valueSerpService->findKeywordPosition(
                $request->keyword,
                $request->searchUrl,
                $request->location
            );

            //register keyword in cache
            Cache::put($cacheKey, $result, 3600);



            return response()->json([
                'status' => 'success',
                'data' => $result,
                'source' => 'api',
                'credits' => $client->credits
            ]);
        } catch (\Exception $e) {
            Log::error('Error procesando keyword: ' . $e->getMessage(), [
                'keyword' => $request->keyword,
                'searchUrl' => $request->searchUrl,
                'location' => $request->location,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error procesando la keyword',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //save batch and result to key data
    public function saveResults(Request $request, $id)
    {
        // Buscar el cliente
        $client = Client::where('highlevel_id', $id)->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        try {
            // Crear un nuevo batch
            $batch = Batche::create([
                'batch_id' => 'Batch ' . date('Y-m-d H:i:s'), // Generar un ID único para el batch
                'name' => 'Batch ' . date('Y-m-d H:i:s'), // Nombre del batch (puedes personalizarlo)
                'location' => $request->location ?? 'default', // Ubicación (ajusta según tu lógica)
                'status' => 'completed', // Estado del batch
                'client_id' => $client->id, // Asociar el batch al cliente
            ]);
            // Procesar y guardar los resultados (keywords)
            foreach ($request->results as $result) {
                BatchKeyword::create([
                    'batch_id' => $batch->id, // Asociar la keyword al batch
                    'keyword' => $result['keyword'],
                    'position' => $result['position'],
                    'search_volume' => $result['searchVolume'],
                    'url' => $result['url'],
                    'cpc' => $result['cpc'],
                    'client_id' => $client->id, // Asociar la keyword al cliente
                    'date' => $result['date'] ?? date('Y-m-d H:i:s'), // Fecha de creación

                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Batch y keywords creados con éxito',
                'batch_id' => $batch->id, // Devolver el ID del batch creado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los resultados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obtener el historial de resultados
    public function getHistory($id)
    {
        try {

            $client = Client::where('highlevel_id', $id)->first();

            // Si tienes autenticación, filtrar por usuario
            $all = BatchKeyword::where('client_id', $client->id)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Obtener la posición previa (segundo registro más reciente) por keyword
            $grouped = $all->groupBy('keyword');
            $previous = $grouped->map(function ($items) {
                return $items->get(1); // índice 1 = segundo más reciente
            })->filter()->values();

            if ($previous->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron resultados'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $previous
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
