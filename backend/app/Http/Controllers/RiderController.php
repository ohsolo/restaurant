<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RiderDetailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

use App\Models\BankDetail;
use App\Models\Region;
use App\Models\Rider;
use App\Models\LoginAttempt;
use App\Http\Requests\RiderRegister as RiderRegisterRequest;
use App\Http\Requests\RiderLoginRequest;
use App\Models\Order;
use App\Models\RestaurantOccurrence;
use App\Models\OrderRiderLocation;

use App\Mail\RiderResetPasswordLinkMail;
use App\Models\PendingInfo;

class RiderController extends Controller
{
    public function login(RiderLoginRequest $request)
    {
        $rider = Rider::where("email", $request->email)->first();
        if ($rider && HASH::check($request->password, $rider->password)) {
            request()->rider = $rider;
            $login_attempt = new LoginAttempt();
            $login_attempt->user_id = $rider->rider_id;
            $login_attempt->access_token = generate_token($rider);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) return api_error();

            $data = array(

                'token_detail' => array(
                    'access_token' => $login_attempt->access_token,
                    'token_type' => 'Bearer'
                )
            );
            return api_success_app($data);
        }

        return api_error_app('Invalid Email or Password');
    }

    public function index(Request $request)
    {
        $riders = Rider::query();
        if ($request->has('status') && $request->filled('status') && $request->status == 'awaiting') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_AWAITING, Rider::FLAG_AWAITING]);
        } else if ($request->has('status') && $request->filled('status') && $request->status == 'blocked') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_BLOCKED, Rider::FLAG_BLOCKED]);
        } else if ($request->has('status') && $request->filled('status') && $request->status == 'active') {
            $riders->whereRaw("flags & ? = ?", [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE]);
        }

        if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'car') {
            $riders->where('vehicle_type', 'car');
        } else if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'bike') {
            $riders->where('vehicle_type', 'bike');
        } else if ($request->has('vehicle') && $request->filled('vehicle') && $request->vehicle == 'bicycle') {
            $riders->where('vehicle_type', 'bicycle');
        }

        if ($request->has('search') && $request->filled('search')) {
            $riders->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('cpf', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('region') && $request->filled('region')) {
            $riders->where('region_id', $request->region);
        }

        $riders->with(['region', 'rest_reviews', 'rider_reviews']);
        $riders->orderBy('id', 'DESC');
        $all_regions = Region::whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE])->get();
        $data['regions'] = $all_regions;
        $data['riders'] = $riders->paginate(10);

        return api_success('Riders And Regions Data', $data);
    }

    public function store(RiderRegisterRequest $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("post", "https://api.pagar.me/core/v5/customers", [
            'body' => json_encode(["email" => $request->email, "name" => $request->name]),
            'headers' => [
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
                'authorization' => 'Basic c2tfV2VyRzJxM1VyQ0JYdm1MejpCcnVub0AyMDIy',
            ],
        ]);
        if (!isset(json_decode($response->getBody())->id)) return api_error('customer not create at payment platform');
        if (!is_dir(public_path("assets/riders/"))) {
            mkdir(public_path("assets/riders/"), 0777, true);
        }

        $rider = new Rider;
        $rider->rider_id = (string) Str::uuid();
        $rider->customer_id = json_decode($response->getBody())->id;
        $rider->name = $request->name;
        $rider->email = $request->email;
        $rider->phone = $request->phone;
        $rider->password = Hash::make($request->password);
        $rider->cpf = $request->cpf;
        $rider->vehicle_type = $request->vehicle_type;
        $rider->region_id = $request->region_id;

        mkdir(public_path("assets/riders/" . $rider->rider_id), 0777, true);

        if ($request->hasFile('profile_image')) {
            $profile_image = addFile($request->file('profile_image'), public_path("assets/riders/" . $rider->rider_id), 200, 200);
            $rider->logo_image = $profile_image;
        }

        if ($request->hasFile('cnh_image')) {
            $cnh_image = addFile($request->file('cnh_image'), public_path("assets/riders/" . $rider->rider_id), 200, 200);
            $rider->cnh_image = $cnh_image;
        }

        $rider->addFlag(Rider::FLAG_AWAITING);

        if (!$rider->save()) return api_error();

        // $bank_detail = new BankDetail;
        // $bank_detail->bank_detail_id = (string) Str::uuid();
        // $bank_detail->rider_id = $rider->rider_id;
        // $bank_detail->bank = $request->bank;
        // $bank_detail->agency = $request->agency;
        // $bank_detail->account_verification_code = $request->digit;
        // $bank_detail->account = $request->account;
        // if (!$bank_detail->save()) return api_error_app();

        return api_success_app('Rider Registered Successfully');
    }

    public function update(Request $request, $id)
    {
        $rider = Rider::where('rider_id', $id)->first();
        $rider->name = $request->input('name', $rider->name);
        $rider->vehicle_type = $request->input('vehicle_type', $rider->vehicle_type);
        $rider->region_id = $request->input('region_id', $rider->region_id);

        if ($request->has('status') && $request->filled('status')) {
            $rider->removeFlag(Rider::FLAG_ACTIVE);
            $rider->removeFlag(Rider::FLAG_BLOCKED);
            $rider->removeFlag(Rider::FLAG_AWAITING);

            if ($request->status == 'active') {
                $rider->addFlag(Rider::FLAG_ACTIVE);
            } else if ($request->status == 'blocked') {
                $rider->addFlag(Rider::FLAG_BLOCKED);
            } else {
                $rider->addFlag(Rider::FLAG_AWAITING);
            }
        }

        if ($rider->save()) return api_success1('Rider Updated Successfully');
        return api_error();
    }

    public function block_rider(Request $request)
    {
        $rider = Rider::where('rider_id', $request->rider_id)->first();

        if ($request->has("inform") && $request->filled("inform") && $request->inform == 'yes') {
            $rider->block_reason = $request->block_reason;
        }
        $rider->block_date = date('Y-m-d');
        $rider->removeFlag(Rider::FLAG_ACTIVE);
        $rider->removeFlag(Rider::FLAG_BLOCKED);
        $rider->removeFlag(Rider::FLAG_AWAITING);
        $rider->addFlag(Rider::FLAG_BLOCKED);
        if ($rider->save()) return api_success1('Rider Blocked Successfully!');

        return api_error();
    }

    public function unblock_rider(Request $request)
    {
        $rider = Rider::where('rider_id', $request->rider_id)->first();
        $rider->block_reason = '';
        $rider->approve_reason = $request->approve_reason;

        $rider->removeFlag(Rider::FLAG_ACTIVE);
        $rider->removeFlag(Rider::FLAG_BLOCKED);
        $rider->removeFlag(Rider::FLAG_AWAITING);
        $rider->addFlag(Rider::FLAG_ACTIVE);
        if ($rider->save()) return api_success1('Rider Active Successfully!');

        return api_error();
    }

    public function exclude_driver(Request $request)
    {
        Rider::where('rider_id', $request->rider_id)->delete();
        return api_success1('Rider Deleted Successfully!');
    }

    public function get_riders_by_name(Request $request)
    {
        $all_riders = Rider::where('name', 'LIKE', '%' . $request->search . '%')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->get();
        if (sizeof($all_riders) > 0) {
            return api_success_app($all_riders);
        }
        return api_error_app('No Rider Found!');
    }

    public function get_riders_by_name_admin(Request $request)
    {
        $all_riders = Rider::where('name', 'LIKE', '%' . $request->search . '%')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->get();
        if (sizeof($all_riders) > 0) {
            return api_success('Riders Data', ['riders' => $all_riders]);

        }
        return api_error('No Rider Found!');
    }

    public function rider_available_status_update(Request $request)
    {
        $rider = Rider::where('rider_id', request()->rider->rider_id)->first();

        if ($rider->is_available) {
            $order = Order::where('rider_id', request()->rider->rider_id)
                ->whereRaw('`flags` & ?=?', [Order::FLAG_ORDER_ACCEPTED_BY_RIDER, Order::FLAG_ORDER_ACCEPTED_BY_RIDER])->first();
            if (!$order) {
                $rider->removeFlag(Rider::FLAG_IS_AVAILABLE);
            } else {
                return api_error_app("You can't go offline until complete your order.");
            }
        } else {
            $rider->addFlag(Rider::FLAG_IS_AVAILABLE);
        }
        if ($rider->save()) {
            return api_success_app($rider);
        }
        return api_error_app();
    }

    public function show()
    {
        if (request()->rider) {
            $rider = Rider::where('rider_id', request()->rider->rider_id)->with('bank_detail', 'region')->first();
            return api_success_app($rider);
        }
        return api_error_app('Rider not logged in!');
    }

    public function occurrences()
    {
        $rider = Rider::whereRaw('`flags` & ?=?', [Rider::FLAG_OCCURRENCE_FOUND, Rider::FLAG_OCCURRENCE_FOUND])
            ->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])
            ->orderBy('created_at', 'desc')
            ->with(['bank_detail', 'region', 'rest_reviews', 'rider_reviews', 'occurrences'])
            ->paginate(10);
        return api_success('rider_occurences', ['rider_occurences' => $rider]);
    }

    public function logout(Request $request)
    {
        $rider = Rider::where('rider_id', request()->rider->rider_id)->first();
        $rider->device_token = NULL;
        $rider->removeFlag(Rider::FLAG_IS_AVAILABLE);
        $rider->save();
        if ($request->login_attempt) {
            $request->login_attempt->access_expiry = date("Y-m-d H:i:s");
            $request->login_attempt->save();
            return "success";
        }
        return api_error_app();
    }

    public function rider_check_email_for_forget_password(Request $request)
    {
        $rider = Rider::where('email', $request->email)->first();
        if ($rider) {
            $rider->reset_password_token = (string) Str::uuid();
            if ($rider->save()) {
                Mail::to($rider->email)->send(new RiderResetPasswordLinkMail($rider));
                if (count(Mail::failures()) > 0) return api_error('Rest password email couldn\'t send!', 400);

                return response()->json('', 200);
            }
        }
        return api_error('Invalid Email!', 400);
    }

    public function check_forget_password_token(Request $request)
    {
        $rider = Rider::where('reset_password_token', $request->token)->first();
        if ($rider) {
            return api_success1('Valid Token!');
        }
        return api_error('Invalid Token!', 400);
    }

    public function update_password(Request $request)
    {
        $rider = Rider::where('reset_password_token', $request->token)->first();
        if ($rider) {
            $rider->password = Hash::make($request->password);
            $rider->reset_password_token = NULL;
            if ($rider->save()) return api_success1('Password Updated Successfully');
        }
        return api_error('Invalid Token!');
    }
    public function change_password(ChangePasswordRequest $request)
    {
        $rider = Rider::where('rider_id', request()->rider->rider_id)->first();
        if ($rider && HASH::check($request->current_password, $rider->password)) {
            $rider->password = Hash::make($request->new_password);
            if ($rider->save()) return api_success1('Password Updated Successfully');
        }
        return api_error('current password did not match');
    }

    public function update_rider_details(Request $request)
    {
        $pending_info = PendingInfo::where('rider_id', $request->rider_id)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($request->status == PendingInfo::STATUS_APPROVED && $pending_info) {
            $rider = Rider::find( $request->rider_id);
            $rider->cpf = $pending_info->cpf;
            $rider->phone = $pending_info->phone;
            $rider->name = $pending_info->name;
            $pending_info->status = PendingInfo::STATUS_APPROVED;
            $pending_info->save();
            if ($rider->save()) return api_success_app('Riders details updated Successfully');
            return api_error_app('Riders details did not updated ');
        } elseif ($request->status == PendingInfo::STATUS_REJECTED && $pending_info) {
            $pending_info->status = PendingInfo::STATUS_REJECTED;
            $pending_info->comment = $request->comment;
            if ($pending_info->save()) return api_success_app('Riders details Rejected');
        }
        return api_error_app('rider details not found');
    }
    public function show_details($id)
    {
        $rider_details = PendingInfo::where('rider_id', $id)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($rider_details) return api_success_app($rider_details);
        return api_error_app('not found');
    }

    public function get_rider_in_progress_order (Request $request)
    {
        $first_flag = OrderRiderLocation::FLAG_ORDER_ACCEPT_LOCATION;
        $order = Order::where('rider_id', request()->rider->rider_id)->whereRaw('`flags` & ?=?', [Order::FLAG_ORDER_ACCEPTED_BY_RIDER, Order::FLAG_ORDER_ACCEPTED_BY_RIDER])->with(['restaurant', 'branch', 'address_detail', 'rider_last_location' => function ($q) use ($first_flag) {
            $q->whereRaw('`flags` & ?=?', [$first_flag, $first_flag]);
        }])->first();
        return api_success_app($order);
    }

    public function stats (Request $request, Rider $rider)
    {
        $data['occurences_found'] = 0;
        $data['last_login'] = '';
        $data['joining_date'] = $rider->created_at->format('Y-m-d H:i:s');
        $data['delivered_order_count'] = Order::where('rider_id', $rider->rider_id)->where('status', Order::STATUS_DELIVERED)->whereRaw('`flags` & ?=?', [Order::REJECTED_BY_RIDER, Order::REJECTED_BY_RIDER])->count();
        $data['cancelled_order_count'] = Order::where('rider_id', $rider->rider_id)->where('status', Order::STATUS_REJECTED)->whereRaw('`flags` & ?=?', [Order::REJECTED_BY_RIDER, Order::REJECTED_BY_RIDER])->count();
        if ($rider->occurrence_found) {
            $data['occurences_found'] = RestaurantOccurrence::where('rider_id', $rider->rider_id)->count();

        }
        $la = LoginAttempt::where('user_id', $rider->rider_id)->orderBy('id', 'desc')->first();
        if ($la) {
            $data['last_login'] = $la->updated_at->format('Y-m-d H:i:s');

        }
        return api_success('Rider stats', $data);
    }
}
