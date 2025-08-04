<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\GenerateContentService;
use App\Services\GoogleAdsCampaignService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\GoogleAdsCampaign;

class GoogleAdsCampaignController extends Controller
{
    protected $generatorService;



    public function __construct(
        GenerateContentService $contentService

    ) {
        // Inyecta el servicio de Google Ads
        $this->generatorService = $contentService;
    }

    public function index()
    {
        $clients = Client::with(['googleAdsAccounts', 'campaigns'])
            ->whereHas('googleAdsAccounts')
            ->get();
        return view('google.index', compact('clients'));
    }

    public function login($id)
    {
        $client = Client::where('highlevel_id', $id)->first();
        if (!$client) {
            return view('clients.client_404');
        }

        return view('google-ads-campaigns.login', compact('client'));
    }
    // Show form to create new campaign
    public function create($id)
    {
        $client = Client::where('highlevel_id', $id)->with(['googleAdsAccounts'])->first();
        if (!$client) {
            return view('clients.client_404');
        }

        $customer_ids[] = [
            'customer_id' => '1234567890',
            'refresh_token' => '1234567890',
            'is_mcc' => false
        ];

        // if ($customer_ids->isEmpty()) {
        //     return redirect()->route('campaigns.login', ['id' => $id])
        //         ->with('error', 'You don\'t have any associated Google Ads accounts. Please connect one first.');
        // }

        // if (!$client) {
        //     return response()->json([
        //         'success' => false,
        //         'error' => 'Client not found'
        //     ], 404);
        // }

        $templates = [
            'Corporate Limo / Black Car',
            'Airport Limo Pickup',
            'Executive Transportation'
        ];
        return view('google-ads-campaigns.create', compact('templates', 'client', 'customer_ids'));
    }

