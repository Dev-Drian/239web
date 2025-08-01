<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'image_user';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
