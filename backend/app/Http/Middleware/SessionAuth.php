<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\Admin;
use App\Models\Rider;
use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SessionAuth extends Controller {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$sessionNotRequired = [
			'AdminLogin',
			'RiderLogin',
			'RiderRegister',
			'AllActiveRegions',
			'RestaurantLogin',
			'RestaurantEmailVerify',
			'CheckRestaurantForgetPasswordToken',
			'UpdateRestaurantPassword',
			'GetCities',
			'GetLocationAgainstCities',
			'GetCountries',
			'AllRegionsApp',
			'UpdateRiderPassword',
			'CheckRiderForgetPasswordToken',
			'RiderCheckEmailForForgetPassword'
		];

		if ($this->is_valid_token($request)) {
			$admin = Admin::where('admin_id', $request->login_attempt->user_id)->first();
			if ($admin) {
				$request->admin = $admin;
				return $next($request);
			} else {
				$rider = Rider::where('rider_id', $request->login_attempt->user_id)->first();
				if ($rider) {
					$request->login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));
					$request->login_attempt->update();
					$request->rider = $rider;
					return $next($request);
				} else {
					$rest = Restaurant::where('rest_id', $request->login_attempt->user_id)->first();
					if ($rest) {
						$request->rest = $rest;
						return $next($request);
					}
				}
			}

		} else if (in_array($request->route()->getName(), $sessionNotRequired)) {
			return $next($request);

		}
		return api_error('You are unauthorized!', 401);
	}

	public function is_valid_token(&$request) {
		$token = getToken($request);
		if (!$token) {
			return false;
		}

		$request->login_attempt = LoginAttempt::where("access_token", $token)->get()->first();
		$is_expired = "is_access_expired";

		return $request->login_attempt && !($request->login_attempt->toArray())[$is_expired];
	}
}
