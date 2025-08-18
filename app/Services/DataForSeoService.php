<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DataForSeoService

{
    protected $baseUrl;
    protected $serpAdvancedUrl;
    protected $username;
    protected $password;
    protected $authKey;

    public function __construct()
    {
        $this->username = env('DATAFORSEO_USERNAME', 'info@page1ranking.com');
        $this->password = env('DATAFORSEO_PASSWORD', 'wJxJDgKT0xLxMFTf');
        $this->authKey = base64_encode($this->username . ':' . $this->password);
        $this->baseUrl = 'https://api.dataforseo.com/v3/dataforseo_labs/google/historical_search_volume/live';
        // Use the correct SERP API endpoint that returns real position data
        $this->serpAdvancedUrl = 'https://api.dataforseo.com/v3/serp/google/organic/live/advanced';
    }
    public function getKeywordData(array $keywords, int $locationCode = 2840, string $languageName = 'en')
    {
        try {
            $response = $this->makeRequest($keywords, $locationCode, $languageName);

            // Log the response for debugging
            Log::info('DataForSEO Search Volume Response', [
                'response_keys' => array_keys($response),
                'tasks_count' => count($response['tasks'] ?? []),
                'full_response' => $response
            ]);

            $processed = $this->processResponse($response, $keywords);

            // Log the processed data for debugging
            Log::info('DataForSEO Processed Search Volume Data', [
                'processed_data' => $processed
            ]);

            return $processed;
        } catch (\Exception $e) {
            Log::error("DataForSEO API Error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get live SERP positions and URLs for given keywords
     */
    public function getSerpPositions(array $keywords, string $domain, int $locationCode = 2840, string $languageCode = 'en', string $device = 'desktop')
    {
        try {
            // Use the full domain URL as target, not just the host
            $targetUrl = $domain;
            if (stripos($domain, 'http') !== 0) {
                $targetUrl = 'https://' . $domain;
            }

            // Extract target domain from URL
            $targetDomain = parse_url($targetUrl, PHP_URL_HOST);
            if ($targetDomain) {
                $targetDomain = preg_replace('/^www\./i', '', $targetDomain);
            }

            // For SERP API advanced, we need to send each keyword as a separate task with additional parameters
            $tasks = [];
            foreach ($keywords as $idx => $keyword) {
                $tasks[] = [
                    'keyword' => $keyword,
                    'location_code' => $locationCode,
                    'language_code' => $languageCode ?: 'en',
                    'device' => in_array($device, ['desktop', 'mobile', 'tablet']) ? $device : 'desktop',
                    'os' => $device === 'mobile' ? 'android' : 'windows',
                    'depth' => 10,
                    // Remove target parameter temporarily to see if it's causing the issue
                    // 'target' => $targetUrl,
                ];
            }

            // Log the request for debugging
            Log::info('DataForSEO SERP Request', [
                'url' => $this->serpAdvancedUrl,
                'tasks' => $tasks,
                'target_url' => $targetUrl,
                'target_domain' => $targetDomain,
                'request_payload' => json_encode($tasks, JSON_PRETTY_PRINT)
            ]);

            // Send the request - the API expects an array of arrays
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->authKey,
                'Content-Type' => 'application/json'
            ])->retry(3, 100)->timeout(60)->post($this->serpAdvancedUrl, $tasks);

            if (!$response->successful()) {
                throw new \Exception('SERP API request failed: ' . $response->body());
            }

            $json = $response->json();

            // Log the full response for debugging
            Log::info('DataForSEO SERP Response', [
                'status' => $response->status(),
                'response_keys' => array_keys($json),
                'tasks_count' => count($json['tasks'] ?? []),
                'full_response' => $json
            ]);

            // Extract best organic ranking for target domain
            $results = [];
            if (isset($json['tasks']) && is_array($json['tasks'])) {
                foreach ($json['tasks'] as $taskIndex => $task) {
                    // Fix: keyword is in task->data->keyword, not directly in task
                    $keyword = $task['data']['keyword'] ?? $task['keyword'] ?? 'unknown';

                    Log::info("Processing task {$taskIndex}", [
                        'task_keys' => array_keys($task),
                        'data_keys' => array_keys($task['data'] ?? []),
                        'extracted_keyword' => $keyword,
                        'task_keyword' => $task['keyword'] ?? 'not_found',
                        'data_keyword' => $task['data']['keyword'] ?? 'not_found'
                    ]);

                    // Extract SERP metadata
                    $serpDatetime = null;
                    $seDomain = null;
                    if (isset($task['result'][0])) {
                        $serpDatetime = $task['result'][0]['datetime'] ?? null;
                        $seDomain = $task['result'][0]['se_domain'] ?? null;
                    }

                    // Find organic items that match target domain
                    $matchingItems = [];
                    $items = $task['result'][0]['items'] ?? [];

                    foreach ($items as $item) {
                        if (($item['type'] ?? '') === 'organic') {
                            $itemUrl = $item['url'] ?? '';
                            $itemDomain = $item['domain'] ?? '';

                            // Check if URL starts with target URL or domain matches
                            $urlMatches = !empty($itemUrl) && stripos($itemUrl, $targetUrl) === 0;
                            $domainMatches = !empty($itemDomain) && stripos($itemDomain, $targetDomain) === 0;

                            if ($urlMatches || $domainMatches) {
                                $matchingItems[] = [
                                    'rank_absolute' => $item['rank_absolute'] ?? $item['rank_group'] ?? null,
                                    'url' => $itemUrl,
                                    'domain' => $itemDomain
                                ];
                            }
                        }
                    }

                    // Find best position (minimum rank_absolute)
                    $bestPosition = 'no_ranked';
                    $bestUrl = null;

                    if (!empty($matchingItems)) {
                        $validRanks = array_filter(array_column($matchingItems, 'rank_absolute'), function($rank) {
                            return is_numeric($rank) && $rank > 0;
                        });

                        if (!empty($validRanks)) {
                            $bestPosition = min($validRanks);
                            // Find the item with the best position
                            foreach ($matchingItems as $item) {
                                if (($item['rank_absolute'] ?? $item['rank_group'] ?? null) == $bestPosition) {
                                    $bestUrl = $item['url'];
                                    break;
                                }
                            }
                        }
                    }

                    $results[] = [
                        'keyword' => $keyword,
                        'domain' => $targetDomain,
                        'best_position' => $bestPosition,
                        'best_url' => $bestUrl,
                        'items_considered' => count($matchingItems),
                        'serp_datetime' => $serpDatetime,
                        'se_domain' => $seDomain,
                        'matching_items' => $matchingItems, // For debugging
                        'target_url' => $targetUrl,
                        'target_domain' => $targetDomain
                    ];
                }
            }

            Log::info('Extracted SERP results', ['results' => $results]);
            return $results;

        } catch (\Exception $e) {
            Log::error('DataForSEO SERP Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get comprehensive keyword data including search volume and SERP positions
     */
    public function getComprehensiveKeywordData(array $keywords, string $domain, int $locationCode = 2840, string $languageCode = 'en', string $device = 'desktop')
    {
        try {
            // Get search volume data
            $volumeData = $this->getKeywordData($keywords, $locationCode, $languageCode);

            // Get SERP positions
            $serpData = $this->getSerpPositions($keywords, $domain, $locationCode, $languageCode, $device);

            // Combine the data
            $results = [];
            $volumeMap = [];

            // Create a map of volume data by keyword
            if (!isset($volumeData['error'])) {
                foreach ($volumeData as $item) {
                    $volumeMap[strtolower(trim($item['keyword']))] = $item;
                }
            }

            // Create a map of SERP data by keyword
            $serpMap = [];
            foreach ($serpData as $item) {
                $serpMap[strtolower(trim($item['keyword']))] = $item;
            }

            // Combine both datasets
            foreach ($keywords as $keyword) {
                $kwLower = strtolower(trim($keyword));
                $volume = $volumeMap[$kwLower] ?? null;
                $serp = $serpMap[$kwLower] ?? null;

                $results[] = [
                    'keyword' => $keyword,
                    'position' => $serp['position'] ?? null,
                    'url' => $serp['url'] ?? null,
                    'cpc' => $volume['cpc'] ?? null,
                    'search_volume' => $volume['search_volume'] ?? null,
                    'difficulty' => $volume['difficulty'] ?? null,
                    'target_found' => $serp['target_found'] ?? false,
                    'target_position' => $serp['target_position'] ?? null,
                    'target_url' => $serp['target_url'] ?? null,
                    'first_organic_position' => $serp['first_organic_position'] ?? null,
                    'first_organic_url' => $serp['first_organic_url'] ?? null,
                ];
            }

            return $results;
        } catch (\Exception $e) {
            Log::error('DataForSEO Comprehensive Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Test method to check API connectivity and response structure
     */
    public function testApiConnection()
    {
        try {
            Log::info('Testing DataForSEO API connection');

            // First validate credentials
            $credentialCheck = $this->validateCredentials();
            Log::info('Credential validation result', $credentialCheck);

            if (!$credentialCheck['valid']) {
                return [
                    'credentials_valid' => false,
                    'error' => 'Invalid credentials: ' . ($credentialCheck['error'] ?? 'Unknown error')
                ];
            }

            // Test with a single keyword first to debug the SERP API
            $testKeywords = ['bank account opening'];
            $testDomain = 'https://www.bankofamerica.com';

            // Test search volume API
            $volumeResponse = $this->getKeywordData($testKeywords, 2840, 'en');
            Log::info('Search Volume API Test Response', ['response' => $volumeResponse]);

            // Test SERP API with single keyword
            $serpResponse = $this->getSerpPositions($testKeywords, $testDomain, 2840, 'en', 'desktop');
            Log::info('SERP API Test Response (Single Keyword)', ['response' => $serpResponse]);

            return [
                'credentials_valid' => true,
                'volume_api_working' => !isset($volumeResponse['error']),
                'serp_api_working' => !isset($serpResponse['error']),
                'volume_response' => $volumeResponse,
                'serp_response' => $serpResponse,
                'credential_check' => $credentialCheck
            ];
        } catch (\Exception $e) {
            Log::error('DataForSEO API Test Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Validate API credentials by making a simple test request
     */
    public function validateCredentials()
    {
        try {
            Log::info('Validating DataForSEO API credentials', [
                'username' => $this->username,
                'auth_key_length' => strlen($this->authKey)
            ]);

            // Make a simple test request to check if credentials work
            $testData = [
                [
                    'keywords' => ['test'],
                    'location_code' => 2840,
                    'language_code' => 'en',
                    'include_serp_info' => false,
                    'include_clickstream_data' => false
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->authKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(30)
                ->post($this->baseUrl, $testData);

            Log::info('Credential validation response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $json = $response->json();
                return [
                    'valid' => true,
                    'status' => $response->status(),
                    'response' => $json
                ];
            } else {
                return [
                    'valid' => false,
                    'status' => $response->status(),
                    'error' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Credential validation error: ' . $e->getMessage());
            return [
                'valid' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    protected function normalizeHostFromDomain(string $domain): string
    {
        $domain = trim($domain);
        if (stripos($domain, 'http') !== 0) {
            $domain = 'https://' . $domain;
        }
        $host = parse_url($domain, PHP_URL_HOST) ?: $domain;
        return preg_replace('/^www\./i', '', strtolower($host));
    }

    protected function matchesHost(string $needleHost, string $haystackHost): bool
    {
        $h = preg_replace('/^www\./i', '', strtolower($haystackHost ?: ''));
        if ($needleHost === '' || $h === '') return false;

        // Exact match
        if ($needleHost === $h) return true;

        // Subdomain match (endsWith)
        if (str_ends_with($h, '.' . $needleHost)) return true;

        // Parent domain match (needle is subdomain of haystack)
        if (str_ends_with($needleHost, '.' . $h)) return true;

        // Partial match for similar domains
        $needleParts = explode('.', $needleHost);
        $haystackParts = explode('.', $h);

        if (count($needleParts) >= 2 && count($haystackParts) >= 2) {
            // Check if main domain parts match (e.g., "example" from "example.com")
            if ($needleParts[count($needleParts) - 2] === $haystackParts[count($haystackParts) - 2]) {
                return true;
            }
        }

        return false;
    }

    protected function urlContainsHost(string $url, string $host): bool
    {
        $uHost = parse_url($url, PHP_URL_HOST) ?: '';
        $uHost = preg_replace('/^www\./i', '', strtolower($uHost));
        if ($host === '' || $uHost === '') return false;

        // Exact match
        if ($uHost === $host) return true;

        // Subdomain match
        if (str_ends_with($uHost, '.' . $host)) return true;

        // Parent domain match
        if (str_ends_with($host, '.' . $uHost)) return true;

        // Partial match for similar domains
        $hostParts = explode('.', $host);
        $urlParts = explode('.', $uHost);

        if (count($hostParts) >= 2 && count($urlParts) >= 2) {
            if ($hostParts[count($hostParts) - 2] === $urlParts[count($urlParts) - 2]) {
                return true;
            }
        }

        return false;
    }

    protected function makeRequest(array $keywords, string $locationCode, string $languageName)
    {
        $data = [
            [
                'keywords' => $keywords,
                'location_code' => $locationCode,
                'language_code' => $languageName ?: 'en',
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
        // Create a map of all requested keywords with default values
        $keywordMap = [];
        foreach ($keywords as $keyword) {
            $keywordMap[strtolower(trim($keyword))] = [
                'keyword' => $keyword,
                'cpc' => 0,
                'search_volume' => 0,
                'difficulty' => 'Not Available',
                'found' => false
            ];
        }

        // If no results from API, return all keywords with default values
        if (!isset($response['tasks'][0]['result']) || empty($response['tasks'][0]['result'])) {
            Log::info('No search volume data found in API response, returning default values for all keywords', [
                'requested_keywords' => $keywords,
                'api_response' => $response
            ]);
            return array_values($keywordMap);
        }

        $results = [];

        // Process API results and update the map
        foreach ($response['tasks'][0]['result'] as $result) {
            foreach ($result['items'] ?? [] as $item) {
                if (!isset($item['keyword_info'])) {
                    continue;
                }

                $keyword = $item['keyword'] ?? 'Unknown';
                $keywordLower = strtolower(trim($keyword));

                // Update the keyword map with real data
                if (isset($keywordMap[$keywordLower])) {
                    $keywordMap[$keywordLower] = [
                        'keyword' => $keyword,
                        'cpc' => $item['keyword_info']['cpc'] ?? 0,
                        'search_volume' => $item['keyword_info']['search_volume'] ?? 0,
                        'difficulty' => $item['keyword_info']['competition_level'] ?? 'Not Available',
                        'found' => true
                    ];
                }
            }
        }

        // Return all keywords (with real data if available, default values if not)
        $results = array_values($keywordMap);

        Log::info('Processed search volume response', [
            'total_keywords_requested' => count($keywords),
            'keywords_with_data' => count(array_filter($results, fn($r) => $r['found'])),
            'keywords_without_data' => count(array_filter($results, fn($r) => !$r['found'])),
            'results' => $results
        ]);

        return $results;
    }

}
