<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ValueSerpBatchService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.valueserp.com/',
        ]);

        $this->apiKey = env('VALUESERP_API_KEY', 'B37E061F367A40DDB24C5AB5A8889B02');
    }

    public function createBatch($params = [], $keywords = [], $location = null)
    {
        $defaultParams = [
            'notification_email' => env('VALUESERP_NOTIFICATION_EMAIL'),
            'notification_webhook' => env('VALUESERP_NOTIFICATION_WEBHOOK'),
            'notification_as_csv' => true,
            'schedule_type' => 'manual', // Forzar schedule manual
            'searches_type' => 'web' // Forzar búsqueda web
        ];

        // Crear el lote
        $batchResponse = $this->makeRequest('batches', 'POST', array_merge($defaultParams, $params));

        if ($batchResponse['error']) {
            return $batchResponse;
        }

        // Obtener el ID del lote creado
        $batchId = $batchResponse['response']['batch']['id'] ?? null;

        if (!$batchId) {
            return [
                'error' => true,
                'message' => 'Failed to create batch: batch_id not found',
                'response' => null
            ];
        }

        // Añadir palabras clave al lote si existen
        if (!empty($keywords)) {
            $addKeywordsResponse = $this->addKeywordsToBatch($batchId, $keywords, $location);

            if ($addKeywordsResponse['error']) {
                return $addKeywordsResponse;
            }
        }

        return $batchResponse;
    }

    public function addKeywordsToBatch($batchId, array $keywords, $location = null)
    {
        // Crear array de búsquedas con un máximo de 1000 por llamada
        $searches = array_map(function ($keyword) use ($location) {
            $search = [
                'q' => $keyword,
                'google_domain' => 'google.com',
                'gl' => 'us',
                'hl' => 'en',
                'num' => '100',
                'custom_id' => 'search_' . md5($keyword) // ID personalizado opcional
            ];

            if ($location) {
                $search['location'] = $location;
            }

            return $search;
        }, $keywords);

        // Dividir en chunks de 1000 búsquedas si es necesario
        $searchChunks = array_chunk($searches, 1000);
        $results = [];

        foreach ($searchChunks as $chunk) {
            $result = $this->makeRequest("batches/{$batchId}", 'PUT', [
                'searches' => $chunk
            ]);
            $results[] = $result;
        }

        // Verificar si alguno de los resultados tiene error
        foreach ($results as $result) {
            if ($result['error']) {
                return $result;
            }
        }

        return [
            'error' => false,
            'message' => 'Keywords added successfully',
            'response' => $results
        ];
    }

    public function getBatchStatus($batchId)
    {
        return $this->makeRequest("batches/{$batchId}", 'GET');
    }

    public function runBatch($batchId)
    {
        return $this->makeRequest("batches/{$batchId}/start", 'GET');
    }

    public function getBatchResultSet($batchId, $resultSetId)
    {
        $endpoint = "batches/{$batchId}/results/{$resultSetId}/jsonlines";
        return $this->makeRequest($endpoint, 'GET');
    }



    private function makeRequest($endpoint, $method = 'GET', $params = [])
    {
        try {
            $options = [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ];

            // Añadir api_key como query parameter
            $endpoint = $endpoint . (strpos($endpoint, '?') === false ? '?' : '&') . 'api_key=' . $this->apiKey;

            if (!empty($params)) {
                if ($method === 'GET') {
                    $options['query'] = $params;
                } else {
                    $options['json'] = $params;
                    $options['headers']['Content-Type'] = 'application/json';
                }
            }

            $response = $this->client->request($method, $endpoint, $options);

            return [
                'error' => false,
                'message' => null,
                'response' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (RequestException $e) {
            Log::error('ValueSerp API Request Error', [
                'endpoint' => $endpoint,
                'method' => $method,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'error' => true,
                'message' => 'Failed to connect to ValueSerp API: ' . $e->getMessage(),
                'response' => null
            ];
        }
    }
}
