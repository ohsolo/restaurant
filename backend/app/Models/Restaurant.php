<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Concerns\Flagable;

class Restaurant extends Model
{
    use Flagable, 
        SoftDeletes, 
        HasFactory;

    protected $table = 'restaurants';
    protected $primaryKey = 'rest_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'id', 'flags', 'password', 'reset_token'
    ];

    protected $appends = [
        'logo_url', 'active', 'tax_by_distance', 'custom_tax', 'mirror_tax'
    ];

    public const FLAG_ACTIVE = 1;
    public const FLAG_TAX_BY_DISTANCE = 2;
    public const FLAG_CUSTOM_TAX = 4;
    public const FLAG_MIRROR_TAX = 8;

    public function getLogoUrlAttribute() {
        if ($this->logo) {
            return url('/').'/public/assets/restaurants/'.$this->rest_id.'/'.$this->logo;

        }
        return false;
    }

    public function getPhonesAttribute($phones) {
        if (!empty($phones)) {
            return json_decode($phones);

        }
        return null;
    }

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getTaxByDistanceAttribute() {
        return ($this->flags & self::FLAG_TAX_BY_DISTANCE) == self::FLAG_TAX_BY_DISTANCE;
    }

    public function getCustomTaxAttribute() {
        return ($this->flags & self::FLAG_CUSTOM_TAX) == self::FLAG_CUSTOM_TAX;
    }

    public function getMirrorTaxAttribute() {
        return ($this->flags & self::FLAG_MIRROR_TAX) == self::FLAG_MIRROR_TAX;
    }

    public function reviews(){
        return $this->hasMany('App\Models\RestaurantRiderRating', 'rest_id', 'rest_id');
    }

    public function branches() {
        return $this->hasMany('App\Models\Branch', 'rest_id', 'rest_id');
    }
}
