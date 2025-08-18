<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordTrackerItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tracker()
    {
        return $this->belongsTo(KeywordTracker::class, 'keyword_tracker_id');
    }
}


