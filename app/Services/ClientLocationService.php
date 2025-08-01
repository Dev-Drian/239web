<?php

namespace App\Services;

use App\Models\ClientDetail;
use App\Models\ClientLocation;
use App\Models\ClientSocial;

class ClientLocationService
{
    public function insertOrUpdateClientLocation(array $data)
    {
        return ClientLocation::updateOrCreate(
            ['client_id' => $data['client_id']],
            [
                'place_id' => $data['place_id'] ?? null,
                'formatted_address' => $data['formatted_address'] ?? null,
                'formatted_phone_number' => $data['formatted_phone_number'] ?? null,
                'lat' => $data['lat'] ?? null,
                'lng' => $data['lng'] ?? null,
                'street_number' => $data['street_number'] ?? null,
                'route' => $data['route'] ?? null,
                'gmburl' => $data['gmburl'] ?? null,
                'weekday_text' => isset($data['weekday_text']) ? json_encode($data['weekday_text']) : null,
                'county' => $data['county'] ?? null,
            ]
        );
    }
    public function insertOrUpdateClientDetail(array $data)
    {
        return ClientDetail::updateOrCreate(
            ['client_id' => $data['client_id']],
            [
                'year_found' => $data['year_found'] ?? null,
                'employees' => $data['employees'] ?? null,
                'phone' => $data['formatted_phone_number'] ?? null,
            ]
        );
    }

    public function insertOrUpdateClientSocial(array $data)
    {
        return ClientSocial::updateOrCreate(
            ['client_id' => $data['client_id']],
            [
                'social_links' => $data['social_media'] ?? null,
            ]
        );
    }
    
}