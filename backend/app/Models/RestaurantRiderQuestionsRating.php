<?php

namespace App\Models;
use App\Concerns\Flagable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantRiderQuestionsRating extends Model
{
    use Flagable;
    protected $table      = 'restaurant_rider_questions_ratings';
    protected $primaryKey = 'rating_id';
    protected $keyType    = 'string';
    public $incrementing  = false;
}
