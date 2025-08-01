<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class AirlabsService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://airlabs.co/api/v9/',
        ]);

        $this->apiKey = env('AIRLABS_API_KEY');
    }

    public function getAllCountries($code = null)
    {
        return $this->makeRequest('countries', ['code' => $code]);
    }

    public function getAllCities($countryCode = null)
    {
        return $this->makeRequest('cities', ['country_code' => $countryCode]);
    }




    public function getFlights($params = [])
    {
        Log::info('Airlabs API Request Parameters:', $params);
        $result = $this->makeRequest('flights', $params);
        Log::info('Airlabs API Response:', ['response' => $result]);
        return $result;
    }

    public function getAllAirlines($countryCode = null)
    {
        return $this->makeRequest('airlines', ['country_code' => $countryCode]);
    }

    public function getAllAirports($countryCode = null)
    {
        return $this->makeRequest('airports', ['country_code' => $countryCode]);
    }



    private function makeRequest($endpoint, $params = [])
    {
        try {
            $queryParams = array_merge(['api_key' => $this->apiKey], $params);

            $response = $this->client->get($endpoint, [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the API response contains error information
            if (isset($data['error']) && $data['error']) {
                return [
                    'error' => true,
                    'message' => $data['error']['message'] ?? 'API error occurred',
                    'response' => null
                ];
            }

            return [
                'error' => false,
                'message' => null,
                'response' => $data['response'] ?? []
            ];
        } catch (RequestException $e) {
            Log::error('Airlabs API Request Error', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'error' => true,
                'message' => 'Failed to connect to Airlabs API: ' . $e->getMessage(),
                'response' => null
            ];
        }
    }
}
