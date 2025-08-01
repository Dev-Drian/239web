<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'services' => 'array',
        'areas' => 'array',
        'subscriptions' => 'array',
    ];

    public function  leads()
    {
        return $this->hasMany(Lead::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function batches()
    {
        return $this->hasMany(Batche::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function blog()
    {
        return $this->hasMany(Blog::class);
    }



    public function clientLocations()
    {
        return $this->hasOne(ClientLocation::class);
    }

    public function clientDetails()
    {
        return $this->hasOne(ClientDetail::class);
    }
    public function clientSocial()
    {
        return $this->hasOne(ClientSocial::class);
    }
    public function clientSeo()
    {
        return $this->hasOne(ClientSeo::class);
    }

    public function clientExtra()
    {
        return $this->hasOne(ClientExtradata::class);
    }

    public function board()
    {
        return $this->hasOne(Board::class);
    }
    public function googleAdsAccounts()
    {
        return $this->hasMany(GoogleAdsAccount::class);
    }
    public function campaigns()
    {
        return $this->hasMany(GoogleAdsCampaign::class);
    }
    

    // Nueva relación para la tabla client_social_profiles
    public function clientSocialProfiles()
    {
        return $this->hasMany(ClientSocialProfile::class);
    }

     public function clientCitationSubmissions()
    {
        return $this->hasMany(ClientCitationSubmission::class);
    }
}
