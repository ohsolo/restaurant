<?php

namespace App\Models;
use App\Concerns\Flagable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancelQuestion extends Model
{
    use Flagable;
    protected $table      = 'order_cancel_questions';
    protected $primaryKey = 'order_cancel_question_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $appends = [
        'active', 'for_rider'
    ];
    
    public const FLAG_ACTIVE = 1;
    public const FLAG_FOR_RIDER = 2;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getForRiderAttribute() {
        return ($this->flags & self::FLAG_FOR_RIDER) == self::FLAG_FOR_RIDER;
    }
}