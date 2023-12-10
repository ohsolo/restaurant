<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Requests\FilterOrderRequest;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\City;
use App\Models\Region;
use App\Models\Setting;
use App\Models\Address;
use App\Models\RiderReject;
use App\Models\Branch;
use App\Models\OrderRiderLocation;

use Illuminate\Support\Carbon;
use App\Http\Requests\StoreOrder as StoreOrderRequest;

class OrderController extends Controller
{
    public function report_screen_dependencies(Request $request)
    {
        $data['all_restaurants'] = Restaurant::select('rest_id', 'title')->whereRaw('`flags` & ?=?', [Restaurant::FLAG_ACTIVE, Restaurant::FLAG_ACTIVE])->get();
        $data['all_riders'] = Rider::select('rider_id', 'name')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->get();
        $data['all_regions'] = Region::whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE])->get();
        return api_success('Report Screen Dependency Data', $data);
    }

    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 20);
        $data = array();
        $order = Order::query();
        if ($request->has('by_procured') && $request->filled('by_procured') && $request->by_procured == 1) {
            $order->where('order_number', $request->order_number);
        } else if ($request->has('by_period') && $request->filled('by_period') && $request->by_period == 1) {
            $order->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
        }

        if ($request->has('form_of_payment') && $request->filled('form_of_payment')) {
            $order->where('payment_method', $request->form_of_payment);
        }

        if ($request->has('status') && $request->filled('status')) {
            $order->where('status', $request->status);
        }

        if ($request->has('region_id') && $request->filled('region_id')) {
            $cities = City::where('region_id', $request->region_id)->pluck()->toArray();
            if (sizeof($cities) > 0) {
                $branches = Branch::whereIn('city_id', $cities)->pluck()->toArray();
                if (sizeof($branches) > 0) {
                    $order->whereIn('branch_id', $branches);
                }
            }
        }

        if ($request->has('deliverer_id') && $request->filled('deliverer_id')) {
            $order->where('rider_id', $request->deliverer_id);
        }

        if ($request->has('vehicle_type') && $request->filled('vehicle_type')) {
            $riders = Rider::where('vehicle_type', $request->vehicle_type)->pluck('rider_id')->toArray();
            if (sizeof($riders) > 0) {
                $order->whereIn('rider_id', $riders);
            }
        }

        $order->where('rest_id', request()->rest->rest_id);
        $order->orderBy('created_at', 'DESC');
        $data['orders'] = $order->paginate($per_page);
        $data['deliveries_not_period'] = 0;
        $data['deliveries_canceled_no_period'] = 0;
        $data['gross_profit'] = 0;
        $data['net_profit'] = 0;
        if (sizeof($data['orders']) > 0) {
            $deliveries_not_period = 0;
            $deliveries_canceled_no_period = 0;
            $gross_profit = 0;
            $net_profit = 0;
            foreach ($data['orders'] as $order_key => $order_val) {
                if ($order_val->status == Order::STATUS_RESEARCH) {
                    ++$deliveries_not_period;
                } else if ($order_val->status == Order::STATUS_REJECTED) {
                    ++$deliveries_canceled_no_period;
                } else if ($order_val->status == Order::STATUS_DELIVERED) {
                    $gross_profit += $order_val->gross_profit;
                    $net_profit += $order_val->net_profit;
                }
            }
            $data['deliveries_not_period'] = $deliveries_not_period;
            $data['deliveries_canceled_no_period'] = $deliveries_canceled_no_period;
            $data['gross_profit'] = $gross_profit;
            $data['net_profit'] = $net_profit;
        }
        return api_success('Filter Order Api', $data);
    }

    public function rider_orders(Request $request)
    {
        $orders = Order::where('rider_id', request()->rider->rider_id)->WhereRaw('flags & ? != ?', [Order::PAID_TO_RIDER, Order::PAID_TO_RIDER])->with(['branch', 'restaurant', 'address_detail'])->get();
        if ($orders) return $orders;
        // api_success('Rider Orders and Amount', ['orders' => $orders]);
    }

    public function store(StoreOrderRequest $request)
    {


        // echo $response->getBody();
        $rider_return_flag          = false;
        $branch                     = Branch::where('branch_id', $request->branch_id)->first();
        $address                    = Address::where('address_id', $request->address_id)->first();
        $order                      = new Order;
        $order->order_id            = Str::uuid();
        $order->order_number        = rand(10000, 99999);
        $order->rest_id             = request()->rest->rest_id;
        $order->branch_id           = $request->branch_id;
        $order->address_id          = $request->address_id;
        $order->customer_name       = $request->customer_name;
        $order->customer_phone      = $request->customer_phone;
        $order->customer_other_info = $request->customer_other_info;
        $order->output_time         = $request->output_time;
        $order->order_method        = $request->order_method;
        $order->payment_method      = Order::PAYMENT_ONLINE;
        $order->dishes_info         = $request->dishes_info;
        $order->observations        = $request->observations;
        $order->remarks             = $request->remarks;
        $order->compliments         = $request->compliments;
        $order->comments            = $request->comments;
        $order->rest_order_amount   = $request->restaurant_order_amount;
        $order->response            = $request->response;
        $order->status              = Order::STATUS_RESEARCH;

        if ($request->payment_method == Order::PAYMENT_CASH_ON_DELIVERY) {
            $rider_return_charges       = Setting::where('title', 'rider_return_fee')->first();
            $order->rider_return_fee    = $rider_return_charges->values;
            $rider_return_flag          = true;
            $order->payment_method      = Order::PAYMENT_CASH_ON_DELIVERY;
        }

        $total_distance = distance_between_two_locations($branch->latitude, $branch->longitude, $address->latitude, $address->longitude);
        $total_distance = 11.6;
        $distance_amount = 0;
        $distance_matched = false;

        if ($total_distance > 0 && $total_distance <= 10) {
            $all_settings = Setting::where('title', 'LIKE', 'values_by_distance_traveled%')->get();
            foreach ($all_settings as $set_key => $set_value) {
                if (isset($all_settings[$set_key + 1])) {
                    $current_amount = explode('_', $set_value->title);
                    $next_amount_obj = $all_settings[$set_key + 1];
                    $next_amount = explode('_', $next_amount_obj->title);

                    $current_amount_in_number = $current_amount[4] . '.' . $current_amount[5];
                    $next_amount_in_number = $next_amount[4] . '.' . $next_amount[5];
                    if ($total_distance < $current_amount_in_number) {
                        $distance_amount = $set_value->values;
                        $distance_matched = true;
                        break;
                    } else if ($total_distance >= $current_amount_in_number && $total_distance <= $next_amount_in_number) {
                        $distance_amount = $next_amount_obj->values;
                        $distance_matched = true;
                        break;
                    }
                } else {
                    $current_amount = explode('_', $set_value->title);
                    $current_amount_in_number = $current_amount[4] . '.' . $current_amount[5];
                    if ($total_distance <= $current_amount_in_number) {
                        $distance_amount = $set_value->values;
                        $distance_matched = true;
                        break;
                    }
                }
            }
        } else if (!$distance_matched && $total_distance > 10) {
            $result = $total_distance - 10;
            $ten_km_value = Setting::where('title', '=', 'values_by_distance_traveled_10_0_km')->first();
            $over_10_km_value = Setting::where('title', '=', 'values_over_10_0_km_charge')->first();
            $distance_amount = $ten_km_value->values + ($over_10_km_value->values * $result);
            $distance_matched = true;
        }

        $platform_fee_to_rider                      = Setting::where('title', '=', 'platform_fee_percentage_for_deliverer_per_ride')->first();
        $platform_charges_to_restaurant             = Setting::where('title', '=', 'platform_charges_to_restaurant')->first();
        $order->delivery_charges                    = $distance_amount;
        $order->total_distance                      = $total_distance;
        $platform_charges_to_rider                  = $distance_amount * ($platform_fee_to_rider->values / 100);
        $platform_charges_to_rider                  = ($distance_amount - $platform_charges_to_rider);
        $order->platform_charges_to_rider           = $platform_charges_to_rider;
        $order->platform_charges_to_restaurant      = $platform_charges_to_restaurant->values;
        $order->net_profit                          = $platform_charges_to_restaurant->values + $platform_charges_to_rider;
        if ($order->save()) {

            $order->gross_profit                    = $order->delivery_charges + $order->platform_charges_to_rider + $order->rider_return_fee;
            $order->save();

            $latitude = $branch->latitude + 0.0005;
            $longitude = $branch->longitude + 0.0005;
            $total_radius = config('server_credentials.distance_in_km');

            $found_riders = Rider::selectRaw('* , ( 6371 *  acos( cos( radians(?) ) * cos( radians( `latitude`  ) ) * cos( radians( `longitude` ) - radians(?)) + sin( radians(?) ) * sin(radians(`latitude` ) ) )) AS distance', [$latitude, $longitude, $latitude])->having("distance", "<", $total_radius)->whereNotNull('device_token')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->whereRaw('`flags` & ?=?', [Rider::FLAG_IS_AVAILABLE, Rider::FLAG_IS_AVAILABLE])->whereRaw('`flags` & ?=?', [Rider::FLAG_IS_BUSY, Rider::FLAG_IS_BUSY])->pluck('device_token')->toArray();
            ////////////////////////********** CHARGE PAYMENT  ***********/////////////////////////////////
            $client = new \GuzzleHttp\Client();
            $data = array(
                "items" => [
                    [
                        "amount"         => 1000, // item amount
                        "quantity"       => 1,
                        "code"           => "123",
                        "description"    => "purchase"
                    ]
                ],
                "payments" => [
                    [
                        //*********** */ if cash_on_delivery
                        "cash" =>
                        [
                            "description" => "Teste",
                            "confirm" => false // true payment completed successfully
                        ],
                        "payment_method" => "cash",

                        //*********** */ if online payment
                        // "credit_card" =>
                        // [
                        //     "card" => [
                        //         "number"      => 4242424242424242,
                        //         "holder_name" => "test",
                        //         "exp_month"   => 12,
                        //         "exp_year"    => 2024,
                        //         "cvv"         => "123"
                        //     ]
                        // ],
                        // "payment_method" => "credit_card"

                        "amount" => "1000" // total amount after calculate order items if any
                    ]
                ],
                "customer_id" => "cus_2VvOJLacvfE6AwZW"
            );
            $response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
                'body' => json_encode($data),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic c2tfV2VyRzJxM1VyQ0JYdm1MejpCcnVub0AyMDIy',
                    'content-type'  => 'application/json',
                ],
            ]);
            // return json_decode($response->getBody());
            ////////////////////////********** CHARGE PAYMENT ***********/////////////////////////////////
            if (sizeof($found_riders) > 0) {
                $data = [
                    "registration_ids" => $found_riders,
                    "data" => [
                        "title" => 'New Order',
                        "body" => request()->rest->title . ' has a new order! Click to get it asap.',
                        "icon" => url('/public/assets/images/logo.png'),
                        "body" => [
                            "order_id" => $order->order_id
                        ]
                    ]
                ];
                notification_core($data);
                return api_success('Your order has been created successfully! Finding riders for your order. Please wait.', ['order' => $order]);
            } else {
                return api_success('No rider found in your location. Please wait, we will try again in few minutes', ['order' => $order]);
            }
        }
        return api_error();
    }

    public function show()
    {
        $orders = [];
        $latitude  = request()->rider->latitude + 0.0005;
        $longitude = request()->rider->longitude + 0.0005;
        $total_radius = config('server_credentials.distance_in_km');

        $branches = Branch::selectRaw('* , ( 6371 *  acos( cos( radians(?) ) * cos( radians( `latitude`  ) ) * cos( radians( `longitude` ) - radians(?)) + sin( radians(?) ) * sin(radians(`latitude` ) ) )) AS distance', [$latitude, $longitude, $latitude])->having("distance", "<", $total_radius)->whereRaw('`flags` & ?=?', [Branch::FLAG_ACTIVE, Branch::FLAG_ACTIVE])->pluck('branch_id')->toArray();
        if (sizeof($branches)) $orders = Order::whereIn('branch_id', $branches)->where('rider_id', NULL)->where('status', '=', Order::STATUS_RESEARCH)->with(['address_detail', 'branch', 'restaurant'])->get();
        return api_success_app($orders);
    }

    public function order_details_admin(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->with(['rider', 'branch', 'restaurant', 'address_detail'])->first();
        $location = OrderRiderLocation::where('order_id', $order->order_id)->orderBy('id', 'DESC')->first();
        return api_success('Order Details', ['order' => $order, 'rider_location' => $location]);
    }

    public function order_rider_latest_location(Request $request, $id)
    {
        $location = OrderRiderLocation::where('order_id', $id)->orderBy('id', 'DESC')->first();
        return api_success('Order Rider last location', ['rider_location' => $location]);
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function completed_order(Request $request, Order $order)
    {
        $order->status              = Order::STATUS_DELIVERED;
        $order->removeFlag(Order::FLAG_ORDER_ACCEPTED_BY_RIDER);
        $order->removeFlag(Order::PAID_TO_RIDER);
        $order->addFlag(Order::PAID_TO_RIDER);
        if ($order->save()) {
            $rider = Rider::find(request()->rider->rider_id);
            $rider->removeFlag(Rider::FLAG_IS_BUSY);
            if ($rider->save())
                return api_success('Order completed successfully!', []);
        }
        return api_error_app();
    }

    public function get_location(Order $order)
    {
        $branch = Branch::select(
            array('latitude', 'longitude')
        )
            ->where('branch_id', $order->branch_id)
            ->first();
        $address = Address::select(
            array('latitude', 'longitude')
        )
            ->where('address_id', $order->address_id)
            ->first();
        $data = array(
            'branch' => $branch,
            'address' => $address
        );
        return api_success_app($data);
    }

    public function get_all_order($rest_id)
    {
        $data = Order::where('rest_id', $rest_id)->with(['rider', 'order_rating', 'order_questions_rating'])->paginate(10);
        if ($data) return api_success1($data);
        return api_error();
    }

    public function get_rider_order($rider_id)
    {
        $data = Order::where('rider_id', $rider_id)->with(['rider_rating', 'rider_questions_rating'])->paginate(10);
        if ($data) return api_success1($data);
        return api_error();
    }

    public function get_filter_orders(Request $request)
    {
        $per_page = $request->input('per_page', 20);
        $data = array();
        $order = Order::query();
        if ($request->has('by_procured') && $request->filled('by_procured') && $request->by_procured == 1) {
            $order->where('order_number', $request->order_number);
        } else if ($request->has('by_period') && $request->filled('by_period') && $request->by_period == 1) {
            $order->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
        }

        if ($request->has('form_of_payment') && $request->filled('form_of_payment')) {
            $order->where('payment_method', $request->form_of_payment);
        }

        if ($request->has('status') && $request->filled('status')) {
            $order->where('status', $request->status);
        }

        if ($request->has('region_id') && $request->filled('region_id')) {
            $cities = City::where('region_id', $request->region_id)->pluck()->toArray();
            if (sizeof($cities) > 0) {
                $branches = Branch::whereIn('city_id', $cities)->pluck()->toArray();
                if (sizeof($branches) > 0) {
                    $order->whereIn('branch_id', $branches);
                }
            }
        }

        if ($request->has('deliverer_id') && $request->filled('deliverer_id')) {
            $order->where('rider_id', $request->deliverer_id);
        }

        if ($request->has('vehicle_type') && $request->filled('vehicle_type')) {
            $riders = Rider::where('vehicle_type', $request->vehicle_type)->pluck('rider_id')->toArray();
            if (sizeof($riders) > 0) {
                $order->whereIn('rider_id', $riders);
            }
        }

        if ($request->has('store_id') && $request->filled('store_id')) {
            $order->where('rest_id', $request->store_id);
        }
        $order->orderBy('created_at', 'DESC');

        $order->with(['rider', 'branch', 'restaurant', 'address_detail']);
        $data['orders'] = $order->paginate($per_page);
        $data['deliveries_not_period'] = 0;
        $data['deliveries_canceled_no_period'] = 0;
        $data['gross_profit'] = 0;
        $data['net_profit'] = 0;
        if (sizeof($data['orders']) > 0) {
            $deliveries_not_period = 0;
            $deliveries_canceled_no_period = 0;
            $gross_profit = 0;
            $net_profit = 0;
            foreach ($data['orders'] as $order_key => $order_val) {
                if ($order_val->status == Order::STATUS_RESEARCH) {
                    ++$deliveries_not_period;
                } else if ($order_val->status == Order::STATUS_REJECTED) {
                    ++$deliveries_canceled_no_period;
                } else if ($order_val->status == Order::STATUS_DELIVERED) {
                    $gross_profit += $order_val->gross_profit;
                    $net_profit += $order_val->net_profit;
                }
            }
            $data['deliveries_not_period'] = $deliveries_not_period;
            $data['deliveries_canceled_no_period'] = $deliveries_canceled_no_period;
            $data['gross_profit'] = $gross_profit;
            $data['net_profit'] = $net_profit;
        }
        return api_success('Filter Order Api', $data);
    }

    public function accept_order(Request $request, Order $order)
    {
        $rider = Rider::find(request()->rider->rider_id);
        $rider->removeFlag(Rider::FLAG_IS_BUSY);
        if (!$order->rider_id) {
            $order->removeFlag(Order::FLAG_ORDER_ACCEPTED_BY_RIDER);
            $order->addFlag(Order::FLAG_ORDER_ACCEPTED_BY_RIDER);
            $order->status = Order::STATUS_PENDING;
            $order->rider_id = request()->rider->rider_id;
            $order_rider_locations = new OrderRiderLocation;
            $order_rider_locations->order_rider_location_id = Str::uuid();
            $order_rider_locations->rider_id  = $rider->rider_id;
            $order_rider_locations->order_id  = $order->order_id;
            $order_rider_locations->latitude  = $request->latitude;
            $order_rider_locations->longitude = $request->longitude;
            $order_rider_locations->addFlag(OrderRiderLocation::FLAG_ORDER_ACCEPT_LOCATION);

            if ($order->save() && $order_rider_locations->save()) {
                $rider->addFlag(Rider::FLAG_IS_BUSY);
                $rider->save();
                return;
            }
            api_error_app();
        }
        $rider->save();
        return api_error_app('Order already accepted by other rider!');
    }

    public function rest_remove_rider(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        $rider = Rider::where('rider_id', $order->rider_id)->first();
        $rider_location = OrderRiderLocation::where('order_id', $order_id)->where('rider_id', $order->rider_id)->orderBy('id', 'DESC')->first();
        $rider_reject = new RiderReject;
        $rider_reject->rider_reject_id = (string) Str::uuid();
        $rider_reject->order_id = $order_id;
        $rider_reject->rider_id = $rider->rider_id;
        $rider_reject->rider_latitude = $rider_location->latitude;
        $rider_reject->rider_longitude = $rider_location->longitude;
        $rider_reject->reason = $request->reason;
        if ($rider_reject->save()) {
            $order->rider_id = NULL;
            $order->status = Order::STATUS_RESEARCH;
            $order->removeFlag(Order::CHAT_RIDER_STARTED_FROM_REST);
            $order->removeFlag(Order::CHAT_RIDER_STARTED_FROM_ADMIN);
            $order->removeFlag(Order::FLAG_ORDER_ACCEPTED_BY_RIDER);
            $order->removeFlag(Order::ORDER_PICKUP);

            $rider->removeFlag(Rider::FLAG_IS_BUSY);
            if ($order->save() && $rider->save()) {
                $all_riders = RiderReject::where('order_id', $order_id)->pluck('rider_id');
                $branch = Branch::where('branch_id', $order->branch_id)->first();
                $latitude = $branch->latitude + 0.0005;
                $longitude = $branch->longitude + 0.0005;
                $total_radius = config('server_credentials.distance_in_km');

                $found_riders = Rider::selectRaw('* , ( 6371 *  acos( cos( radians(?) ) * cos( radians( `latitude`  ) ) * cos( radians( `longitude` ) - radians(?)) + sin( radians(?) ) * sin(radians(`latitude` ) ) )) AS distance', [$latitude, $longitude, $latitude])->having("distance", "<", $total_radius)->whereNotIn('rider_id', $all_riders)->whereNotNull('device_token')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->pluck('device_token')->toArray();

                if (sizeof($found_riders) > 0) {
                    $data = [
                        "registration_ids" => $found_riders,
                        "data" => [
                            "title" => 'New Order',
                            "body" => request()->rest->title . ' has a new order! Click to get it asap.',
                            "icon" => url('/public/assets/images/logo.png'),
                            "body" => [
                                "order_id" => $order->order_id
                            ]
                        ]
                    ];
                    notification_core($data);
                    return api_success('Your order has been created successfully! Finding riders for your order. Please wait.', ['order' => $order]);
                }
                return api_success('No rider found in your location. Please wait, we will try again in few minutes', ['order' => $order]);
            }
        }
    }

    public function get_order_address(Order $order)
    {
        $order->address = Address::where('address_id', $order->address_id)->first();
        $order->branch = Branch::where('branch_id', $order->branch_id)->first();
        if ($order) return api_success_app($order);
        return api_error_app();
    }

    public function cancel_order_by_rest(Request $request, Order $order)
    {
        $order->order_cancel_question_id = $request->order_cancel_question_id;
        $order->order_cancel_question    = $request->order_cancel_question;
        $order->order_cancel_comment     = $request->order_cancel_comment;
        $order->status                   = Order::STATUS_REJECTED;
        if ($order->save()) {
            $rider = Rider::where('rider_id', $order->rider_id)->first();
            $rider->removeFlag(Rider::FLAG_IS_BUSY);
            $rider->save();

            return api_success('Order got cancelled successfully!', ['order' => $order]);
        }
        return api_error();
    }

    public function cancel_order_by_rider(Request $request, Order $order)
    {
        $order->order_cancel_question_id = $request->order_cancel_question_id;
        $order->order_cancel_question    = $request->order_cancel_question;
        $order->order_cancel_comment     = $request->order_cancel_comment;
        $order->status                   = Order::STATUS_REJECTED;
        $order->addFlag(Order::REJECTED_BY_RIDER);
        if ($order->save()) {
            $rider = Rider::where('rider_id', $order->rider_id)->first();
            $rider->removeFlag(Rider::FLAG_IS_BUSY);
            $rider->save();

            return api_success_app('');
        }
        return api_error_app();
    }

    public function reject_order_by_rider(Request $request, Order $order)
    {
        $rider = Rider::where('rider_id', $order->rider_id)->first();
        $rider->removeFlag(Rider::FLAG_IS_BUSY);
        $rider->save();

        $rider_reject = new RiderReject;
        $rider_reject->rider_reject_id = (string) Str::uuid();
        $rider_reject->order_id = $order->order_id;
        $rider_reject->rider_id = $rider->rider_id;
        $rider_reject->addFlag(RiderReject::FLAG_REJECTED_BY_RIDER);
        $rider_reject->save();

        if ($rider_reject->save() && $rider->save()) return 'Order Rejected';
        return api_error_app();
    }

    public function rider_orders_balance()
    {
        $orders = Order::where('rider_id', request()->rider->rider_id)
            ->where('status', Order::STATUS_DELIVERED)
            ->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->get();
        $day_balance = $orders->sum('delivery_charges') + $orders->sum('rider_return_fee');
        $data = array("orders" => $orders, "day_balance" => $day_balance);
        if ($data) return api_success_app($data);
        return api_error_app();
    }
    public function search_orders_rider_date(Request $request)
    {
        $orders = [];
        $total_balance = 0;
        if ($request->has('key') && $request->filled('key') && $request->key == 'today') {
            $orders = Order::where('rider_id', request()->rider->rider_id)
                ->where('status', Order::STATUS_DELIVERED)
                ->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
                ->whereRaw('`flags` & ?=?', [Order::PAID_TO_RIDER, Order::PAID_TO_RIDER])
                ->with(['restaurant', 'branch'])
                ->get();
        } else if ($request->has('key') && $request->filled('key') && $request->key == 'yesterday') {
            $orders = Order::where('rider_id', request()->rider->rider_id)
                ->where('status', Order::STATUS_DELIVERED)
                ->whereDate('created_at', '>=', date('Y-m-d 17:00:00', strtotime("-1 days")))
                ->whereRaw('`flags` & ?=?', [Order::PAID_TO_RIDER, Order::PAID_TO_RIDER])
                ->with(['restaurant', 'branch'])
                ->get();
        } else if ($request->has('key') && $request->filled('key') && $request->key == 'current_week') {
            $orders = Order::where('rider_id', request()->rider->rider_id)
                ->where('status', Order::STATUS_DELIVERED)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->whereRaw('`flags` & ?=?', [Order::PAID_TO_RIDER, Order::PAID_TO_RIDER])
                ->with(['restaurant', 'branch'])
                ->get();
        } else if ($request->has('key') && $request->filled('key') && $request->key == 'specific_date') {
            $orders = Order::where('rider_id', request()->rider->rider_id)
                ->where('status', Order::STATUS_DELIVERED)
                ->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
                ->whereRaw('`flags` & ?=?', [Order::PAID_TO_RIDER, Order::PAID_TO_RIDER])
                ->with(['restaurant', 'branch'])
                ->get();
        }
        if ($orders) {
            $total_balance = $orders->sum('delivery_charges') + $orders->sum('rider_return_fee');
        }
        $total_orders  = count($orders);
        $data = array("total_orders" => $total_orders, "total_balance" => $total_balance, "orders" => $orders);
        if ($data) return api_success_app($data);
        return api_error_app();
    }

    public function rider_day_orders()
    {
        $orders = Order::where('rider_id', request()->rider->rider_id)
            ->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])
            ->get();
        $data = array("orders" => $orders);
        if ($data) return api_success_app($data);
        return api_error_app();
    }
    public function rider_all_cancel_orders()
    {
        $first_flag = OrderRiderLocation::FLAG_ORDER_ACCEPT_LOCATION;
        $orders = Order::where('rider_id', request()->rider->rider_id)
            ->where('status', Order::STATUS_REJECTED)
            ->whereRaw('`flags` & ?=?', [Order::REJECTED_BY_RIDER, Order::REJECTED_BY_RIDER])
            ->with(['restaurant', 'branch', 'address_detail', 'rider_last_location' => function ($q) use ($first_flag) {
                $q->whereRaw('`flags` & ?=?', [$first_flag, $first_flag]);
            }])
            ->get();
        $data = array("orders" => $orders);
        if ($data) return api_success_app($data);
        return api_error_app();
    }

    public function update_collect_time(Order $order)
    {
        $order->output_time         = date('Y-m-d H:i:s');
        $order->addFlag(Order::ORDER_PICKUP);
        $order->save();
        return api_success_app('Pickup Time Updated!');
    }
}
