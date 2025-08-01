<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function tasks()
    {
        return $this->hasOne(Task::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