    public function store(Request $request, $id)
    {
        try {
            $client = Client::where('highlevel_id', $id)->with(['googleAdsAccounts'])->first();
            if (!$client) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Client not found',
                    'icon' => 'x-circle'
                ]);
            }

            // Validate that campaign name is not duplicated
            $existingCampaign = GoogleAdsCampaign::where('campaign_name', $request->input('name_campaign'))
                ->where('status', '!=', 'REMOVED')
                ->first();

            if ($existingCampaign) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'An active campaign with this name already exists. Please choose another name.',
                    'icon' => 'x-circle'
                ]);
            }

            // Validate that Google Ads account exists
            $google = $client->googleAdsAccounts()->where('customer_id', $request->input('google_account'))->first();
            if (!$google) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'The selected Google Ads account does not exist or is not associated with this client.',
                    'icon' => 'x-circle'
                ]);
            }

            // If it's MCC, validate that customerId exists
            if ($google->is_mcc) {
                if (!$request->input('customer_id')) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'You must select a client account to continue.',
                        'icon' => 'x-circle'
                    ]);
                }
                $customerId = $request->input('customer_id');
                $googleAccount = $google->customer_id;
            } else {
                $customerId = $google->customer_id;
                $googleAccount = null;
            }

            $refreshToken = $google->refresh_token;
            $is_mcc = $google->is_mcc;

            // Debug logging
            Log::info('Google Ads Service Initialization', [
                'customerId' => $customerId,
                'is_mcc' => $is_mcc,
                'google_account' => $googleAccount,
                'account_type' => $is_mcc ? 'MCC' : 'Regular'
            ]);

            // Create service instance with client tokens
            if ($is_mcc) {
                Log::info('Initializing MCC Account', [
                    'googleAccount' => $googleAccount,
                    'customerId' => $customerId
                ]);
                $campaignService = new GoogleAdsCampaignService(
                    customerId: $customerId,
                    refreshToken: $refreshToken,
                    isMcc: true,
                    googleAccount: $googleAccount
                );
            } else {
                Log::info('Initializing Regular Account', [
                    'customerId' => $customerId
                ]);
                $campaignService = new GoogleAdsCampaignService(
                    customerId: $customerId,
                    refreshToken: $refreshToken,
                    isMcc: false
                );
            }

            // Process location_data
            $locationData = json_decode($request->input('location_data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid location data format');
            }

            // Process keywords
            $keywords = json_decode($request->input('keywords'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid keywords format');
            }

            // Process generated_ads
            $generatedAds = json_decode($request['generated_ads'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid generated ads format');
            }

            // Process ad_schedule if exists
            $adSchedule = $request['ad_schedule'];
            if (!$adSchedule) {
                throw new \Exception('Campaign schedule is required');
            }

            // Prepare campaign data
            $campaignData = [
                'name_campaign' => $request->input('name_campaign'),
                'campaign_template' => $request->input('campaign_template'),
                'daily_budget' => (float)$request->input('daily_budget'),
                'location_data' => $locationData,
                'keywords' => $keywords,
                'ads' => array_map(function ($ad) {
                    // Validate headlines structure
                    $formattedHeadlines = [];
                    foreach ($ad['headlines'] as $headline) {
                        if (!isset($headline['text'])) {
                            throw new \Exception("Each headline must have a 'text' field");
                        }
                        $formattedHeadlines[] = [
                            'text' => trim($headline['text']),
                            'pinned_field' => $headline['pinned_field'] ?? null
                        ];
                    }

                    // Validate descriptions structure
                    $formattedDescriptions = [];
                    foreach ($ad['descriptions'] as $description) {
                        if (!isset($description['text'])) {
                            throw new \Exception("Each description must have a 'text' field");
                        }
                        $formattedDescriptions[] = [
                            'text' => trim($description['text']),
                            'pinned_field' => $description['pinned_field'] ?? null
                        ];
                    }

                    return [
                        'type' => 'responsive_search_ad',
                        'headlines' => $formattedHeadlines,
                        'descriptions' => $formattedDescriptions,
                        'path1' => trim($ad['path1']),
                        'path2' => trim($ad['path2']),
                        'final_url' => trim($ad['final_url'])
                    ];
                }, $generatedAds),
                'cpc_bid' => 1.0,
                'ad_schedule' => $adSchedule,
                'user_data' => [
                    'highlevel_id' => $client->highlevel_id,
                    'name' => $client->name,
                    'city' => $client->city
                ]
            ];

            $result = $campaignService->createCampaign($campaignData);

            // Save campaign in database
            $campaign = new GoogleAdsCampaign([
                'campaign_name' => $campaignData['name_campaign'],
                'campaign_type' => 'SEARCH',
                'client_id' => $client->id,
                'google_account_id' => $google->id,
                'customer_id' => $customerId,
                'status' => 'ENABLED',
                'campaign_resource_name' => $result['campaign_resource_name'],
                'schedule_resource_name' => $result['schedule_resoyrce_name'],
                'ad_group_resource_name' => $result['ad_group_resource_name'],
                'budget_resource_name' => $result['budget_resource_name'],
                'location_resource_name' => $result['location_resource_name']
            ]);
            $campaign->save();

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Your campaign has been created successfully',
                'icon' => 'check-circle'
            ]);
        } catch (Exception $e) {
            Log::error('Error creating campaign: ' . $e->getMessage(), [
                'client_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Oops!',
                'message' => 'An error occurred while creating the campaign: ' . $e->getMessage(),
                'icon' => 'x-circle'
            ]);
        }
    }


    public function listCampaigns(Request $request,  $id)
    {
        $client = Client::where('highlevel_id', $id)->with(['googleAdsAccounts'])->first();
        if (!$client) {
            return response()->json([
                'success' => false,
                'error' => 'Client not found'
            ], 404);
        }

        $google = $client->googleAdsAccounts()->where('customer_id', $request->input('account_id'))->firstOrFail();

        $customerId = $google->customer_id; // Asume que tienes este campo
        $refreshToken = $google->refresh_token; // Asume que tienes este campo

        // Crear instancia del servicio con los tokens del cliente
        $campaignService = new GoogleAdsCampaignService($customerId, $refreshToken, $google->is_mcc);
        $accounts = $campaignService->listManagedAccounts();

        return response()->json([
            'success' => true,
            'accounts' => $accounts
        ]);
    }


    public function normalizeLocation(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50'
        ]);

        try {
            $city = $request->city;
            $state = $request->state;

            $normalized = [
                'city' => ucwords(strtolower(trim($city))),
                'state' => ucwords(strtolower(trim($state))),
                'state_abbr' => strtoupper(substr(trim($state), 0, 2)),
                'city_abbr' => strtolower(substr(trim($city), 0, 3)),
                'original_city' => $city,
                'original_state' => $state
            ];

            return response()->json([
                'success' => true,
                'normalized' => $normalized,
                'combinations' => [
                    'formats' => [
                        '[{keyword} {city}]',
                        '"{keyword} {city}"',
                        '[{keyword} {city_abbr}]',
                        '"{keyword} {state_abbr}"',
                        '"{keyword} near {city}"',
                        '"{keyword} in {city}"',
                        '"{keyword} {city} {state_abbr}"'
                    ],
                    'replacements' => [
                        '{city}' => $normalized['city'],
                        '{state}' => $normalized['state'],
                        '{state_abbr}' => $normalized['state_abbr'],
                        '{city_abbr}' => $normalized['city_abbr']
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error normalizing the location'
            ], 500);
        }
    }

    public function validateCampaignName($name)
    {
        $existingCampaign = GoogleAdsCampaign::where('campaign_name', $name)
            ->where('status', '!=', 'REMOVED')
            ->first();

        return response()->json([
            'available' => !$existingCampaign
        ]);
    }

    /**
     * Refresca el token de Google Ads para una cuenta específica
     */
    public function refreshToken(Request $request)
    {
        try {
            // Validate input data
            $request->validate([
                'client_id' => 'required|string',
                'account_id' => 'required|string'
            ]);

            $client = Client::where('highlevel_id', $request->client_id)->with(['googleAdsAccounts'])->first();
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client not found'
                ], 404);
            }

            // Validate that Google Ads account exists
            $google = $client->googleAdsAccounts()->where('customer_id', $request->account_id)->first();
            if (!$google) {
                return response()->json([
                    'success' => false,
                    'message' => 'The Google Ads account does not exist or is not associated with this client'
                ], 404);
            }

            // Create service instance
            $campaignService = new GoogleAdsCampaignService(
                customerId: $google->customer_id,
                refreshToken: $google->refresh_token,
                isMcc: $google->is_mcc,
                googleAccount: $google->is_mcc ? $google->customer_id : null
            );

            // Try to validate and refresh token
            if ($campaignService->validateAndRefreshToken()) {
                // Get new token from service
                $newToken = $campaignService->getRefreshToken();
                
                // Update token in database
                $google->update([
                    'refresh_token' => $newToken
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Token refreshed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Token has expired and could not be renewed. Please log in again.',
                    'requires_reauth' => true
                ], 401);
            }
        } catch (\Exception $e) {
            Log::error('Error refreshing Google Ads token', [
                'error' => $e->getMessage(),
                'client_id' => $request->client_id,
                'account_id' => $request->account_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error refreshing token: ' . $e->getMessage()
            ], 500);
        }
    }
}
