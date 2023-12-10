<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\Address;

use App\Http\Requests\StoreAddress as StoreAddressRequest;


class AddressController extends Controller
{
    public function index(Request $request)
    {
        $address = Address::query();
        if ($request->has('country_id') && $request->has('country_id')) $address->where('country_id', $request->country_id);

        if ($request->has('region_id') && $request->has('region_id')) $address->where('region_id', $request->region_id);

        if ($request->has('search') && $request->has('search')) $address->where('location', 'LIKE', '%'.$request->search.'%');

        $address->with(['country_detail', 'region', 'city']);
        $address->orderBy('created_at', 'DESC');
        return api_success('Addresses Data', ['addresses' => $address->paginate(20)]);
    }

    public function get_addresses_by_name (Request $request)
    {
        $addresses = Address::where('location', 'LIKE', '%'.$request->search.'%')->get();
        if (sizeof($addresses) > 0) {
            return api_success('Addresses Data', ['addresses' => $addresses]);

        }
        return api_error('No Address Found!', 404);
    }

    public function store(StoreAddressRequest $request)
    {
        $found_city = City::where('city_id', $request->city_id)->first();

		if (!$found_city) {
			$city_result = get_place($request->city_id);

			if ($city_result['http_code'] == 200) {
				$result = json_decode($city_result['response']);
				$city_latitude = $result->result->geometry->location->lat;
				$city_longitude = $result->result->geometry->location->lng;

			} else {
				return api_error('Error!');

			}

			$city = new City;
			$city->country_id = $request->country_id;
			$city->region_id = $request->region_id;
			$city->city_id = $request->city_id;
			$city->lat = $city_latitude;
			$city->long = $city_longitude;
			$city->city_name = $request->city_name;

			if (!$city->save()) {
				return api_error('Error');

			}
		}

        $neighbourhood_place = get_place($request->neighbourhood_id);
        if ($neighbourhood_place['http_code'] == 200) {
            $result = json_decode($neighbourhood_place['response']);
            $location_latitude = $result->result->geometry->location->lat;
            $location_longitude = $result->result->geometry->location->lng;

        } else {
            return api_error('Error!');

        }

        $address = new Address;
        $address->address_id = (String) Str::uuid();
        $address->country_id = $request->country_id;
        $address->city_id = $request->city_id;
        $address->region_id = $request->region_id;
        $address->location = $request->location;
        $address->latitude = $location_latitude;
        $address->longitude = $location_longitude;
        if ($address->save()) return api_success('Address added!', ['address' => $address]);

        return api_error('There is some error!');
    }

    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
