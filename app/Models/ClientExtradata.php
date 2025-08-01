<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientExtradata extends Model
{
    use HasFactory;

    protected $table = 'extra_data_clients';

    protected $fillable = [
        'client_id',
        'owner_name',
        'address_line2',
        'state',
        'zip',
        'business_fax',
        'photo_url3',
        'directory_list',
        'instructions_notes',
        'number_of_citations',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}