<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    // mass fillable
    protected $fillable = ['title', 'user_id'];

    // define the relationship with the chats
    public function chats()
    {
        return $this->hasMany(ChatMessage::class);
    }

    // define the relationship with the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}