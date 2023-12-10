<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelOrder extends Model
{
    protected $table = 'cancel_orders';
    protected $primaryKey = 'cancel_order_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function rider (){
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }

    public function order (){
        return $this->hasMany('App\Models\Order', 'order_id', 'order_id');
    }
}
