<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\AdminLogin as AdminLoginRequest;
use App\Http\Requests\StoreAdmin as StoreAdminRequest;

use App\Models\Admin;
use App\Models\LoginAttempt;
use App\Models\Country;
use App\Models\Rider;
use App\Models\Restaurant;

class AdminController extends Controller
{
    public function index (Request $request)
    {
        $all_admins = Admin::where('admin_id', '!=',  request()->admin->admin_id)->get();
        return api_success('Admin Records', $all_admins);
    }

    public function login (AdminLoginRequest $request)
    {
        $admin = Admin::where("email", $request->email)->first();
		if ($admin && HASH::check($request->password, $admin->password)) {
            request()->admin = $admin;
            $login_attempt = new LoginAttempt();
            $login_attempt->user_id = $admin->admin_id;
            $login_attempt->access_token = generate_token($admin);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) return api_error();

            $data = array(
                'message' => 'Login Successfully',
                'detail' => $admin,
                'token_detail' => array (
                    'access_token' => $login_attempt->access_token,
                    'token_type' => 'Bearer'
                )
            );
            return api_success('Admin LoggedIn Successfully', $data);
        }

        return api_error('Invalid Email or Password', 400);
    }

    public function save_push_notif_token(Request $request)
    {
        if (request()->admin) {
            Admin::where('admin_id', request()->admin->admin_id)->update(['device_token' => $request->token]);

        } else if (request()->rider) {
            Rider::where('rider_id', request()->rider->rider_id)->update(['device_token' => $request->token]);

        } else if (request()->rest) {
            Restaurant::where('rest_id', request()->rest->rest_id)->update(['device_token' => $request->token]);

        }
        return api_success_app('Device Token Updated');

    }

    public function check_push_notif_token()
    {
        $found = false;
        if (request()->admin) {
            $found = Admin::where('admin_id', request()->admin->admin_id)->where('device_token', '!=', '')->first();

        } else if (request()->rider) {
            $found = Rider::where('rider_id', request()->rider->rider_id)->where('device_token', '!=', '')->first();

        } else if (request()->rest) {
            $found = Restaurant::where('rest_id', request()->rest->rest_id)->where('device_token', '!=', '')->first();

        }
        if ($found) return api_success_app('Found Token');

        return api_error_app('Token not found!');
    }

    public function store (StoreAdminRequest $request)
    {
        $admin = new Admin;
        $admin->admin_id = (String) Str::uuid();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        if ($admin->save()) return api_success1('Admin Added!');

        return api_error();
    }

    public function update (Request $request)
    {
        $admin = Admin::where('admin_id', $request->admin_id)->first();
        $admin->name = $request->input("name", $admin->name);
        if ($request->has('password') && $request->filled('password')) {
            $admin->password = Hash::make($request->password);

        }
        if ($admin->save()) return api_success1('Admin Record Updated!');

        return api_error();
    }

    public function delete (Request $request)
    {
        Admin::where('admin_id', $request->admin_id)->delete();
        return api_success1('Admin Deleted Successfully!');
    }

    public function get_cities_against_country (Request $request)
    {
        $all_cities = get_cities($request->country_code, $request->address_key);
        return api_success('Cities Data', ['cities' => $all_cities]);
    }

    public function get_locations_against_cities(Request $request)
    {
        $all_locations = get_addresses($request->country_code, $request->address_key,  $request->place_id);
        return api_success('Locations Data', ['locations' => $all_locations]);
    }

    public function get_countries (Request $request)
    {
        $all_countries = Country::where('nicename', 'LIKE', '%'.$request->search.'%')->orderBy('name', 'asc')->get();
        if (sizeof($all_countries) > 0) {
            return api_success('List of countries', ['countries' => $all_countries]);

        }
        return api_error('No country found!', 404);
    }

    public function logout(Request $request)
    {
        $admin = Admin::where('admin_id', request()->admin->admin_id)->first();
        $admin->device_token = NULL;
        $admin->save();
        if ($request->login_attempt) {
            $request->login_attempt->access_expiry = date("Y-m-d H:i:s");
            $request->login_attempt->save();
            return api_success1('Logout Successfull');
        }
        return api_error_app();
    }
}
