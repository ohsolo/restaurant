<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $table = 'chat_users';
    protected $primaryKey = 'chat_user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function rider (){
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }

    public function order (){
        return $this->hasOne('App\Models\Order', 'order_id', 'order_id');
    }

    public function rest (){
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }

    public function messages (){
        return $this->hasMany('App\Models\ChatMessage', 'chat_user_id', 'chat_user_id');
    }
}
