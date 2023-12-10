<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Restaurant;
use App\Models\Branch;
use App\Models\City;

use App\Http\Requests\StoreBranch as StoreBranchRequest;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::query();
        $branches->where('rest_id', $request->rest_id);

        $branches->orderBy('id', 'DESC');
        $branches->with(['city.region', 'city.country_detail']);
        return api_success('Branches Data', $branches->paginate(10));
    }

    public function get_branches_by_name (Request $request)
    {
        $branches = Branch::where('rest_id', request()->rest->rest_id)->where('location', 'LIKE', '%'.$request->search.'%')->whereRaw('`flags` & ?=?', [Branch::FLAG_ACTIVE, Branch::FLAG_ACTIVE])->get();
        if (sizeof($branches) > 0) {
            return api_success('Branches Data', ['branches' => $branches]);

        }
        return api_error('No Branch Found!', 404);
    }

    public function store(StoreBranchRequest $request, $rest_id)
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
        $branch = new Branch;
        $branch->branch_id = (String) Str::uuid();
        $branch->rest_id = $rest_id;
        $branch->city_id = $request->city_id;
        $branch->location = $request->location;
        $branch->phone = $request->phone;
        $branch->value = $request->value;
        $branch->latitude = $location_latitude;
        $branch->longitude = $location_longitude;
        $branch->addFlag(Branch::FLAG_ACTIVE);

        if ($branch->save()) return api_success1('Branch Added Successfully!');

        return api_error();
    }

    public function update(Request $request, $branch_id)
    {
        $branch = Branch::where('branch_id', $branch_id)->first();
        if ($request->has('city_id') && $request->filled('city_id')) {
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
        }
        if ($request->has('neighbourhood_id') && $request->filled('neighbourhood_id')) {
            $neighbourhood_place = get_place($request->neighbourhood_id);
            if ($neighbourhood_place['http_code'] == 200) {
                $result = json_decode($neighbourhood_place['response']);
                $branch->latitude = $result->result->geometry->location->lat;
                $branch->longitude = $result->result->geometry->location->lng;

            } else {
                return api_error('Error!');
    
            }
        }
        $branch->city_id = $request->input('city_id', $branch->city_id);
        $branch->phone = $request->input('phone', $branch->phone);
        $branch->location = $request->input('location', $branch->location);
        $branch->value = $request->input('value', $branch->value);
        $branch->removeFlag(Branch::FLAG_ACTIVE);

        if ($request->status == 'active') $branch->addFlag(Branch::FLAG_ACTIVE);

        if ($branch->save()) return api_success1('Branch Updated Successfully!');

        return api_error();
    }
}
