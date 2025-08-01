<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batche extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function keyword()
    {
        return $this->hasMany(BatchKeyword::class, 'batch_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
