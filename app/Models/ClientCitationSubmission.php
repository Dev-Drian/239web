<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCitationSubmission extends Model
{
    use HasFactory;

    protected $table = 'client_citation_submissions';

    protected $fillable = [
        'client_id',
        'submitted_at',
        'form_response',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
