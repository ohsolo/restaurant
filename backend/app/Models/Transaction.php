<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class Transaction extends Model
{
    use Flagable;
    protected $table      = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $appends = [
        'requested_by_admin',
        'requested_by_rider',
        'is_pending',
        'is_processing',
        'is_completed',
        'is_rejected',
        'quick_withdraw_request'
    ];

    public const REQUESTED_BY_ADMIN      = 'admin';
    public const REQUESTED_BY_RESTAURANT = 'restaurant';
    public const STATUS_APPROVED         = 'approved';
    public const STATUS_IN_PROGRESS      = 'in_progress';
    public const STATUS_REJECTED         = 'rejected';
    public const STATUS_PENDING          = 'pending';

    public const FLAG_ADMIN_REQUEST     = 1;
    public const FLAG_RIDER_REQUEST     = 2;
    public const FLAG_STATUS_PENDING    = 4;
    public const FLAG_STATUS_PROCESSING = 8;
    public const FLAG_STATUS_COMPLETED  = 16;
    public const FLAG_STATUS_REJECTED   = 32;
    public const FLAG_QUICK_WITHDRAW    = 64;



    public function getRequestedByAdminAttribute()
    {
        return ($this->flags & self::FLAG_ADMIN_REQUEST) == self::FLAG_ADMIN_REQUEST;
    }

    public function getRequestedByRiderAttribute()
    {
        return ($this->flags & self::FLAG_RIDER_REQUEST) == self::FLAG_RIDER_REQUEST;
    }

    public function getIsPendingAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_PENDING) == self::FLAG_STATUS_PENDING;
    }

    public function getIsProcessingAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_PROCESSING) == self::FLAG_STATUS_PROCESSING;
    }

    public function getIsCompletedAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_COMPLETED) == self::FLAG_STATUS_COMPLETED;
    }

    public function getIsRejectedAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_REJECTED) == self::FLAG_STATUS_REJECTED;
    }

    public function getQuickWithdrawRequestAttribute()
    {
        return ($this->flags & self::FLAG_QUICK_WITHDRAW) == self::FLAG_QUICK_WITHDRAW;
    }

    // Relaion Methods

    public function rider()
    {
        return $this->hasOne('App\Models\Rider', 'rider_id', 'rider_id');
    }

    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'rest_id', 'rest_id');
    }
}
