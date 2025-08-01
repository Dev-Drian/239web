<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAdsAccount extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function  client(){
        return $this->belongsTo(Client::class);
    }
    public function googleAdsCampaigns()
    {
        return $this->hasMany(GoogleAdsCampaign::class);
    }

}
