<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CancelOrder;

class CancelOrderController extends Controller
{
    public function index()
    {
        $cancel = CancelOrder::where('rider_id', request()->rider->rider_id)->with(['order'])->orderBy('id', 'DESC')->get();
        return api_success_app($cancel);
    }

    public function store(Request $request, $order_id)
    {
        $cancel = CancelOrder::where('order_id', $order_id)->first();
        if ($cancel) {
            return api_error_app('');

        }
        $cancel_order = new CancelOrder;
        $cancel_order->cancel_order_id = (String) Str::uuid();
        $cancel_order->order_id = $request->order_id;
        $cancel_order->rider_id = request()->rider->rider_id;
        if ($cancel_order->save()) return api_success_app('');

        return api_error_app('');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CancelOrder  $cancelOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CancelOrder $cancelOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CancelOrder  $cancelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CancelOrder $cancelOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CancelOrder  $cancelOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CancelOrder $cancelOrder)
    {
        //
    }
}
