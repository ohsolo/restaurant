<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Flagable;
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    protected $keyType = 'string';
    public $incrementing = false;
    

    public function country_detail ()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    public function region ()
    {
        return $this->hasOne('App\Models\Region', 'region_id', 'region_id');
    }

    public function city ()
    {
        return $this->hasOne('App\Models\City', 'city_id', 'city_id');
    }
}
