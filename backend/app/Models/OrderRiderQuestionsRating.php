<?php

namespace App\Models;
use App\Concerns\Flagable;

use Illuminate\Database\Eloquent\Model;

class OrderRiderQuestionsRating extends Model
{
    use Flagable;
    protected $table      = 'order_rider_questions_ratings';
    protected $primaryKey = 'questions_rating_id';
    protected $keyType    = 'string';
    public $incrementing  = false;
}
