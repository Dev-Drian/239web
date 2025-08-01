<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\DataForSeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataForSeoController extends Controller
{
    protected $dataForSeoService;

    public function __construct(DataForSeoService $dataForSeoService)
    {
        $this->dataForSeoService = $dataForSeoService;
    }

    public function index()
    {
        return view('dataforseo.index');
    }

    public function searchVolume(Request $request, $id)
    {
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
            $keywords = $request->input('keywords', []);

            // Validación de las keywords
            if (empty($keywords) || !is_array($keywords)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se proporcionaron keywords válidas'
                ], 400);
            }

            // Limitar a 50 keywords para evitar sobrecarga
            $keywords = array_slice($keywords, 0, 50);

            // Parámetros adicionales
            $locationCode = $request->input('location_code', 2840);
            $languageCode = $request->input('lenguaje_name', 'en');

            // Llamar al servicio que interactúa con la API
            $response = $this->dataForSeoService->getKeywordData($keywords, $locationCode, $languageCode);

            $credits = $client->credits - count($keywords);;


            // Manejo de errores en la respuesta
            if (isset($response['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $response['error']
                ], 500);
            }

            // Retornar la respuesta exitosa
            return response()->json([
                'success' => true,
                'data' => $response,
                'credits' => $credits
            ]);
        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    // Endpoint simple para usar directamente con Ajax
    public function ajaxSearch(Request $request)
    {
        try {
            $keywords = $request->input('keywords');
            $locationCode = $request->input('location_code', 2840);
            $languageCode = $request->input('language_code', 'en');

            $result = $this->dataForSeoService->getKeywordData($keywords, $locationCode, $languageCode);

            if (isset($result['error'])) {
                return response()->json([
                    'error' => true,
                    'message' => $result['error']
                ]);
            }

            return response()->json([
                'cpc' => $result['cpc'],
                'search_volume' => $result['search_volume'],
                'difficulty' => $result['difficulty']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error fetching keyword data: ' . $e->getMessage()
            ]);
        }
    }
}
