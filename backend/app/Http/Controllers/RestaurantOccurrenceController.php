<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Admin;
use App\Models\RestaurantOccurrence;

use App\Http\Requests\RestaurantOccurrenceRequest;
use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\Order;

class RestaurantOccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #TODO: what will be happen if occurence store
    public function index(Request $request, $rider)
    {
        $rider = Rider::where('rider_id', $rider)->first();
        $occurences = RestaurantOccurrence::query();
        $occurences->where('rider_id', $rider->rider_id)
        ->with(['restaurant', 'rider.region', 'order']);
        return api_success('Restaurant Occurences', ['restaurant_occurrence' => $occurences->paginate(10), 'rider' => $rider]);
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
    public function store(RestaurantOccurrenceRequest $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        $rider = Rider::where('rider_id', $order->rider_id)->first();
        $restaurant_occurrence                           = new RestaurantOccurrence;
        $restaurant_occurrence->restaurant_occurrence_id = Str::uuid();
        $restaurant_occurrence->rest_id                  = request()->rest->rest_id;
        $restaurant_occurrence->order_id                 = $order->order_id;
        $restaurant_occurrence->rider_id                 = $order->rider_id;
        $restaurant_occurrence->reason                   = $request->reason;
        if ($restaurant_occurrence->save()) {
            $rider->removeFlag(Rider::FLAG_OCCURRENCE_FOUND);
            $rider->addFlag(Rider::FLAG_OCCURRENCE_FOUND);
            $rider->save();
            $count = RestaurantOccurrence::whereRaw('`flags` & ?=?', [RestaurantOccurrence::FLAG_READ, RestaurantOccurrence::FLAG_READ])->count();

            $tokens = Admin::where('device_token', '!=', NULL)->pluck('device_token')->toArray();
            if (sizeof($tokens) > 0) {
                $data = [
                    "registration_ids" => $tokens,
                    "data" => [
                        "title" => "Occurrence created against rider regarding delivery service.",
                        "body" => "Some restaurant create an occurrence",
                        "icon" => url("public/assets/images/logo.png"),
                        "is_occurence" => '1',
                        "occurence_count" => $count

                    ],
                    "notification" => [
                        "title" => "Occurrence created against rider regarding delivery service.",
                        "body" => "Some restaurant create an occurrence",
                        "icon" => url('public/assets/images/logo.png'),
                    ],
                ];
                notification_core($data);
            }
            return api_success1('Occurrence added successfully');
        }
        return api_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RestaurantOccurrence  $restaurantOccurrence
     * @return \Illuminate\Http\Response
     */
    public function show($rider_id)
    {
        return $rider_occurences = Rider::where('rider_id', $rider_id)->with(['occurences'])->first();
        return api_success();
        $occurence = RestaurantOccurrence::where('restaurant_occurrence_id', $id)->with(['restaurant', 'rider', 'order'])->first();
        return api_success('Restaurant Occurence Data', ['restaurant_occurrence' => $occurence->paginate(10)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RestaurantOccurrence  $restaurantOccurrence
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantOccurrence $restaurantOccurrence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RestaurantOccurrence  $restaurantOccurrence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestaurantOccurrence $restaurantOccurrence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RestaurantOccurrence  $restaurantOccurrence
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestaurantOccurrence $restaurantOccurrence)
    {
        //
    }
}
