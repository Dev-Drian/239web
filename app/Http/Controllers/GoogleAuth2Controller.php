<?php

namespace App\Http\Controllers;

use App\Models\Client as ModelsClient;
use App\Models\GoogleAdsAccount;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Google\Ads\GoogleAds\Lib\V19\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Util\V19\ResourceNames;
use Google\Ads\GoogleAds\V19\Services\ListAccessibleCustomersRequest;
use Google\Ads\GoogleAds\V19\Services\SearchGoogleAdsRequest;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleAuth2Controller extends Controller
{
    public function callback(Request $request)
    {
        $id = session('client_id');
        $highlevelId = session('highlevel_id');

        // Validar parámetro 'code' de OAuth
        if (!$request->has('code')) {
            Log::error('Missing "code" parameter in Google Ads callback');
            return redirect()->route('campaigns.login', ['id' => $highlevelId])
                ->with('error', 'Authentication error: Missing authorization code.');
        }

        try {
            // 1. Intercambiar 'code' por tokens
            $tokenResponse = Http::post('https://oauth2.googleapis.com/token', [
                'code' => $request->input('code'),
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => route('google.callback'),
                'grant_type' => 'authorization_code'
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('Error in token exchange', [
                    'response' => $tokenResponse->json(),
                    'status' => $tokenResponse->status()
                ]);
                return redirect()->route('campaigns.login', ['id' => $highlevelId])
                    ->with('error', 'Error connecting to Google Ads. Please try again.');
            }

            $tokens = $tokenResponse->json();

            // Validar refresh_token (crítico para operaciones futuras)
            if (empty($tokens['refresh_token'])) {
                Log::error('Google did not return a refresh_token');
                return redirect()->route('campaigns.login', ['id' => $highlevelId])
                    ->with('error', 'Insufficient permissions. Please make sure to select all access options.');
            }

            // 2. Configurar cliente de Google Ads
            $credentials = new UserRefreshCredentials(
                ['https://www.googleapis.com/auth/adwords'],
                [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'refresh_token' => $tokens['refresh_token'],
                ]
            );

            $developerToken = config('services.google.developer_token', '1iLDTpzJ31nqo4u-G42t1g');
            $googleAdsClient = (new GoogleAdsClientBuilder())
                ->withDeveloperToken($developerToken)
                ->withOAuth2Credential($credentials)
                ->build();

            // 3. Listar cuentas accesibles
            $listRequest = new ListAccessibleCustomersRequest();
            $customerService = $googleAdsClient->getCustomerServiceClient();
            $response = $customerService->listAccessibleCustomers($listRequest);
            $resourceNames = $response->getResourceNames();

            if (empty($resourceNames)) {
                Log::warning('User has no accessible accounts');
                return redirect()->route('campaigns.login', ['id' => $highlevelId])
                    ->with('error', 'No Google Ads accounts found linked to this user.');
            }

            // 4. Procesar cada cuenta
            $successfulAccounts = [];
            $inactiveAccounts = [];
            $failedAccounts = [];

            foreach ($resourceNames as $resourceName) {
                $customerId = explode('/', $resourceName)[1];

                try {
                    $clientWithId = (new GoogleAdsClientBuilder())
                        ->withDeveloperToken($developerToken)
                        ->withOAuth2Credential($credentials)
                        ->withLoginCustomerId($customerId)
                        ->build();

                    // Consultar datos básicos + tipo de cuenta
                    $googleAdsService = $clientWithId->getGoogleAdsServiceClient();
                    $query = "SELECT
                    customer.id,
                    customer.descriptive_name,
                    customer.currency_code,
                    customer.time_zone,
                    customer.status,
                    customer.manager,
                    customer.test_account
                FROM customer LIMIT 1";

                    $response = $googleAdsService->search(
                        (new SearchGoogleAdsRequest())
                            ->setCustomerId($customerId)
                            ->setQuery($query)
                    );

                    $customerData = $response->getIterator()->current()->getCustomer();

                    // Verificar si es subcuenta
                    $isSubaccount = false;
                    if (!$customerData->getManager()) {
                        $customerClientService = $clientWithId->getCustomerClientServiceClient();
                        try {
                            $customerClient = $customerClientService->getCustomerClient(
                                ResourceNames::forCustomer($customerId)
                            );
                            $isSubaccount = (bool)$customerClient->getManager();
                        } catch (\Exception $e) {
                            Log::info("Cuenta $customerId no es subcuenta", ['error' => $e->getMessage()]);
                        }
                    }

                    // Guardar en BD
                    GoogleAdsAccount::updateOrCreate(
                        ['customer_id' => $customerId, 'client_id' => $id],
                        [
                            'refresh_token' => $tokens['refresh_token'],
                            'name' => $customerData->getDescriptiveName(),
                            'currency' => $customerData->getCurrencyCode(),
                            'timezone' => $customerData->getTimeZone(),
                            'status' => $customerData->getStatus(),
                            'is_mcc' => $customerData->getManager(),
                            'is_subaccount' => $isSubaccount,
                            'test_account' => $customerData->getTestAccount()
                        ]
                    );

                    $successfulAccounts[] = $customerId;
                } catch (\Google\ApiCore\ApiException $e) {
                    $errorDetails = json_decode($e->getMessage(), true);

                    // Manejar errores específicos
                    if (isset($errorDetails['error']['code'])) {
                        switch ($errorDetails['error']['code']) {
                            case 403: // PERMISSION_DENIED
                                $inactiveAccounts[] = $customerId;
                                Log::warning("Cuenta $customerId deshabilitada o sin permisos");
                                break;
                            case 404: // NOT_FOUND
                                $failedAccounts[] = $customerId;
                                Log::error("Cuenta $customerId no existe");
                                break;
                            default:
                                $failedAccounts[] = $customerId;
                                Log::error("Error de API en cuenta $customerId", ['error' => $errorDetails]);
                        }
                    } else {
                        $failedAccounts[] = $customerId;
                        Log::error("Error desconocido en cuenta $customerId", ['error' => $e->getMessage()]);
                    }
                }
            }

            // 5. Redirección con mensajes contextuales
            $messages = [];

            if (!empty($successfulAccounts)) {
                $messages[] = sprintf(
                    "✅ %d cuenta(s) configurada(s): %s",
                    count($successfulAccounts),
                    implode(', ', $successfulAccounts)
                );
            }

            if (!empty($inactiveAccounts)) {
                $messages[] = sprintf(
                    "⚠️ %d cuenta(s) inactiva(s): %s. Contacta al soporte de Google Ads.",
                    count($inactiveAccounts),
                    implode(', ', $inactiveAccounts)
                );
            }

            if (!empty($failedAccounts)) {
                $messages[] = sprintf(
                    "❌ %d account(s) failed: %s. Check technical logs.",
                    count($failedAccounts),
                    implode(', ', $failedAccounts)
                );
            }

            return redirect()
                ->route('campaigns.create', ['id' => $highlevelId])
                ->with('messages', $messages);
        } catch (\Exception $e) {
            Log::error("Global error in callback", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('campaigns.login', ['id' => $highlevelId])
                ->with('error', 'Critical error: ' . $e->getMessage());
        }
    }

    public function redirectToGoogle($id)
    {
        $client = ModelsClient::where('highlevel_id', $id)->first();
        if (!$client) {
            return view('clients.client_404');
        }


        $state = bin2hex(random_bytes(16));
        session([
            'oauth_state' => $state,
            'client_id' => $client->id,
            'highlevel_id' => $client->highlevel_id,
        ]); // Guardar el ID del cliente en la sesión

        return Socialite::driver('google')
            ->setScopes(['https://www.googleapis.com/auth/adwords'])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent',
                'state' => $state,
                'include_granted_scopes' => 'true'
            ])
            ->redirectUrl(route('google.callback')) // Especifica la URL exacta
            ->redirect();
    }
}
