<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\Restaurant;
use App\Models\Admin;
use App\Models\Rider;
use App\Models\Order;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_rider_messages_admin(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rider_id', $order->rider_id)->whereNull('rest_id')->whereNotNull('admin_id')->with(['order.restaurant', 'messages' => function ($q) {
            $q->orderBy('id', 'DESC');
        }])->first();
        return api_success_app($found);
    }

    public function get_rider_messages_rest(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rest_id', $order->rest_id)->where('rider_id', $order->rider_id)->with(['order.restaurant', 'messages' => function ($q) {
            $q->orderBy('id', 'DESC');
        }])->first();
        return api_success_app($found);
    }

    public function get_rest_messages(Request $request, $order_id)
    {
        $found = ChatUser::where('order_id', $order_id)->where('rest_id', request()->rest->rest_id)->with(['rider', 'messages' => function ($q) {
            $q->orderBy('id', 'ASC');
        }])->first();
        return api_success('Chat Messages.', $found);
    }

    public function get_admin_messages(Request $request, $order_id)
    {
        $found = ChatUser::where('order_id', $order_id)->where('admin_id', request()->admin->admin_id)->with(['rider', 'messages' => function ($q) {
            $q->orderBy('id', 'ASC');
        }])->first();
        return api_success('Chat Messages.', $found);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rider_id', $order->rider_id)->where('admin_id', request()->admin->admin_id)->first();
        $chat = new ChatMessage;
        $chat->chat_user_id = $found->chat_user_id;
        $chat->from = request()->admin->admin_id;
        $chat->to = $order->rider_id;
        $chat->message = $request->message;
        if ($chat->save()) {
            $rider = Rider::where('rider_id', $order->rider_id)->first();
            $data = [
                "registration_ids" => [$rider->device_token],
                "data" => [
                    "title" => "New Message from Admin",
                    "body" => "New Message from Admin",
                    "icon" => url("public/assets/images/logo.png"),
                    "is_chat" => '1',
                ],
                "notification" => [
                    "title" => "New Message from Admin",
                    "body" => "New Message from Admin",
                    "icon" => url('public/assets/images/logo.png'),
                ],
            ];
            notification_core($data);
            return api_success('Message added!', ['message' => $chat]);

        }
        return api_error();
    }

    public function store_rest(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rider_id', $order->rider_id)->where('rest_id', $order->rest_id)->first();

        $chat = new ChatMessage;
        $chat->chat_user_id = $found->chat_user_id;
        $chat->from = request()->rest->rest_id;
        $chat->to = $order->rider_id;
        $chat->message = $request->message;
        if ($chat->save()) {
            $rider = Rider::where('rider_id', $order->rider_id)->first();
            $data = [
                "registration_ids" => [$rider->device_token],
                "data" => [
                    "title" => "New Message from Restaurant",
                    "body" => "New Message from Restaurant",
                    "icon" => url("public/assets/images/logo.png"),
                    "is_chat" => '1',
                ],
                "notification" => [
                    "title" => "New Message from Restaurant",
                    "body" => "New Message from Restaurant",
                    "icon" => url('public/assets/images/logo.png'),
                ],
            ];
            notification_core($data);
            return api_success('Message added!', ['message' => $chat]);

        }
        return api_error();
    }

    public function store_rider_for_rest(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rest_id', $order->rest_id)->where('rider_id', $order->rider_id)->first();
        if ($found) {
            $chat = new ChatMessage;
            $chat->chat_user_id = $found->chat_user_id;
            $chat->from = request()->rider->rider_id;
            $chat->to = $found->rest_id;

            $chat->message = $request->message;
            if ($chat->save()) {
                $rest = Restaurant::where('rest_id', $found->rest_id)->first();
                $data = [
                    "registration_ids" => [$rest->device_token],
                    "data" => [
                        "title" => "New Message from Rider.",
                        "body" => "New Message from Rider",
                        "icon" => url("public/assets/images/logo.png"),
                        "is_chat" => '1'
                    ],
                    "notification" => [
                        "title" => "New Message from Rider.",
                        "body" => "New Message from Rider.",
                        "icon" => url('public/assets/images/logo.png'),
                    ],
                ];
                notification_core($data);
                return api_success_app('Message sent!');

            }    
        }
        return api_error_app();
    }

    public function store_rider_for_admin(Request $request, Order $order)
    {
        $found = ChatUser::where('order_id', $order->order_id)->where('rider_id', $order->rider_id)->whereNull('rest_id')->whereNotNull('admin_id')->first();
        if ($found) {
            $chat = new ChatMessage;
            $chat->chat_user_id = $found->chat_user_id;
            $chat->from = request()->rider->rider_id;
            $chat->to = $found->admin_id;

            $chat->message = $request->message;
            if ($chat->save()) {
                $admin = Admin::where('admin_id', $found->admin_id)->first();
                $data = [
                    "registration_ids" => [$admin->device_token],
                    "data" => [
                        "title" => "New Message from Rider.",
                        "body" => "New Message from Rider",
                        "icon" => url("public/assets/images/logo.png"),
                        "is_chat" => '1'
                    ],
                    "notification" => [
                        "title" => "New Message from Rider.",
                        "body" => "New Message from Rider.",
                        "icon" => url('public/assets/images/logo.png'),
                    ],
                ];
                notification_core($data);
                return api_success_app('Message added!');

            }    
        }
        return api_error_app();
    }
}
