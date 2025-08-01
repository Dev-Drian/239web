<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchKeyword extends Model
{
    protected $guarded = [];

  

    public function batch()
    {
        return $this->belongsTo(Batche::class, 'batch_id');
    }
}
