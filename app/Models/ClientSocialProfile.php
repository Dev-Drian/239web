<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSocialProfile extends Model
{
    use HasFactory;

    protected $table = 'client_social_profiles';

    protected $fillable = [
        'client_id',
        'type',
        'url',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
