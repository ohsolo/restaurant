<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'city_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function region ()
    {
        return $this->hasOne('App\Models\Region', 'region_id', 'region_id');
    }

    public function country_detail ()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
}
