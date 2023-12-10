<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class OrderRiderLocation extends Model
{
    use Flagable;
    protected $table      = 'order_rider_locations';
    protected $primaryKey = 'order_rider_location_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $appends = [
        'is_active', 'order_accept_location'
    ];
    
    public const FLAG_ACTIVE = 1;
    public const FLAG_ORDER_ACCEPT_LOCATION = 2;

    public function getIsActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getOrderAcceptLocationAttribute() {
        return ($this->flags & self::FLAG_ORDER_ACCEPT_LOCATION) == self::FLAG_ORDER_ACCEPT_LOCATION;
    }
}
