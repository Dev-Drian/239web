<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category',
        'is_favorite'
    ];

    protected $casts = [
        'is_favorite' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
