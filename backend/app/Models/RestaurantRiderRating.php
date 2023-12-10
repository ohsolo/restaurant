<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Concerns\Flagable;

class RestaurantRiderRating extends Model
{
    use Flagable;
    protected $table      = 'restaurant_rider_ratings';
    protected $primaryKey = 'restaurant_rider_rating_id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    protected $appends = [
        'active'
    ];

    public const FLAG_STATUS_ACTIVE = 1;

    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_ACTIVE) == self::FLAG_STATUS_ACTIVE;
    }

    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }

    public function rider()
    {
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }
}