<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class UrlSubmissionService
{
    private $apiKey;

    public function __construct()
    {
        // Configura la API key (puedes obtenerla de un archivo de configuración o .env)
        $this->apiKey = '08c555a983460506c7cbe642cf409c79';
    }

    /**
     * Envía las URLs a la API externa.
     *
     * @param array $urls
     * @param string $campaign
     * @return array
     */
    public function submitUrls(array $urls, string $campaign): array
    {
        // Validamos que las URLs sean un array
        if (!is_array($urls)) {
            return [
                'status' => 'error',
                'message' => 'El campo "urls" debe ser un array.',
            ];
        }

        // Preparamos la cadena de consulta para la API
        $qstring = 'apikey=' . $this->apiKey . '&cmd=submit&campaign=' . urlencode($campaign) . '&urls=' . urlencode(implode('|', $urls)) . '&dripfeed=1&reporturl=1&method=vip';

        // Configuramos cURL para enviar la solicitud a la API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://speed-links.net/api.php');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);

        // Ejecutamos la solicitud y obtenemos la respuesta
        $result = curl_exec($ch);

        // Manejo de errores de cURL
        if ($result === false) {
            $errorMessage = 'Error en la solicitud cURL: ' . curl_error($ch);
            curl_close($ch);
            Log::error($errorMessage);
            return [
                'status' => 'error',
                'message' => $errorMessage,
            ];
        }

        curl_close($ch);

        // Procesamos la respuesta de la API
        if (strpos($result, 'OK|') === 0) {
            // Extraemos el enlace de la respuesta
            list($status, $reportUrl) = explode('|', $result);
            return [
                'status' => 'success',
                'message' => "Campaña '$campaign' enviada exitosamente",
                'report_url' => $reportUrl,
                'urls' => $urls,
            ];
        } elseif (strpos($result, 'ERROR') !== false) {
            return [
                'status' => 'error',
                'message' => $result,
            ];
        } else {
            return [
                'status' => 'unknown',
                'message' => $result,
            ];
        }
    }
}