<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUrl extends Model
{
    use HasFactory;
    protected $fillable = [
        'campaign_id',
        'url',
        'status_code',
        'response_time',
        'last_crawled_at',
        'created_at',
        'updated_at'
    ];
}
