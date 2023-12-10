<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class Order_Transaction extends Model
{
    use Flagable;
    protected $table = 'order_transactions';
    protected $primaryKey = 'order_transaction_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = [
        'is_completed',
    ];
    public const FLAG_STATUS_COMPLETED  = 1;

    public function getIsCompletedAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_COMPLETED) == self::FLAG_STATUS_COMPLETED;
    }

    public function order(){
        return $this->hasOne('App\Models\Order', 'order_id', 'order_id');
    }
   
    public function restaurant(){
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }
    
    public function transaction(){
        return $this->hasOne('App\Models\Transaction', 'transaction_id', 'transaction_id');
    }
}
