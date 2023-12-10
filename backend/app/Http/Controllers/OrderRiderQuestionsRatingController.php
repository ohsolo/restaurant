<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Requests\OrderRiderQuestionsRatingRequest;

use App\Models\OrderRiderQuestionsRating;
use App\Models\RestaurantRatingQuestion;
use App\Models\RestaurantRiderRating;
use App\Models\RiderRatingQuestion;
use App\Models\OrderRiderRating;
use App\Models\RestaurantRiderQuestionsRating;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Region;

class OrderRiderQuestionsRatingController extends Controller
{
    public function get_riders_who_got_rate_by_restaurants(Request $request)
    {
        $riders = Rider::query();
        if ($request->has('status') && $request->filled('status') && $request->status == 'awaiting') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_AWAITING, Rider::FLAG_AWAITING]);
        } else if ($request->has('status') && $request->filled('status') && $request->status == 'blocked') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_BLOCKED, Rider::FLAG_BLOCKED]);
        } else if ($request->has('status') && $request->filled('status') && $request->status == 'active') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE]);
        }

        if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'car') {
            $riders->where('vehicle_type', 'car');
        } else if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'bike') {
            $riders->where('vehicle_type', 'bike');
        } else if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'bicycle') {
            $riders->where('vehicle_type', 'bicycle');
        }

        if ($request->has('search') && $request->filled('search')) {
            $riders->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('cpf', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('region') && $request->filled('region')) {
            $riders->where('region_id', $request->region);

        }

        $riders->whereRaw('`flags` & ?=?', [Rider::FLAG_RATING_FOUND, Rider::FLAG_RATING_FOUND]);
        $riders->with(['region']);
        $riders->orderBy('id', 'DESC');
        $all_regions = Region::whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE])->get();
        $data['regions'] = $all_regions;
        $data['riders'] = $riders->paginate(10);

        return api_success('Riders And Regions Data', $data);
    }

    public function get_single_rider_ratings(Request $request, $id)
    {
        $rider = Rider::where('rider_id', $id)->first();
        $rider_ratings = OrderRiderRating::where('rider_id', $id)->with(['order.restaurant'])->orderBy('created_at', 'desc')->paginate(10);
        return api_success('Rider Ratings against order and restaurants', ['rider_ratings' => $rider_ratings, 'rider' => $rider]);
    }

    // REstaurant Se rating milegi RIDER BABU KO
    public function store(OrderRiderQuestionsRatingRequest $request, Order $order)
    {
        $order_rider_rating                        = new OrderRiderRating;
        $order_rider_rating->order_rider_rating_id = Str::uuid();
        $order_rider_rating->order_id              = $order->order_id;
        $order_rider_rating->rider_id              = $order->rider_id;
        $order_rider_rating->comment               = $request->comment;
        $order_rider_rating->rating                = 0;
        if ($order_rider_rating->save()) {
            foreach ($request->question as $value) {
                $order_rider_questions_rating                                  = new OrderRiderQuestionsRating;
                $order_rider_questions_rating->order_rider_questions_rating_id = Str::uuid();
                $order_rider_questions_rating->order_id                        = $order->order_id;
                $order_rider_questions_rating->rider_id                        = $order->rider_id;
                $order_rider_questions_rating->question                        = $value['text'];
                $order_rider_questions_rating->rating                          = $value['rating'];
                $order_rider_questions_rating->save();
            }
            $average = OrderRiderQuestionsRating::where('order_id', $order->order_id)->avg('rating');
            OrderRiderRating::where('order_id', $order->order_id)->update(['rating' => number_format($average, 1)]);
            $average = OrderRiderRating::where('rider_id', $order->rider_id)->avg('rating');

            $rider = Rider::where('rider_id', $order->rider_id)->first();
            $rider->total_rating = number_format($average, 1);
            $rider->removeFlag(Rider::FLAG_RATING_FOUND);
            $rider->addFlag(Rider::FLAG_RATING_FOUND);
            $rider->save();
            $order->addFlag(Order::RIDER_RATED);
            $order->save();
            return api_success1('Rider got rated successfully!');
        }
        return api_error();
    }

    public function get_rider_ratings_against_order (Request $request, Order $order)
    {
        $data['rider_rating'] = OrderRiderRating::where('order_id', $order->order_id)->first();
        $data['rider_rating_questions'] = OrderRiderQuestionsRating::where('order_id', $order->order_id)->get();
        $data['rest_rating'] = RestaurantRiderRating::where('order_id', $order->order_id)->first();
        $data['rest_rating_questions'] = RestaurantRiderQuestionsRating::where('order_id', $order->order_id)->get();
        return api_success('Rider and Restaurant Rating Data', $data);
    }
}
