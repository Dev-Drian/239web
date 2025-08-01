<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ValueSerpService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('VALUESERP_API_KEY', 'B37E061F367A40DDB24C5AB5A8889B02');
        $this->baseUrl = 'https://api.valueserp.com/search';
    }

    public function findKeywordPosition($keyword, $searchUrl, $location)
    {
        try {
            $response = $this->makeRequest($keyword, $location);
            return $this->processResponse($response, $searchUrl, $keyword);
        } catch (\Exception $e) {
            Log::error("ValueSerp API Error: " . $e->getMessage());
            throw $e;
        }
    }

    protected function makeRequest($keyword, $location)
    {
        $response = Http::retry(3, 100)->timeout(30)->get($this->baseUrl, [
            'api_key' => $this->apiKey,
            'q' => $keyword,
            'location' => $location,
            'google_domain' => 'google.com',
            'gl' => 'us',
            'hl' => 'en',
            'num' => '100'
        ]);

        if (!$response->successful()) {
            throw new \Exception('ValueSERP API request failed: ' . $response->body());
        }

        return $response->json();
    }

    protected function processResponse($response, $searchUrl, $keyword)
    {
        $position = 'Not Found';
        $url = '';
        $searchVolume = 0;
        $cpc = 0;
    
        if (isset($response['organic_results']) && is_array($response['organic_results'])) {
            foreach ($response['organic_results'] as $result) {
                if (isset($result['link']) && str_contains($result['link'], $searchUrl)) {
                    $position = $result['position'] ?? 'Not Found';
                    $url = $result['link'] ?? '';
                    break;
                }
            }
        }
    
        return [
            'keyword' => $keyword,
            'position' => $position,
            'url' => $url,
            'search_volume' => $searchVolume,
            'cpc' => $cpc,
            'timestamp' => now()->toIso8601String()
        ];
    }
}