<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\StoreChatUsers as StoreChatUsersRequest;

use App\Models\ChatUser;
use App\Models\Order;
use App\Models\Rider;

class ChatUserController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $order_id)
    {
        $found = ChatUser::where('order_id', $order_id)->where('admin_id', request()->admin->admin_id)->with(['rider', 'order.restaurant', 'messages' => function ($q) {
            $q->orderBy('id', 'DESC');
        }])->first();
        if (!$found) {
            $order = Order::where('order_id', $order_id)->first();
            $order->removeFlag(Order::CHAT_RIDER_STARTED_FROM_ADMIN);
            $order->addFlag(Order::CHAT_RIDER_STARTED_FROM_ADMIN);
            $order->save();

            $chat = new ChatUser;
            $chat->chat_user_id = Str::uuid();
            $chat->order_id = $order_id;
            $chat->admin_id = request()->admin->admin_id;
            $chat->rider_id = $order->rider_id;
            if ($chat->save()) {
                $chat = ChatUser::where('chat_user_id', $chat->chat_user_id)->with(['rider', 'order.restaurant', 'messages' => function ($q) {
                    $q->orderBy('id', 'DESC');
                }])->first();
                $rider = Rider::where('rider_id', $order->rider_id)->first();
                $data = [
                    "registration_ids" => [$rider->device_token],
                    "data" => [
                        "title" => "Chat initialised by Admin.",
                        "body" => "Chat initialised by Admin",
                        "icon" => url("public/assets/images/logo.png"),
                        "app_admin_chat" => '1'
                    ],
                    "notification" => [
                        "title" => "Chat initialised by Admin.",
                        "body" => "Chat initialised by Admin.",
                        "icon" => url('public/assets/images/logo.png'),
                    ],
                ];
                notification_core($data);
                return api_success('Chat created', ['chat' => $chat]);

            }
        } else {
            return api_success('Chat found!', ['chat' => $found]);

        }
        return api_error();
    }

    public function store_rest(Request $request, $order_id)
    {
        $found = ChatUser::where('order_id', $order_id)->where('rest_id', request()->rest->rest_id)->with(['rider', 'order', 'messages' => function ($q) {
            $q->orderBy('id', 'DESC');
        }])->first();
        if (!$found) {
            $order = Order::where('order_id', $order_id)->first();
            $order->removeFlag(Order::CHAT_RIDER_STARTED_FROM_REST);
            $order->addFlag(Order::CHAT_RIDER_STARTED_FROM_REST);
            $order->save();

            $chat = new ChatUser;
            $chat->chat_user_id = Str::uuid();
            $chat->order_id = $order_id;
            $chat->rest_id = request()->rest->rest_id;
            $chat->rider_id = $order->rider_id;
            if ($chat->save()) {
                $chat = ChatUser::where('chat_user_id', $chat->chat_user_id)->with(['rider', 'order', 'messages' => function ($q) {
                    $q->orderBy('id', 'DESC');
                }])->first();
                $rider = Rider::where('rider_id', $order->rider_id)->first();
                $data = [
                    "registration_ids" => [$rider->device_token],
                    "data" => [
                        "title" => "Chat initialised by Restaurant.",
                        "body" => "Chat initialised by Restaurant",
                        "icon" => url("public/assets/images/logo.png"),
                        "app_rest_chat" => '1'
                    ],
                    "notification" => [
                        "title" => "Chat initialised by Restaurant.",
                        "body" => "Chat initialised by Restaurant.",
                        "icon" => url('public/assets/images/logo.png'),
                    ],
                ];
                notification_core($data);
                return api_success('Chat created', ['chat' => $chat]);

            }
        } else {
            return api_success('Chat found!', ['chat' => $found]);

        }
        return api_error();
    }
}
