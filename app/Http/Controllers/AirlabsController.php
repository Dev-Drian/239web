<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Country;
use App\Models\City;
use App\Models\Client;
use App\Services\AirlabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AirlabsController extends Controller
{
    protected $airlabsService;

    public function __construct(AirlabsService $airlabsService)
    {
        $this->airlabsService = $airlabsService;
    }

    public function index()
    {
        return view('airlabs.index');
    }

    public function request()
    {
        $airlines = Airline::all();
        $airports   = Airport::all();
        $cities = City::where('country_code', 'US')->get(); // Filtrar ciudades por código de país 'US'

        return view('airlabs.request', compact('airlines', 'cities', 'airports'));
    }
    public function request_guest($id)
    {
        $user = Client::where('highlevel_id', $id)->first();

        if (!$user) {
            return view('clients.client_404');
        }

        $airlines = Airline::all();
        $airports   = Airport::all();
        $cities = City::where('country_code', 'US')->get(); // Filtrar ciudades por código de país 'US'

        return view('airlabs.request-guest', compact('id', 'airlines', 'cities', 'airports'));
    }

    public function showFlight($id, Request $request)
    {
        $user = Client::where('highlevel_id', $id)->first();

        if (!$user) {
            return view('clients.client_404');
        }
        $flightIcao = $request->input('flight_icao');
        $flightIata = $request->input('flight_iata');

        $params = [];
        if (!empty($flightIcao)) {
            $params['flight_icao'] = $flightIcao;
        }
        if (!empty($flightIata)) {
            $params['flight_iata'] = $flightIata;
        }

        $flightsResponse = $this->airlabsService->getFlights($params);

        // Log para debug
        Log::info('Requesting flights with params:', $params);
        Log::info('API Response:', ['response' => $flightsResponse]);

        if (isset($flightsResponse['error']) && $flightsResponse['error']) {
            return view('clients.client_404');
        }

        $flights = $flightsResponse['response'];

        return view('airlabs.show-flight', compact('flights'));
        return view('airlabs.show-flight');
    }




    public function getFlights(Request $request)
    {
        $params = [];

        $direction = $request->input('direction');
        $airportIata = $request->input('airportIata');
        $airlineIata = $request->input('airline_iata');
        $flightIcao = $request->input('flight_icao');


        // Solo agregamos parámetros si tienen valores
        if (!empty($airlineIata)) {
            $params['airline_iata'] = $airlineIata;
        }


        if (!empty($flightIcao)) {
            $params['flight_icao'] = $flightIcao;
        }

        if (!empty($direction) && !empty($airportIata)) {
            if ($direction === 'inbound') {
                $params['arr_icao'] = $airportIata;
            } elseif ($direction === 'outbound') {
                $params['dep_icao'] = $airportIata;
            }
        }
        $params['flag'] = 'US';

        $flights = $this->airlabsService->getFlights($params);

        // Log para debug
        Log::info('Requesting flights with params:', $params);

        $flights = $this->airlabsService->getFlights($params);

        // Log la respuesta para debug
        Log::info('API Response:', ['response' => $flights]);

        if (isset($flights['error']) && $flights['error']) {
            return response()->json(['error' => $flights['message']], 400);
        }

        return response()->json($flights['response']);
    }



    public function sincronizarCiudades()
    {
        try {
            DB::beginTransaction();
            $countryCode = "US";

            $citiesData = $this->airlabsService->getAllCities($countryCode);

            if ($citiesData['error']) {
                throw new \Exception('Error al obtener datos de la API');
            }

            foreach ($citiesData['response'] as $cityData) {
                if (!isset($cityData['city_code']) || empty($cityData['city_code'])) {
                    Log::warning('City data missing city_code', ['cityData' => $cityData]);
                    continue;
                }

                City::updateOrCreate(
                    ['city_code' => $cityData['city_code']],
                    [
                        'name' => $cityData['name'],
                        'country_code' => $cityData['country_code']
                    ]
                );
            }

            DB::commit();
            return response()->json(['message' => 'Sincronización de ciudades completada con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en sincronización: ' . $e->getMessage());
            return response()->json(['message' => 'Error en sincronización: ' . $e->getMessage()], 500);
        }
    }

    public function sincronizarDatos()
    {
        try {
            DB::beginTransaction();

            // Obtener datos de la API
            $airportsData = $this->airlabsService->getAllAirports();
            $airlinesData = $this->airlabsService->getAllAirlines();

            // Verificar si hay errores en las respuestas
            if ($airportsData['error'] || $airlinesData['error']) {
                throw new \Exception('Error al obtener datos de la API');
            }

            // Sincronizar aeropuertos
            foreach ($airportsData['response'] as $airportData) {
                if (!isset($airportData['iata_code']) || empty($airportData['iata_code'])) {
                    Log::warning('Airport data missing iata_code', ['airportData' => $airportData]);
                    continue; // Saltar este registro si no tiene iata_code
                }

                Airport::updateOrCreate(
                    ['iata_code' => $airportData['iata_code']],
                    [
                        'name' => $airportData['name'],
                        'icao_code' => $airportData['icao_code'] ?? null,
                        'lat' => $airportData['lat'] ?? 0,
                        'lng' => $airportData['lng'] ?? 0,
                        'country_code' => $airportData['country_code'],
                    ]
                );
            }

            // Sincronizar aerolíneas
            foreach ($airlinesData['response'] as $airlineData) {
                if (!isset($airlineData['iata_code']) || empty($airlineData['iata_code'])) {
                    Log::warning('Airline data missing iata_code', ['airlineData' => $airlineData]);
                    continue; // Saltar este registro si no tiene iata_code
                }

                Airline::updateOrCreate(
                    ['iata_code' => $airlineData['iata_code']],
                    [
                        'name' => $airlineData['name'],
                        'icao_code' => $airlineData['icao_code'] ?? null,
                    ]
                );
            }

            DB::commit();
            return response()->json(['message' => 'Sincronización de datos completada con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en sincronización: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAirlines($countryCode = "US")
    {
        $airlines = $this->airlabsService->getAllAirlines($countryCode);

        if (!$airlines['error']) {
            return response()->json($airlines['response']);
        }

        return response()->json(['error' => $airlines['message']], 400);
    }

    public function getAirports($countryCode = "US")
    {
        $airports = $this->airlabsService->getAllAirports($countryCode);

        if (!$airports['error']) {
            return response()->json($airports['response']);
        }

        return response()->json(['error' => $airports['message']], 400);
    }

    public function getSelectAiports(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 30;

        $query = Airport::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('icao_code', 'like', "%{$search}%")
                ->orWhere('iata_code', 'like', "%{$search}%");
        }

        $total = $query->count();
        $airports = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'items' => $airports->map(function ($airport) {
                return [
                    'id' => $airport->icao_code,
                    'text' => "{$airport->name} ({$airport->iata_code})"
                ];
            }),
            'total_count' => $total
        ]);
    }
    public function getSelectAirlines(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 30;

        $query = Airline::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('iata_code', 'like', "%{$search}%");
        }

        $total = $query->count();
        $airlines = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'items' => $airlines->map(function ($airline) {
                return [
                    'id' => $airline->iata_code,
                    'text' => "{$airline->name} ({$airline->iata_code})"
                ];
            }),
            'total_count' => $total
        ]);
    }
}
