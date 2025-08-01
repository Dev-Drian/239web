<?php

namespace App\Services;

use App\Models\Client;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Log;

class LicenseService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $client;

    public function __construct()
    {
        $this->baseUrl = env('LICENSE_API_URL');
        $this->consumerKey = env('LICENSE_API_KEY');
        $this->consumerSecret = env('LICENSE_API_SECRET');
        $this->client = new HttpClient();
    }

    public function manageLicense(Client $client, string $action)
    {
        try {
            $url = $this->getApiUrl($client, $action);
            $headers = $this->getHeaders();

            $response = match($action) {
                'create' => $this->client->post($url, ['headers' => $headers]),
                'update' => $this->client->put($url, ['headers' => $headers]),
                'delete' => $this->client->delete($url, ['headers' => $headers]),
                default => throw new \Exception('Acción no válida')
            };

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            }

            throw new \Exception('Error en respuesta de API de licencias');

        } catch (\Exception $e) {
            Log::error('Error en licencia: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getApiUrl(Client $client, string $action): string
    {
        $status = match($action) {
            'create' => 3, // Activo
            'update' => 2, // Entregado
            'delete' => 4, // Inactivo
            default => 1 // Vendido
        };

        $params = [
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
            'product_id' => 88,
            'user_id' => 1,
            'license_key' => $client->highlevel_id,
            'activations_limit' => 3,
            'status' => $status
        ];

        if ($action === 'create') {
            return $this->baseUrl . '?' . http_build_query($params);
        }

        return $this->baseUrl . '/' . $client->highlevel_id . '?' . http_build_query($params);
    }

    protected function getHeaders(): array
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $credentials
        ];
    }
}