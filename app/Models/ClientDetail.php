<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'year_found',
        'employees',
        'logo_url',
        'video_url',
        'photo1_url',
        'photo2_url',
        'weekday_text',
        'full_name',
        'phone'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    
}
