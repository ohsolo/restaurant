<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Order_Transaction;
use App\Models\Restaurant;
use App\Models\RestaurantRefill;
use Facade\FlareClient\Api;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Monthly record 
        $orders = Order::whereMonth('created_at', $request->month)
            ->whereYear('created_at', $request->year)
            ->get();
        $net_profit    = $orders->sum('net_profit');
        $gross_profit  = $orders->sum('gross_profit');
        $rider_payment = Transaction::whereMonth('created_at', $request->month)
            ->whereYear('created_at', $request->year)
            ->WhereRaw("`flags` & ? = ?", [Transaction::FLAG_STATUS_COMPLETED, Transaction::FLAG_STATUS_COMPLETED])
            ->sum('amount');
        // Monthly record 

        // Filtered records and All records
        $total_records = 0;
        $data = array();
        if ($request->type && $request->type == 'transactions') {
            $data = Transaction::when($request->search && $request->filled('search'), function ($query) use ($request) {
                $query->whereHas('restaurant', function ($query) use ($request) {
                    return $query->where('title', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('rider', function ($query) use ($request) {
                        return $query->where('name', 'like', '%' . $request->search . '%');
                    });
            })
                ->when($request->specific_date && $request->filled('specific_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                })
                ->WhereRaw("`flags` & ? = ?", [Transaction::FLAG_ADMIN_REQUEST, Transaction::FLAG_ADMIN_REQUEST])
                ->orderBy('created_at', 'desc')
                ->with(['rider', 'restaurant'])
                ->paginate(10);
        } else if ($request->type && $request->type == 'reviews') {
            $data = Transaction::when($request->search && $request->filled('search'), function ($query) use ($request) {
                $query->whereHas('restaurant', function ($query) use ($request) {
                    return $query->where('title', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('rider', function ($query) use ($request) {
                        return $query->where('name', 'like', '%' . $request->search . '%');
                    });
            })
                ->when($request->specific_date && $request->filled('specific_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                })
                ->WhereRaw("`flags` & ? = ?", [Transaction::FLAG_RIDER_REQUEST, Transaction::FLAG_RIDER_REQUEST])
                ->orderBy('created_at', 'desc')
                ->with(['rider', 'restaurant'])
                ->paginate(10);
        } else if ($request->type && $request->type == 'refills') {
            $data = RestaurantRefill::when($request->search && $request->filled('search'), function ($query) use ($request) {
                $query->whereHas('restaurant', function ($query) use ($request) {
                    return $query->where('title', 'like', '%' . $request->search . '%');
                });
            })
                ->when($request->specific_date && $request->filled('specific_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                })
                ->orderBy('created_at', 'desc')
                ->with('restaurant')
                ->paginate(10);
        } else if ($request->type && $request->type == 'balance') {
            $data = Restaurant::when($request->search && $request->filled('search'), function ($query) use ($request) {
                $query->where('rest_id', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            })
                ->when($request->specific_date && $request->filled('specific_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        if (sizeof($data))
            $total_records  = count($data);


        $data = array(
            "net_profit"    => $net_profit,
            "gross_profit"  => $gross_profit,
            "rider_payment" => $rider_payment,
            "total_records" => $total_records,
            "data"          => $data
        );

        if ($data) return api_success_app($data);
        return api_error_app();
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
    #TODO: Transaction make confirmed then set remaing balance in to restaurant's balance column
    public function store(StoreTransactionRequest $request)
    {

        $payment                     = 0;
        $find_order                  = Order::whereIn('order_id', $request->orders)->get();
        if (sizeof($find_order)) $payment = $find_order->sum('rest_order_amount');

        $transaction                 = new Transaction;
        $transaction->transaction_id = Str::uuid();
        $transaction->rider_id       = request()->rider->rider_id;
        $transaction->rest_id        = $request->rest_id;
        $transaction->amount         = $payment;
        // $transaction->response = $request->response;
        $transaction->addFlag(Transaction::FLAG_RIDER_REQUEST);
        $transaction->addFlag(Transaction::FLAG_STATUS_PENDING);
        if ($request->request_status && $request->request_status == "quick_withdraw_request") {
            $transaction->addFlag(Transaction::FLAG_QUICK_WITHDRAW);
        }

        if ($transaction->save()) {
            foreach ($find_order as $order) {
                $order_transaction                          = new Order_Transaction;
                $order_transaction->order_transaction_id    = Str::uuid();
                $order_transaction->transaction_id          = $transaction->transaction_id;
                $order_transaction->order_id                = $order->order_id;
                $order_transaction->amount                  = $order->rest_order_amount;

                $order_transaction->save();
            }
        }

        if ($transaction->save()) return api_success_app('Transaction completed successfully');
        return api_error_app();
    }

    public function admin_transaction_request(StoreTransactionRequest $request)
    {
        $payment                     = 0;
        $find_order                  = Order::whereIn('order_id', $request->orders)->get();

        if (sizeof($find_order)) $payment = $find_order->sum('rest_order_amount');

        $transaction                 = new Transaction;
        $transaction->transaction_id = Str::uuid();
        $transaction->rider_id       = $request->rider_id;
        $transaction->rest_id        = $request->rest_id;
        $transaction->amount         = $payment;
        // $transaction->response = $request->response;
        $transaction->addFlag(Transaction::FLAG_ADMIN_REQUEST);
        #TODO: BANK API'S AND ADD FLAG_STATUS_COMPLETED
        // $transaction->addFlag(Transaction::FLAG_STATUS_COMPLETED);

        if ($transaction->save()) {
            foreach ($find_order as $order) {
                $order_transaction                          = new Order_Transaction;
                $order_transaction->order_transaction_id    = Str::uuid();
                $order_transaction->transaction_id          = $transaction->transaction_id;
                $order_transaction->order_id                = $order->order_id;
                $order_transaction->amount                  = $order->rest_order_amount;
                #TODO: BANK API'S AND ADD FLAG_STATUS_COMPLETED
                $order_transaction->addFlag(Order_Transaction::FLAG_STATUS_COMPLETED);
                $order_transaction->save();
            }
        }

        if ($transaction->save()) return api_success1('Transaction completed successfully');
        return api_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function paymentMethodApis(Request $request)
    {
       
        $data   = $request->except(['api_method', 'api_key']);
        $api    = '';
        $method = '';

      
            $api    = "https://api.pagar.me/core/v5/orders";

        $client = new \GuzzleHttp\Client();
            $response = $client->request($method, $api, [
                'body' => json_encode($data),
                'headers' => [
                    'accept'        => 'application/json',
                    'content-type'  => 'application/json',
                    'authorization' => 'Basic c2tfV2VyRzJxM1VyQ0JYdm1MejpCcnVub0AyMDIy',
                ],
            ]);
          

        return api_success('customer created successfully', json_decode($response->getBody()));
    }
    public function show(Request $request)
    {
        $transactions = Transaction::when($request->key == 'today', function ($query) {
            $query->whereBetween('created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59']);
        })
            ->when($request->key == 'current_week', function ($query) {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })
            ->when($request->key == 'specific_date', function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            })
            ->when($request->status && $request->status == Transaction::FLAG_STATUS_COMPLETED, function ($query) {
                $query->whereRaw('`flags` & ?=?', [Transaction::FLAG_STATUS_COMPLETED, Transaction::FLAG_STATUS_COMPLETED]);
            })
            ->when($request->status && $request->status == Transaction::FLAG_STATUS_PENDING, function ($query) {
                $query->whereRaw('`flags` & ?=?', [Transaction::FLAG_STATUS_PENDING, Transaction::FLAG_STATUS_PENDING]);
            })
            ->when($request->status && $request->status == Transaction::FLAG_STATUS_PROCESSING, function ($query) {
                $query->whereRaw('`flags` & ?=?', [Transaction::FLAG_STATUS_PROCESSING, Transaction::FLAG_STATUS_PROCESSING]);
            })
            ->when($request->status && $request->status == Transaction::FLAG_STATUS_REJECTED, function ($query) {
                $query->whereRaw('`flags` & ?=?', [Transaction::FLAG_STATUS_REJECTED, Transaction::FLAG_STATUS_REJECTED]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($transactions) return api_success("Transactions", ["transactions" => $transactions]);
        return api_error();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
