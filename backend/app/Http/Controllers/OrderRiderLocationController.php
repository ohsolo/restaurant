<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderRiderLocation;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderRiderLocationController extends Controller
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
    public function store(Request $request)
    {
        // return $request;
        $order = Order::where('rider_id', request()->rider->rider_id)->where('status', Order::STATUS_PENDING)->first();
        $rider = Rider::where('rider_id', request()->rider->rider_id)->first();
        if ($order){
            $order_rider_locations = new OrderRiderLocation;
            $order_rider_locations->order_rider_location_id = Str::uuid();
            $order_rider_locations->rider_id  = $rider->rider_id;
            $order_rider_locations->order_id  = $order->order_id;
            $order_rider_locations->latitude  = $request->latitude;
            $order_rider_locations->longitude = $request->longitude;
            $order_rider_locations->save();
        }
        $rider->latitude = $request->latitude;
        $rider->longitude = $request->longitude;
        $rider->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderRiderLocation  $orderRiderLocation
     * @return \Illuminate\Http\Response
     */
    public function show(OrderRiderLocation $orderRiderLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderRiderLocation  $orderRiderLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderRiderLocation $orderRiderLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderRiderLocation  $orderRiderLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderRiderLocation $orderRiderLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderRiderLocation  $orderRiderLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderRiderLocation $orderRiderLocation)
    {
        //
    }
}
