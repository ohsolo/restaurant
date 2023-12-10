<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class RiderRatingQuestion extends Model
{
    
    use Flagable;
    protected $table = 'rider_rating_questions';
    protected $primaryKey = 'rider_rating_question_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'id', 'flags'
    ];

    protected $appends = [
        'active'
    ];

    public const FLAG_ACTIVE = 1;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;

    }
}
