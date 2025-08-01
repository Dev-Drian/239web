<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'chat_id',
        'sender_id',
        'content',
        'message_type',
        'file_path',
        'file_name',
        'file_size',
        'file_extension',
        'file_mime_type'
        
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function reads() // para mensaje leídos en grupo
    {
        return $this->belongsToMany(User::class, 'message_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
