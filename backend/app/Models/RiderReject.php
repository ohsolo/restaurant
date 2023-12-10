<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class RiderReject extends Model
{
    use Flagable;
    protected $table = 'rider_rejects';
    protected $primaryKey = 'rider_reject_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = [
        'rejected_by_rider'
    ];

    public const FLAG_REJECTED_BY_RIDER = 1;

    public function getRejectedByRiderAttribute() {
        return ($this->flags & self::FLAG_REJECTED_BY_RIDER) == self::FLAG_REJECTED_BY_RIDER;

    }
}
