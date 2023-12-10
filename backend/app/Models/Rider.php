<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rider extends Model
{
    use Flagable, SoftDeletes, HasFactory;
    protected $table = 'riders';
    protected $primaryKey = 'rider_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'id', 'flags', 'password', 'reset_token'
    ];

    protected $appends = [
        'profile_image_url',
        'cnh_image_url',
        'active', 'awaiting',
        'blocked', 
        'is_available',
        'is_busy',
        'occurrence_found',
        'rating_found',
        'details_change_requested'
    ];

    public const FLAG_ACTIVE           = 1;
    public const FLAG_BLOCKED          = 2;
    public const FLAG_AWAITING         = 4;
    public const FLAG_IS_AVAILABLE     = 8;
    public const FLAG_IS_BUSY          = 16;
    public const FLAG_OCCURRENCE_FOUND = 32;
    public const FLAG_RATING_FOUND = 64;
    public const FLAG_DETAILS_CHANGE_REQUESTED = 64;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;

    }

    public function getDetailsChangeRequestedAttribute() {
        return ($this->flags & self::FLAG_DETAILS_CHANGE_REQUESTED) == self::FLAG_DETAILS_CHANGE_REQUESTED;

    }

    public function getAwaitingAttribute() {
        return ($this->flags & self::FLAG_AWAITING) == self::FLAG_AWAITING;

    }

    public function getBlockedAttribute() {
        return ($this->flags & self::FLAG_BLOCKED) == self::FLAG_BLOCKED;

    }
    
    public function getIsAvailableAttribute() {
        return ($this->flags & self::FLAG_IS_AVAILABLE) == self::FLAG_IS_AVAILABLE;
    }
    
    public function getIsBusyAttribute() {
        return ($this->flags & self::FLAG_IS_BUSY) == self::FLAG_IS_BUSY;
    }

    public function getOccurrenceFoundAttribute() {
        return ($this->flags & self::FLAG_OCCURRENCE_FOUND) == self::FLAG_OCCURRENCE_FOUND;
    }

    public function getRatingFoundAttribute() {
        return ($this->flags & self::FLAG_RATING_FOUND) == self::FLAG_RATING_FOUND;
    }

    public function getProfileImageUrlAttribute() {
        if ($this->logo_image) {
            return url('/').'/public/assets/riders/'.$this->rider_id.'/'.$this->logo_image;
        }
        return false;
    }

    public function getCnhImageUrlAttribute() {
        if ($this->cnh_image) {
            return url('/').'/public/assets/riders/'.$this->rider_id.'/'.$this->cnh_image;

        }
        return false;
    }

    // Relation method

    public function bank_detail () {
        return $this->hasOne('App\Models\BankDetail', 'rider_id', 'rider_id');
    }

    public function region () {
        return $this->hasOne('App\Models\Region', 'region_id', 'region_id');
    }

    public function rest_reviews() {
        return $this->hasMany('App\Models\RestaurantRiderRating', 'rider_id', 'rider_id');
    }

    public function occurences() {
        return $this->hasMany('App\Models\RestaurantOccurrence', 'rider_id', 'rider_id');
    }

    public function rider_reviews(){
        return $this->hasMany('App\Models\OrderRiderRating', 'rider_id', 'rider_id');
    }
    public function occurrences(){
        return $this->hasMany('App\Models\RestaurantOccurrence', 'rider_id', 'rider_id');
    }
}
