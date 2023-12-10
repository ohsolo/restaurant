<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

use App\Models\BankDetail;
use App\Models\Rider;
use App\Models\Restaurant;
use App\Models\LoginAttempt;

use App\Http\Requests\StoreRestaurant as StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurant as UpdateRestaurantRequest;
use App\Http\Requests\AdminLogin as AdminLoginRequest;

use App\Mail\RestaurantResetPasswordLinkMail;

class RestaurantController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $rest = Restaurant::where("email", $request->email)->first();
        if ($rest && HASH::check($request->password, $rest->password)) {
            request()->rest = $rest;
            $login_attempt = new LoginAttempt();
            $login_attempt->user_id = $rest->rest_id;
            $login_attempt->access_token = generate_token($rest);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) return api_error();

            $data = array(
                'message' => 'Login Successfully',
                'detail' => $rest,
                'token_detail' => array(
                    'access_token' => $login_attempt->access_token,
                    'token_type' => 'Bearer'
                )
            );
            return api_success('Restaurant LoggedIn Successfully', $data);
        }

        return api_error('Invalid Email or Password', 400);
    }

    public function index(Request $request)
    {
        $rests = Restaurant::query();
        if ($request->has('search') && $request->filled('search')) {
            $rests->where('title', 'like', '%' . $request->search . '%');
        }
        $rests->orderBy('id', 'DESC');
        return api_success('Restaurants Data', $rests->paginate(10));
    }

    public function get_active_restaurants(Request $request)
    {
        $rests = Restaurant::query();
        $rests->whereRaw("flags & ? = ?", [Restaurant::FLAG_ACTIVE, Restaurant::FLAG_ACTIVE]);
        if ($request->has('search') && $request->filled('search')) {
            $rests->where('title', 'like', '%' . $request->search . '%');
        }
        $rests->orderBy('id', 'DESC')->with('reviews');
        return api_success('Restaurants Data', $rests->paginate(10));
    }


    public function store(StoreRestaurantRequest $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("post", "https://api.pagar.me/core/v5/customers", [
            'body' => json_encode(["email" => $request->email, "name" => $request->title]),
            'headers' => [
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
                'authorization' => 'Basic c2tfV2VyRzJxM1VyQ0JYdm1MejpCcnVub0AyMDIy',
            ],
        ]);
        if (!isset(json_decode($response->getBody())->id)) return api_error('customer not create at payment platform');
        if (!is_dir(public_path("assets/restaurants/"))) {
            mkdir(public_path("assets/restaurants/"), 0777, true);
        }
        $restaurant = new Restaurant;
        $restaurant->rest_id = (string) Str::uuid();
        $restaurant->title = $request->title;
        $restaurant->customer_id = json_decode($response->getBody())->id;
        $restaurant->email = $request->email;
        $restaurant->phones = json_encode($request->phones);
        $restaurant->password = Hash::make($request->password);
        $restaurant->cnpj = $request->cnpj;
        $restaurant->cep = $request->cep;
        $restaurant->social_reason = $request->social_reason;
        $restaurant->public_place = $request->public_place;
        $restaurant->neighbourhood = $request->neighbourhood;

        mkdir(public_path("assets/restaurants/" . $restaurant->rest_id), 0777, true);

        if ($request->hasFile('logo')) {
            $logo = addFile($request->file('logo'), public_path("assets/restaurants/" . $restaurant->rest_id), 200, 200);
            $restaurant->logo = $logo;
        }

        $restaurant->addFlag(Restaurant::FLAG_ACTIVE);
        if (!$restaurant->save()) return api_error();

        $bank_detail = new BankDetail;
        $bank_detail->bank_detail_id = (string) Str::uuid();
        $bank_detail->rest_id = $restaurant->rest_id;
        $bank_detail->bank = $request->bank;
        $bank_detail->agency = $request->agency;
        $bank_detail->agency_verification_code = $request->agency_verification_code;
        $bank_detail->account = $request->account;
        $bank_detail->account_verification_code = $request->account_verification_code;

        if (!$bank_detail->save()) return api_error();

        return api_success1('Restaurant Registered Successfully');
    }
    public function update(Restaurant $restaurant, UpdateRestaurantRequest $request)
    {
        $old_logo = $restaurant->logo;
        if (!is_dir(public_path("assets/restaurants/"))) {
            mkdir(public_path("assets/restaurants/"), 0777, true);
        }
        $restaurant->title = $request->input('title', $restaurant->title);
        if ($request->has('phones')) {
            $restaurant->phones = json_encode($request->phones);
        }
        $restaurant->cnpj = $request->input('cnpj', $restaurant->cnpj);
        $restaurant->cep = $request->input('cep', $restaurant->cep);
        $restaurant->social_reason = $request->input('social_reason', $restaurant->social_reason);
        $restaurant->public_place = $request->input('public_place', $restaurant->public_place);
        $restaurant->neighbourhood = $request->input('neighbourhood', $restaurant->neighbourhood);

        if (!is_dir(public_path("assets/restaurants/" . $restaurant->rest_id))) {
            mkdir(public_path("assets/restaurants/" . $restaurant->rest_id), 0777, true);
        }

        if ($request->hasFile('logo')) {
            $logo = addFile($request->file('logo'), public_path("assets/restaurants/" . $restaurant->rest_id), 200, 200);
            if ($logo) {
                $restaurant->logo = $logo;
                unlink(public_path("assets/restaurants/" . $restaurant->rest_id . '/' . $old_logo));
            }
        }

        if ($restaurant->save()) return api_success1('Restaurant Updated Successfully');
        return api_error();

        // $bank_detail = new BankDetail;
        // $bank_detail->bank_detail_id = (String) Str::uuid();
        // $bank_detail->rest_id = $restaurant->rest_id;
        // $bank_detail->bank = $request->bank; 
        // $bank_detail->agency = $request->agency; 
        // $bank_detail->agency_verification_code = $request->agency_verification_code; 
        // $bank_detail->account = $request->account; 
        // $bank_detail->account_verification_code = $request->account_verification_code; 

        // if (!$bank_detail->save()) return api_error();

        // return api_success1('Restaurant Registered Successfully');
    }

    public function show(Request $request, $id)
    {
        $rest = Restaurant::where('rest_id', $id)->first();
        return api_success('Restaurant Data', $rest);
    }

    public function update_restaurant_props(Request $request, $id)
    {
        $restaurant = Restaurant::where('rest_id', $id)->first();
        $restaurant->removeFlag(Restaurant::FLAG_MIRROR_TAX);
        if ($request->has('tax_by_distance') && $request->filled('tax_by_distance') && $request->has('custom_tax') && $request->filled('custom_tax')) {
            $restaurant->removeFlag(Restaurant::FLAG_TAX_BY_DISTANCE);
            $restaurant->removeFlag(Restaurant::FLAG_CUSTOM_TAX);

            if ($request->tax_by_distance == 1) $restaurant->addFlag(Restaurant::FLAG_TAX_BY_DISTANCE);
            else $restaurant->addFlag(Restaurant::FLAG_CUSTOM_TAX);
        }

        if ($request->has('mirror_tax') && $request->filled('mirror_tax') && $request->mirror_tax == 1) {
            $restaurant->addFlag(Restaurant::FLAG_MIRROR_TAX);
        }
        if (!$restaurant->save()) return api_error();

        return api_success('Restaurant Properties Updated Successfully', ['restaurant' => $restaurant]);
    }

    public function block_rest(Request $request)
    {
        $rest = Restaurant::where('rest_id', $request->rest_id)->first();

        if ($request->inform == 'yes') {
            $rest->blocked_reason = $request->blocked_reason;
        }
        $rest->removeFlag(Rider::FLAG_ACTIVE);
        if ($rest->save()) return api_success1('Restaurant Blocked Successfully!');

        return api_error();
    }

    public function unblock_rest(Request $request)
    {
        $rest = Restaurant::where('rest_id', $request->rest_id)->first();
        $rest->blocked_reason = '';
        $rest->approve_reason = $request->approve_reason;

        $rest->removeFlag(Restaurant::FLAG_ACTIVE);
        $rest->addFlag(Restaurant::FLAG_ACTIVE);
        if ($rest->save()) return api_success1('Restaurant Active Successfully!');

        return api_error();
    }

    public function exclude_rest(Request $request)
    {
        Restaurant::where('rest_id', $request->rest_id)->delete();
        return api_success1('Restaurant Deleted Successfully!');
    }

    public function verify_email(Request $request)
    {
        $rest = Restaurant::where('email', $request->email)->first();
        if ($rest) {
            $rest->reset_password_token = (string) Str::uuid();
            if ($rest->save()) {
                Mail::to($rest->email)->send(new RestaurantResetPasswordLinkMail($rest));
                if (count(Mail::failures()) > 0) return api_error('Login email couldn\'t send!', 500);

                return api_success1('We have sent you a link on to your email address. Kindly open it and change your password!', 'send_email');
            }
        }
        return api_error('Invalid Email', 400);
    }

    public function check_forget_password_token(Request $request)
    {
        $rest = Restaurant::where('reset_password_token', $request->token)->first();
        if ($rest) {
            return api_success1('Valid Token!');
        }
        return api_error('Invalid Token!');
    }

    public function update_password(Request $request)
    {
        $rest = Restaurant::where('reset_password_token', $request->token)->first();
        if ($rest) {
            $rest->password = Hash::make($request->password);
            if ($rest->save()) return api_success1('Password Updated Successfully');
        }
        return api_error('Invalid Token!');
    }

    public function get_rests_by_name(Request $request)
    {
        $all_rests = Restaurant::where('title', 'LIKE', '%' . $request->search . '%')->whereRaw('`flags` & ?=?', [Restaurant::FLAG_ACTIVE, Restaurant::FLAG_ACTIVE])->get();
        if (sizeof($all_rests) > 0) {
            return api_success('Restaurants Data', ['restaurants' => $all_rests]);
        }
        return api_error('No Restaurant Found!');
    }

    public function logout(Request $request)
    {
        $rest = Restaurant::where('rest_id', request()->rest->rest_id)->first();
        $rest->device_token = NULL;
        $rest->save();
        if ($request->login_attempt) {
            $request->login_attempt->access_expiry = date("Y-m-d H:i:s");
            $request->login_attempt->save();
            return api_success1('Logout Successfull');
        }
        return api_error_app();
    }
}
