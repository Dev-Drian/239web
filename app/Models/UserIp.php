<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIp extends Model
{


    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'request_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
