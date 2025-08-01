<?php

// app/Models/GoogleAdsCampaign.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAdsCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_name',
        'campaign_type',
        'status',
        'client_id',
        'google_account_id',
        'customer_id',
        'campaign_resource_name',
        'schedule_resource_name',
        'ad_group_resource_name',
        'budget_resource_name',
        'location_resource_name'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAdsAccount::class, 'google_account_id');
    }
}
