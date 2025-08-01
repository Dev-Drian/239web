<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSeo extends Model
{
    use HasFactory;

    protected $table = 'client_seo';

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
