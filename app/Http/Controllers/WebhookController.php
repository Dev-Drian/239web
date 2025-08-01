<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\UserDetail;
use App\Models\Subscription;
use App\Models\UserIp;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function is_premium(Request $request)
    {
        $userIp = $request->header('X-User-IP');
        $cant_reques = 0;

        $userIps = UserIp::where('ip', $userIp)->get();

        $uniqueIps = $userIps->pluck('ip')->unique();
        

        $existingIp = $userIps->where('ip', $userIp)->first();
        if ($existingIp) {
            $existingIp->request_count += 1;
            $existingIp->save();
        } else {
            UserIp::create([
                'ip' => $userIp,
                'request_count' => $cant_reques
            ]);
        }

        return response()->json(true);
    }

    public function storeSubscription(Request $request)
    {
        try {
            $data = $request->json()->all();

            $client = Client::where('highlevel_id', $data['location']['id'] ?? null)->first();
            if (!$client) {
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }

            $client->status = $data['customData']['status'] ?? $client->status;
            $client->save();


            $action = $this->getLicenseAction($client);
            if ($action) {
                $licenseResponse = $this->licenseService->manageLicense($client, $action);

                if (isset($licenseResponse['license_key']) && $action == 'create') {
                    $client->licence_key = $licenseResponse['license_key'];
                }

                if ($action == 'delete') {
                    $client->licence_key = null;
                }
                $client->save();
            }


            // Actualizar suscripción
            $subscription = Subscription::updateOrCreate(
                ['subscription_id' => $data['customData']['subscription_id'] ?? null],
                [
                    'client_id' => $client->id,
                    'plan' => $data['customData']['plan'] ?? null,
                    'amount' => $data['customData']['amount'] ?? 0.00,
                    'subscription_start_date' => $data['customData']['subscription_start_date'] ?? null,
                    'subscription_end_date' => $data['customData']['subscription_end_date'] ?? null,
                    'product_name' => $data['customData']['product_name'] ?? null,
                ]
            );

            // Guardar datos recibidos
            UserDetail::create(['data' => json_encode($data)]);

            return response()->json([
                'message' => 'Data procesada y enviada correctamente',
                'subscription' => $subscription
            ]);
        } catch (\Exception $e) {
            Log::error('Error en suscripción: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error procesando la suscripción',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getLicenseAction(Client $client): ?string
    {
        switch ($client->status) {
            case 'active': // Activo
                return $client->licence_key ? 'update' : 'create';
            case 'scheduled': // Programado
                return 'update';
            case 'cancelled': // Cancelado
                return 'delete';
            default:
                return null;
        }
    }

    public function recibirReserva(Request $request)
    {
        $data = $request->json()->all();

        UserDetail::create(['data' => json_encode($data)]);

        $endpoint_1 = $data['endpoint_1'] ?? null;
        $endpoint_2 = $data['endpoint_2'] ?? null;
        $datos = $data['data'] ?? null;

        $response1 = $response2 = null;

        if ($endpoint_1) {
            $response1 = Http::post($endpoint_1, $datos);
        }

        if ($endpoint_2) {
            $response2 = Http::post($endpoint_2, $datos);
        }

        return response()->json([
            'message' => 'Data procesada y enviada correctamente.',
            'status_1' => $response1?->status(),
            'status_2' => $response2?->status(),
        ]);
    }
}
