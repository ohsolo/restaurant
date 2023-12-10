<?php

namespace App\Models;
use App\Concerns\Flagable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantRefill extends Model
{
    use Flagable;
    protected $table      = 'restaurant_refills';
    protected $primaryKey = 'refill_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    public const REQUESTED_BY_ADMIN      = 'admin';
    public const REQUESTED_BY_RESTAURANT = 'restaurant';
    public const STATUS_APPROVED         = 'approved';
    public const STATUS_IN_PROGRESS      = 'in_progress';
    public const STATUS_REJECTED         = 'rejected';
    public const STATUS_PENDING          = 'pending';

    public function restaurant(){
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }
}
