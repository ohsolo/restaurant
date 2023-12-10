<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class OrderRiderRating extends Model
{
    use Flagable;
    protected $table      = 'order_rider_ratings';
    protected $primaryKey = 'order_rider_rating_id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    
    public function rider()
    {
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }
    
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'order_id', 'order_id');
    }
}
