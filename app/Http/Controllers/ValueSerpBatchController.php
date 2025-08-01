<?php

namespace App\Http\Controllers;

use App\Models\Batche;
use App\Models\Client;
use App\Services\ValueSerpBatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ValueSerpBatchController extends Controller
{
    protected $valueSerpBatchService;

    public function __construct(ValueSerpBatchService $valueSerpBatchService)
    {
        $this->valueSerpBatchService = $valueSerpBatchService;
    }

    public function createBatch(Request $request, $id = null)
    {

        $client = Client::where('highlevel_id', $id)->first();
        if (!$client) {
            return view('clients.client_404');
        }

        if ($client->batches) {
            return response()->json([
                'error' => true,
                'message' => 'Client already has a batch',
                'response' => null
            ]);
        }


        $params = $request->all();
        $keywords = $request->input('keywords', []);
        $location = $request->input('location', null);

        // Crear el batch

        $params['name'] = 'Batch-' . $client->highlevel_id;
        $response = $this->valueSerpBatchService->createBatch($params);

        if ($response['error']) {
            return response()->json($response);
        }
        // Obtener el ID del batch creado
        $batchId = $response['response']['batch']['id'] ?? null;

        if (!$batchId) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to create batch: batch_id not found',
                'response' => null
            ]);
        }

        // Añadir keywords al batch si existen
        if (!empty($keywords)) {
            $addKeywordsResponse = $this->valueSerpBatchService->addKeywordsToBatch($batchId, $keywords, $location);

            if ($addKeywordsResponse['error']) {
                return response()->json($addKeywordsResponse);
            }
        }

        Batche::create([
            'batch_id' => $batchId,
            'name' => $params['name'],
            'client_id' => $client->id,
            'location' => $location,
        ]);

        return response()->json($response);
    }



    public function getBatchStatus($batchId)
    {
        $response = $this->valueSerpBatchService->getBatchStatus($batchId);
        return response()->json($response);
    }

    public function runBatch($batchId)
    {
        // Ejecutar el batch
        // $response = $this->valueSerpBatchService->runBatch($batchId);


        // if ($response['error']) {
        //     return response()->json($response);
        // }

       $resultsResponse = $this->processResults($batchId, "B37E061F367A40DDB24C5AB5A8889B02", "https://www.airbnb.com/");

        // // Esperar hasta que el batch esté listo
        // $maxAttempts = 10;
        // $attempt = 0;
        // $status = null;

        // while ($attempt < $maxAttempts) {
        //     sleep(3); // Esperar 30 segundos antes de verificar el estado nuevamente
        //     $statusResponse = $this->valueSerpBatchService->getBatchStatus($batchId);
        //     $status = $statusResponse['response']['batch']['status'] ?? null;

        //     if ($status === 'idle') {
        //         break;
        //     }
        //     Log::info('Batch status: ' . $status);
        //     $attempt++;
        // }

        // if ($status !== 'idle') {
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Batch did not complete in the expected time',
        //         'response' => null
        //     ]);
        // }

        // // Obtener el conjunto de resultados
        // $resultSetId = 1 + $response['response']['batch']['results_count']; // Asumiendo que el ID del conjunto de resultados es 1
        // $resultsResponse = $this->valueSerpBatchService->getBatchResultSet($batchId, $resultSetId);
        return $resultsResponse;
        return response()->json($resultsResponse);
    }


    public function processResults(string $batchId, string $apiKey, string $targetUrl)
    {
        try {
            // Fetch data from ValueSERP API
            $response = Http::get("https://api.valueserp.com/batches/{$batchId}/results/1", [
                'api_key' => $apiKey
            ]);
    
            if (!$response->successful()) {
                throw new \Exception('Failed to fetch data from ValueSERP API');
            }
    
            $data = $response->json();
    
            // Descargar el archivo JSON desde el enlace de descarga
            $jsonUrl = $data['result']['download_links']['pages'][0] ?? null;
            if ($jsonUrl) {
                $jsonContent = Http::get($jsonUrl)->body();
                $jsonData = json_decode($jsonContent, true);
    
                // Procesar los resultados
                $result = $this->findPositionInResults($jsonData, $targetUrl);
    
                return [
                    'success' => true,
                    'position' => $result['position'],
                    'link' => $result['link'],
                    'timestamp' => now(),
                    'raw_data' => $jsonData // Optional: Store full response if needed
                ];
            } else {
                throw new \Exception('Download link not found');
            }
        } catch (\Exception $e) {
            Log::error('ValueSERP API Error: ' . $e->getMessage());
    
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()
            ];
        }
    }

    private function findPositionInResults(array $apiResponse, string $searchUrl)
    {
        if (!isset($apiResponse['organic_results']) || !is_array($apiResponse['organic_results'])) {
            return ['position' => 'Invalid Response', 'link' => ''];
        }
    
        foreach ($apiResponse['organic_results'] as $result) {
            // Normalize URLs for comparison
            $resultUrl = $this->normalizeUrl($result['link']);
            $targetUrl = $this->normalizeUrl($searchUrl);
    
            if (strpos($resultUrl, $targetUrl) !== false) {
                return [
                    'position' => $result['position'] ?? 'Position Not Available',
                    'link' => $result['link']
                ];
            }
        }
    
        return ['position' => 'Not Found', 'link' => ''];
    }
    /**
     * Normalize URL for comparison
     *
     * @param string $url
     * @return string
     */
    private function normalizeUrl(string $url): string
    {
        // Remove protocol (http/https)
        $url = preg_replace('(^https?://)', '', $url);
        // Remove www
        $url = preg_replace('(^www\.)', '', $url);
        // Remove trailing slash
        $url = rtrim($url, '/');
        // Convert to lowercase
        return strtolower($url);
    }
}
