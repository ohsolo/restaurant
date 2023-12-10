<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class RestaurantRatingQuestion extends Model
{
    use Flagable;
    protected $table = 'restaurant_rating_questions';
    protected $primaryKey = 'restaurant_rating_question_id';
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
