<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';
    protected $primaryKey = 'message_id';
    protected $keyType = 'string';
    public $incrementing = false;

    
}
