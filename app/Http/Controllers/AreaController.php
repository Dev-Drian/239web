<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function index($id)
    {
        //agregar luego para que sea dinamico, mientras esta estatico

        $client = Client::where('highlevel_id', $id)->first();
        if (!$client)  return view('clients.client_404');

        return view('area.index', compact('client'));
    }


    public function storeArea(Request $request, $id): JsonResponse
    {
        try {
            // Buscar el cliente por highlevel_id
            $client = Client::where('highlevel_id', $id)->first();


            // Procesar ciudades (combinar seleccionadas y adicionales)
            $areas = $request->areas ?? [];
            if (!empty($request->extra_cities)) {
                // Separar por comas o saltos de línea
                $extraCities = preg_split('/[\n,]+/', $request->extra_cities);
                $extraCities = array_filter(
                    array_map('trim', $extraCities),
                    function ($city) {
                        return !empty($city);
                    }
                );
                $areas = array_merge($areas, $extraCities);
            }

            // Procesar aeropuertos (combinar seleccionados y adicionales)
            $airports = $request->airports ?? [];
            if (!empty($request->extra_airports)) {
                // Separar por comas o saltos de línea
                $extraAirports = preg_split('/[\n,]+/', $request->extra_airports);
                $extraAirports = array_filter(
                    array_map('trim', $extraAirports),
                    function ($airport) {
                        return !empty($airport);
                    }
                );
                $airports = array_merge($airports, $extraAirports);
            }

            // Eliminar posibles duplicados y valores vacíos
            $areas = array_values(array_unique(array_filter($areas)));
            $airports = array_values(array_unique(array_filter($airports)));

            // Validar al menos un área o aeropuerto
            if (empty($areas) && empty($airports)) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least one service area (city or airport) is required'
                ], 422);
            }

            // Guardar los datos
            $client->update([
                'areas' => $areas,
                'airports' => $airports,
                'city' => $request->city,
                'services' => $request->services ?? [],
                'extra_service' => $request->extra_service
            ]);

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Service areas saved successfully',
                'data' => [
                    'city' => $client->city,
                    'areas' => $client->areas,
                    'airports' => $client->airports,
                    'services' => $client->services,
                    'areas_count' => count($client->areas),
                    'airports_count' => count($client->airports),
                    'services_count' => count($client->services)
                ]
            ], 200);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver mensaje de error
            return response()->json([
                'success' => false,
                'message' => 'Error saving service areas: ' . $e->getMessage(),
                'error' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => env('APP_DEBUG') ? $e->getTrace() : null
                ]
            ], 500);
        }
    }

    public function storeFleet(Request $request, $id): JsonResponse
    {
        try {
            // Buscar el cliente
            $client = Client::where('highlevel_id', $id)->first();

            // Verificar si el cliente existe
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $client->cars = json_encode($request->all());
            $client->save();

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Areas saved successfully'
            ], 200);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver mensaje de error
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
}
