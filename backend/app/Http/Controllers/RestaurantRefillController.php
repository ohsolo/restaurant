<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefillRequest;
use App\Models\RestaurantRefill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantRefillController extends Controller
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
    public function store(StoreRefillRequest $request)
    {
    #TODO: Transaction make confirmed then set remaing balance in to restaurant's balance column

        #TODO: remaing details on payment method and card
        $restaurant_refills               = new RestaurantRefill();
        $restaurant_refills->refill_id    = Str::uuid();
        $restaurant_refills->payment_id   = rand(10000, 999999);
        $restaurant_refills->amount       = $request->amount;
        if(request()->admin){

            $restaurant_refills->request_by   = RestaurantRefill::REQUESTED_BY_ADMIN;
            $restaurant_refills->rest_id     = $request->rest_id;

        }

        else if(request()->rest){
            #TODO: when direct refill by rest set status approve or not
            // $restaurant_refills->status = RestaurantRefill::STATUS_APPROVED;
            $restaurant_refills->rest_id      = request()->rest->rest_id;
            $restaurant_refills->request_by   = RestaurantRefill::REQUESTED_BY_RESTAURANT;
        }
        if($restaurant_refills->save()) return api_success1("Refills added successfully");
        return api_error();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RestaurantRefill  $restaurantRefill
     * @return \Illuminate\Http\Response
     */
    public function show(RestaurantRefill $restaurantRefill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RestaurantRefill  $restaurantRefill
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantRefill $restaurantRefill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RestaurantRefill  $restaurantRefill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestaurantRefill $restaurantRefill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RestaurantRefill  $restaurantRefill
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestaurantRefill $restaurantRefill)
    {
        //
    }
}
