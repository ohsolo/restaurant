<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use Flagable,
        HasFactory;
    protected $table = 'regions';
    protected $primaryKey = 'region_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = [
        'active'
    ];

    public const FLAG_ACTIVE = 1;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;

    }

    public function country_detail ()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    public function cities ()
    {
        return $this->hasMany('App\Models\City', 'id', 'city_id');
    }

    public function Addresses ()
    {
        return $this->hasMany('App\Models\Address', 'id', 'address_id');
    }
}
