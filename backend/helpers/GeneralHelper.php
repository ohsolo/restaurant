<?php
if (!function_exists('api_success')) {
	function api_success($message, $data, $response = 200) {
		$data = response()->json(['status' => true, 'response' => array('message' => $message, 'detail' => $data)], $response);
		return $data;
	}
}
if (!function_exists('api_success_app')) {
	function api_success_app($data) {
		$data = response()->json($data);
		return $data;
	}
}
if (!function_exists('api_success1')) {
	function api_success1($message) {
		$data = response()->json(['status' => true, 'response' => array('message' => $message)]);
		return $data;
	}
}

if (!function_exists('api_error')) {
	function api_error($message = 'There is some error!', $error_code = 400) {
		$data = response()->json(['status' => false, 'error' => array('message' => $message)], $error_code);
		return $data;
	}
}
if (!function_exists('api_error_app')) {
	function api_error_app($message = 'There is some error!') {
		$data = response()->json($message, 403);
		return $data;
	}
}

if (!function_exists('api_validation_error')) {
	function api_validation_error($message, $data) {
		$data = response()->json(['status' => false, 'error' => array('message' => $message, 'detail' => $data)]);
		return $data;
	}
}

if (!function_exists('getTokenWeb')) {
    function getTokenWeb() {
        $token  = Session::get('usertoken');
        if($token){
            return $token;
        }
        return false;
    }
}

if (!function_exists('addFile')) {
	function addFile($file, $path, $width = '1200', $height = '1200', $resize = false) {

		$destinationPath = $path;

		$file = $file;
		$name = rand(99, 9999999) . '.' . $file->extension();

		$background = \Image::canvas($width, $height);

		// if ($resize) {
		// 	$img = \Image::make($file)->resize($width, $height, function ($c) {
		// 		$c->aspectRatio();
		// 		$c->upsize();

		// 	});

		// } else {
			$img = \Image::make($file)->fit($width, $height);
		// }
		$background->insert($img, 'center');
		$background->save($destinationPath . '/' . $name);
		return $name;
	}
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

if (!function_exists('getToken')) {
	function getToken($request) {
		if (preg_match('/Bearer\s(\S+)/', $request->header('Authorization'), $matches)) {
			return $matches[1];
		}
		return false;
	}
}

if (!function_exists('generate_token')) {
	function generate_token($customer) {
		$token_params = [
			time(),
			$customer->email,
			"access_token",
		];
		return base64_encode(md5(\implode("_", $token_params)));
	}
}


if (!function_exists('get_addresses')) {
	function get_addresses($country_code, $address_key, $place_id) {
		$url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?key=AIzaSyA89-etKIfiHgLKrSEuwCBTGKimI6a-_aQ&components=country:' . $country_code . '&place_id='.$place_id.'&input=' . $address_key;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = array();

		if ($httpcode == 200) {
			$result = json_decode($result);
			foreach ($result->predictions as $key => $value) {
				$data[$key]['place_id'] = $value->place_id;
				$data[$key]['name'] = $value->description;

			}
			return $data;
		}
		return $data;
	}
}

if (!function_exists('get_single_country')) {
	function get_single_country (Request $request) {
		$country = Country::where('id', $request->code)->first();
		return api_success('Country Data!', $country);
	}
}

if (!function_exists('get_cities')) {
	function get_cities($country_code, $address_key) {
		$url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?key=AIzaSyA89-etKIfiHgLKrSEuwCBTGKimI6a-_aQ&types=(cities)&components=country:' . $country_code . '&input=' . $address_key;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = array();

		if ($httpcode == 200) {
			$result = json_decode($result);
			foreach ($result->predictions as $key => $value) {
				$data[$key]['place_id'] = $value->place_id;
				$data[$key]['name'] = $value->description;

			}
			return $data;
		}
		return $data;
	}
}

if (!function_exists('get_place')) {
	function get_place($place_id) {
		$url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $place_id . '&fields=geometry&key=AIzaSyA89-etKIfiHgLKrSEuwCBTGKimI6a-_aQ';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$response = array();
		$response['http_code'] = $httpcode;
		$response['response'] = $result;
		return $response;
	}
}

if (!function_exists('notification_core')) {
	function notification_core ($data) {
		
		$SERVER_API_KEY = 'AAAAvUBtFk4:APA91bFopvYZEIDv26pwDiIHGrRrQB9Uu3fSvR2D3PXQLXZ09mSZ_qk01m_f75I9b2OYS9R1lfkryNpAGoSBLQkIZ2nmMMYIv2HLruuxwWlKQ1omlCBoUdBlVQhsYSGVhpfJW5cWBMP6';

		$dataString = json_encode($data);

		$headers = [
			'Authorization: key=' . $SERVER_API_KEY,
			'Content-Type: application/json'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
		$response = curl_exec($ch);
		curl_close($ch);
		return response()->json(['response' => $response]);
	}
}

if (!function_exists('distance_between_two_locations')) {
	function distance_between_two_locations($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}
	// $result = haversineGreatCircleDistance(24.8670371, 67.0809526, 24.8581498, 67.0585459);
	// echo number_format($result, 2);
}