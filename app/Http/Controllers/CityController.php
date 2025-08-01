<?php

namespace App\Http\Controllers;

use App\Models\CityExcel;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getSelectCities(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 30;

        $query = CityExcel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                    ->orWhere('state_code', 'like', "%{$search}%")
                    ->orWhere('state_name', 'like', "%{$search}%")
                    ->orWhere('county', 'like', "%{$search}%");
            });
        }

        $total = $query->count();
        $cities = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'items' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'text' => "{$city->city}, {$city->state_code}" // Formato: "Ciudad, Código de Estado"
                ];
            }),
            'total_count' => $total
        ]);
    }

    public function getCity(Request $request)
    {
        $search = trim($request->get('q'));
        $page = $request->get('page', 1);
        $limit = 30;

        $query = CityExcel::query();

        if ($search) {
            $searchLower = strtolower($search);
            $query->where(function ($q) use ($search, $searchLower) {
                $q->whereRaw('LOWER(city) LIKE ?', ["%{$searchLower}%"])
                    ->orWhere('state_code', 'like', "%{$search}%")
                    ->orWhere('state_name', 'like', "%{$search}%")
                    ->orWhere('county', 'like', "%{$search}%");
            });

            // Ordenar por coincidencia exacta primero
            $query->orderByRaw("
                CASE 
                    WHEN LOWER(city) = ? THEN 0
                    WHEN LOWER(city) LIKE ? THEN 1
                    ELSE 2
                END ASC,
                city ASC
            ", [$searchLower, "{$searchLower}%"]);
        }

        $total = $query->count();

        $cities = $query->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return response()->json([
            'status' => true, // Indica que la respuesta es exitosa
            'data' => [
                'locations' => $cities->map(function ($city) {
                    return [
                        'id' => $city->id,
                        'name' => $city->city,
                        'country_code' => $city->state_code, // Usa state_code como country_code
                        'state_code' => $city->state_code,
                        'state_name' => $city->state_name,
                        'county' => $city->county,
                        'latitude' => $city->latitude,
                        'longitude' => $city->longitude
                    ];
                }),
                'info' => [
                    'total_locations' => $total // Total de ubicaciones encontradas
                ]
            ]
        ]);
    }
}
