<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelQuestionRequest;
use App\Models\OrderCancelQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderCancelQuestionController extends Controller
{
    public function index()
    {
        $cancel_questions = OrderCancelQuestion::orderBy('created_at', 'desc')->get();
        return api_success('All Order Cancelled Questions',['cancel_questions' => $cancel_questions]);
    }

    public function restaurant_index()
    {
        $cancel_questions = OrderCancelQuestion::whereRaw("`flags` & ? = ?", [OrderCancelQuestion::FLAG_ACTIVE, OrderCancelQuestion::FLAG_ACTIVE])->whereRaw("`flags` & ? = ?", [OrderCancelQuestion::FLAG_FOR_RIDER, OrderCancelQuestion::FLAG_FOR_RIDER])
        ->orderBy('created_at', 'desc')
        ->get();
        return api_success('Cancel Order Questions List', ['cancel_questions' => $cancel_questions]);
    }

    public function rider_index()
    {
        $cancel_questions = OrderCancelQuestion::whereRaw("`flags` & ? = ?", [OrderCancelQuestion::FLAG_ACTIVE, OrderCancelQuestion::FLAG_ACTIVE])->whereRaw("`flags` & ? != ?", [OrderCancelQuestion::FLAG_FOR_RIDER, OrderCancelQuestion::FLAG_FOR_RIDER])
        ->orderBy('created_at', 'desc')
        ->get();
        return api_success_app($cancel_questions);
    }

    public function store(CancelQuestionRequest $request)
    {
        $cancel_questions = new OrderCancelQuestion;
        $cancel_questions->order_cancel_question_id = Str::uuid(); 
        $cancel_questions->title = $request->title;
        $cancel_questions->addFlag(OrderCancelQuestion::FLAG_ACTIVE);
        if ($request->key == 'for_rider') {
            $cancel_questions->addFlag(OrderCancelQuestion::FLAG_FOR_RIDER);

        }
        if($cancel_questions->save()) return api_success1('Order Cancel Question Added Success');
        return api_error();
    }

    public function update(Request $request)
    {
        $cancel_questions = OrderCancelQuestion::where('order_cancel_question_id', $request->id)->first();
        $cancel_questions->title = $request->input('title', $cancel_questions->title);
        if ($request->has('status') && $request->filled('status')) {
            $cancel_questions->removeFlag(OrderCancelQuestion::FLAG_ACTIVE);
            if ($request->status == 'active') {
                $cancel_questions->addFlag(OrderCancelQuestion::FLAG_ACTIVE);
    
            }
        }
        if ($request->has('key') && $request->filled('key')) {
            $cancel_questions->removeFlag(OrderCancelQuestion::FLAG_FOR_RIDER);
            if ($request->key == 'for_rider') {
                $cancel_questions->addFlag(OrderCancelQuestion::FLAG_FOR_RIDER);

            }
        }
        $cancel_questions->save();
        return api_success1('Order Cancel Question Updated Successfully!');
    }
}