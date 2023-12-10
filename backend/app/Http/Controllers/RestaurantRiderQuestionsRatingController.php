<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRestaurantRatingRequest;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\RestaurantRatingQuestion;
use App\Models\RestaurantRiderQuestionsRating;
use App\Models\RestaurantRiderRating;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantRiderQuestionsRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // RIDER Se rating milegi RESTAURANT KO
    public function store(Order $order, StoreRestaurantRatingRequest $request)
    {
        $order_rider_rating                             = new RestaurantRiderRating;
        $order_rider_rating->restaurant_rider_rating_id = Str::uuid();
        $order_rider_rating->order_id                   = $order->order_id;
        $order_rider_rating->rider_id                   = $order->rider_id;
        $order_rider_rating->rest_id                    = $order->rest_id;
        $order_rider_rating->comment                    = $request->comment;
        $order_rider_rating->rating                     = 0;
        if ($order_rider_rating->save()) {
            foreach ($request->question as $value) {
                $restaurant_rider_questions_rating                                  = new RestaurantRiderQuestionsRating;
                $restaurant_rider_questions_rating->rating_id                       = Str::uuid();
                $restaurant_rider_questions_rating->order_id                        = $order->order_id;
                $restaurant_rider_questions_rating->rider_id                        = $order->rider_id;
                $restaurant_rider_questions_rating->rest_id                         = $order->rest_id;
                $restaurant_rider_questions_rating->question                        = $value['text'];
                $restaurant_rider_questions_rating->rating                          = $value['rating'];
                $restaurant_rider_questions_rating->save();
            }

            $average = RestaurantRiderQuestionsRating::where('order_id', $order->order_id)->avg('rating');
            RestaurantRiderRating::where('order_id', $order->order_id)->update(['rating' => number_format($average, 1)]);
            $average = RestaurantRiderRating::where('rest_id', $order->rest_id)->avg('rating');

            $rest = Restaurant::where('rest_id', $order->rest_id)->first();
            $rest->total_rating = number_format($average, 1);
            $rest->save();
            $order->addFlag(Order::REST_RATED);
            $order->status = Order::STATUS_DELIVERED;
            $order->save();
            return api_success_app('Rating add Successfully');

        }
        return api_error_app();
    }
}
