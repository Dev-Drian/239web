<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSocial extends Model
{
    use HasFactory;

    protected $table = 'client_social_media';

    protected $fillable = [
        'client_id',
        'social_links',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
