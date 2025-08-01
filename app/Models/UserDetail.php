<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
