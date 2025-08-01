<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLocation extends Model
{
    use HasFactory;

    protected $table = 'client_locations';

    protected $fillable = [
        'client_id',
        'place_id',
        'formatted_address',
        'formatted_phone_number',
        'lat',
        'lng',
        'street_number',
        'route',
        'gmburl',
        'weekday_text',
        'county',
    ];

    protected $casts = [
        'weekday_text' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
