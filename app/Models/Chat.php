<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable = ['type', 'name', 'image'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
    // app/Models/Chat.php

    public function getLastMessageAttribute()
    {
        return optional($this->messages()->latest()->first())->message;
    }

    public function getLastMessageTimeAttribute()
    {
        return optional($this->messages()->latest()->first())->created_at;
    }

    public function getLastMessageSenderAttribute()
    {
        $lastMessage = $this->messages()->latest()->with('sender')->first();
        return optional($lastMessage->sender ?? null)->name;
    }
}
