<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DataForSeoService

{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $authKey;

    public function __construct()
    {
        $this->username = env('DATAFORSEO_USERNAME', 'info@page1ranking.com');
        $this->password = env('DATAFORSEO_PASSWORD', 'wJxJDgKT0xLxMFTf');
        $this->authKey = base64_encode($this->username . ':' . $this->password);
        $this->baseUrl = 'https://api.dataforseo.com/v3/dataforseo_labs/google/historical_search_volume/live';
    }
    public function getKeywordData(array $keywords, int $locationCode = 2840, string $languageName = 'English')
    {
        try {
            $response = $this->makeRequest($keywords, $locationCode, $languageName);
            return $this->processResponse($response, $keywords);
        } catch (\Exception $e) {
            Log::error("DataForSEO API Error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    protected function makeRequest(array $keywords, string $locationCode, string $languageName)
    {
        $data = [
            [
                'keywords' => $keywords,
                'location_code' => $locationCode,
                'language_code' => $languageName,
                'include_serp_info' => false,
                'include_clickstream_data' => false
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->authKey,
            'Content-Type' => 'application/json'
        ])
            ->retry(3, 100)
            ->timeout(30)
            ->post($this->baseUrl, $data);

        if (!$response->successful()) {
            throw new \Exception("API request failed: " . $response->body());
        }

        return $response->json();
    }

    protected function processResponse(array $response, array $keywords)
    {
        if (!isset($response['tasks'][0]['result']) || empty($response['tasks'][0]['result'])) {
            return [
                'error' => 'Data not found in API response',
                'api_response' => $response
            ];
        }
    
        $results = [];
    
        foreach ($response['tasks'][0]['result'] as $result) {
            foreach ($result['items'] ?? [] as $item) {
                if (!isset($item['keyword_info'])) {
                    continue;
                }
    
                $results[] = [
                    'keyword' => $item['keyword'] ?? 'Unknown', 
                    'cpc' => $item['keyword_info']['cpc'] ?? 0,
                    'search_volume' => $item['keyword_info']['search_volume'] ?? 0,
                    'difficulty' => $item['keyword_info']['competition_level'] ?? 'Not Available'
                ];
            }
        }
    
        return $results;
    }
    
}
