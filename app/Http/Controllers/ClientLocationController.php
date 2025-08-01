<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientLocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientLocationController extends Controller
{
    protected $clientLocationService;

    public function __construct(ClientLocationService $clientLocationService)
    {
        $this->clientLocationService = $clientLocationService;
    }

    public function store(Request $request)
    {
        
        // Validar los datos del request
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'place_id' => 'nullable|string',
            'formatted_address' => 'nullable|string',
            'formatted_phone_number' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'street_number' => 'nullable|string',
            'route' => 'nullable|string',
            'gmburl' => 'nullable|string',
            'weekday_text' => 'nullable|array',
            'county' => 'nullable|string',
            'year_found' => 'nullable|string',
            'employees' => 'nullable|string',
            'business_phone' => 'nullable|string',
            'social_media' => 'nullable|string',
        ]);
    
        try {
            DB::beginTransaction();

            $client = Client::find($request->client_id);
            if (!$client) {
                throw new \Exception('Client not found');
            }
            $client->email = $request->business_email;
            $client->city = $request->city;
            $client->website = $request->website;
            $client->save();
    
            $location = $this->clientLocationService->insertOrUpdateClientLocation($validatedData);
            $detail = $this->clientLocationService->insertOrUpdateClientDetail($validatedData);
            $social = $this->clientLocationService->insertOrUpdateClientSocial($validatedData);
            
    
            if (!$location || !$detail || !$social) {
                throw new \Exception('Failed to save client data');
            }
    
            DB::commit();
    
            return response()->json([
                'message' => 'Client data saved successfully',
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'message' => 'Failed to save client data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}