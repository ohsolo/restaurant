<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderRiderRating;
use App\Http\Requests\OrderRiderRatingRequest;

class OrderRiderRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $rider)
    {
        // $order_rider_ratings = OrderRiderRating::when($request->search && $request->filled('search'), function ($query) use ($request) {
        //     $query->Where('comment', 'like', '%' . $request->search . '%')
        //         ->orWhere('rating', 'like', '%' . $request->search . '%')
        //         ->orWhereHas('rider', function ($query) use ($request) {
        //             return $query->where('name', 'like', '%' . $request->search . '%');
        //         })
        //         ->orWhereHas('order', function ($query) use ($request) {
        //             return $query->where('order_number', 'like', '%' . $request->search . '%');
        //         });
        // })
        // ->when($request->status && $request->status == 'active', function ($query) {
        //     $query->whereRaw('`flags` & ?=?', [OrderRiderRating::FLAG_STATUS_ACTIVE, OrderRiderRating::FLAG_STATUS_ACTIVE]);
        // })
        // ->when($request->status && $request->status == 'block', function ($query) {
        //     $query->whereRaw('`flags` & ?!=?', [OrderRiderRating::FLAG_STATUS_ACTIVE, OrderRiderRating::FLAG_STATUS_ACTIVE]);
        // });
        $order_rider_ratings = OrderRiderRating::where('rider_id', $rider)
        ->whereRaw('`flags` & ?=?', [OrderRiderRating::FLAG_STATUS_ACTIVE, OrderRiderRating::FLAG_STATUS_ACTIVE])
        ->orderBy('created_at', 'desc')
        ->with(['order', 'rider'])
        ->paginate(10);
        if ($order_rider_ratings) return api_success("Reviews", ["rider_reviews" => $order_rider_ratings]);
        api_error();
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
    public function store(OrderRiderRating $review)
    {
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRiderRating $review)
    {
        if ($review->active) {
            $review->removeFlag(OrderRiderRating::FLAG_STATUS_ACTIVE);
        } else {
            $review->addFlag(OrderRiderRating::FLAG_STATUS_ACTIVE);
        }
        if($review->save()) return api_success('Review Status Updated', ["review" => $review]);
        return api_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
