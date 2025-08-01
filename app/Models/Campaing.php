<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaing extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $fillable = [
        'name',
        'sitemap_url',
        'urls_count',
        'status',
        'report_url'
    ];

    public function urls()
    {
        return $this->hasMany(CampaignUrl::class, 'campaign_id');
    }
}
