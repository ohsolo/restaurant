<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class RestaurantOccurrence extends Model
{
    use Flagable;
    protected $table = 'restaurant_occurrences';
    protected $primaryKey = 'restaurant_occurrence_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = [
        'read'
    ];

    public const FLAG_READ = 1;

    public function getReadAttribute() {
        return ($this->flags & self::FLAG_READ) == self::FLAG_READ;

    }

    public function order ()
    {
        return $this->hasOne('\App\Models\Order', 'order_id', 'order_id');
    }

    public function restaurant ()
    {
        return $this->hasOne('\App\Models\Restaurant', 'rest_id', 'rest_id');
    }

    public function rider ()
    {
        return $this->hasOne('\App\Models\Rider', 'rider_id', 'rider_id');
    }
}
