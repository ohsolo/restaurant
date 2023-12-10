<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Flagable,
        HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $appends = [
        'order_accepted_by_rider',
        'paid_to_rider',
        'chat_rider_started_from_admin',
        'chat_rider_started_from_rest',
        'order_pickup',
        'rider_rated',
        'restaurant_rated',
        'rejected_by_rider',
        'rest_rated'
    ];
    
    public const STATUS_DELIVERED          = 'delivered';
    public const STATUS_REJECTED           = 'rejected';
    public const STATUS_RESEARCH           = 'research';
    public const STATUS_PENDING            = 'pending';
    
    public const PAYMENT_ONLINE            = 'online';
    public const PAYMENT_CASH_ON_DELIVERY  = 'cash_on_delivery';
    
    public const FLAG_ORDER_ACCEPTED_BY_RIDER = 1;
    public const PAID_TO_RIDER = 2;
    public const CHAT_RIDER_STARTED_FROM_ADMIN = 4;
    public const CHAT_RIDER_STARTED_FROM_REST = 8;
    public const ORDER_PICKUP = 16;
    public const RIDER_RATED = 32;
    public const RESTAURANT_RATED = 64;
    public const REJECTED_BY_RIDER = 128;
    public const REST_RATED = 256;
    
    public function getOrderAcceptedByRiderAttribute() {
        return ($this->flags & self::FLAG_ORDER_ACCEPTED_BY_RIDER) == self::FLAG_ORDER_ACCEPTED_BY_RIDER;
    }

    public function getPaidToRiderAttribute() {
        return ($this->flags & self::PAID_TO_RIDER) == self::PAID_TO_RIDER;
        
    }

    public function getRejectedByRiderAttribute() {
        return ($this->flags & self::REJECTED_BY_RIDER) == self::REJECTED_BY_RIDER;
        
    }

    public function getChatRiderStartedFromAdminAttribute() {
        return ($this->flags & self::CHAT_RIDER_STARTED_FROM_ADMIN) == self::CHAT_RIDER_STARTED_FROM_ADMIN;
        
    }

    public function getChatRiderStartedFromRestAttribute() {
        return ($this->flags & self::CHAT_RIDER_STARTED_FROM_REST) == self::CHAT_RIDER_STARTED_FROM_REST;
        
    }

    public function getOrderPickupAttribute() {
        return ($this->flags & self::ORDER_PICKUP) == self::ORDER_PICKUP;
        
    }

    public function getRiderRatedAttribute() {
        return ($this->flags & self::RIDER_RATED) == self::RIDER_RATED;
        
    }

    public function getRestRatedAttribute() {
        return ($this->flags & self::REST_RATED) == self::REST_RATED;
        
    }
    
    public function getRestaurantRatedAttribute() {
        return ($this->flags & self::RESTAURANT_RATED) == self::RESTAURANT_RATED;
        
    }

    public function rider (){
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }

    public function branch (){
        return $this->hasOne('App\Models\Branch', 'branch_id', 'branch_id');
    }

    public function restaurant (){
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }

    public function address_detail (){
        return $this->hasOne('App\Models\Address', 'address_id', 'address_id');
    }
   
    public function order_rating (){
        return $this->hasOne('App\Models\OrderRiderRating', 'order_id', 'order_id');
    }

    public function order_questions_rating (){
        return $this->hasMany('App\Models\OrderRiderQuestionsRating', 'order_id', 'order_id');
    }
   
    public function rider_rating (){
        return $this->hasOne('App\Models\OrderRiderRating', 'rider_id', 'rider_id');
    }

    public function rider_last_location (){
        return $this->hasOne('App\Models\OrderRiderLocation', 'order_id', 'order_id');
    }

    public function rider_questions_rating (){
        return $this->hasMany('App\Models\OrderRiderQuestionsRating', 'rider_id', 'rider_id');
    }
    // Transaction method
    public function transactions(){
        return $this->hasMany('App\Models\Order_Transactions', 'order_id', 'order_id');
    }
    
}

