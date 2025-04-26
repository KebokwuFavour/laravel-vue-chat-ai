<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    // mass fillable
    protected $fillable = ['user_id', 'conversation_id', 'user_prompt', 'ai_reply'];

    // // define the relationship with the user
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // define the relationship with the conversation
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}