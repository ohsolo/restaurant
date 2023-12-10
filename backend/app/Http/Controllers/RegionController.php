<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Region;

use App\Http\Requests\StoreRegion as StoreRegionRequest;

class RegionController extends Controller
{
    public function get_all_regions ()
    {        
        $regions = Region::query();
        $regions->with('country_detail');
        return api_success('All Regions', $regions->get());
    }

    public function get_all_regions_app ()
    {        
        $regions = Region::query();
        $regions->whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE]);
        $regions->with('country_detail');
        return response()->json(['regions' => $regions->get()], 200);
    }

    
    public function get_active_regions ()
    {        
        $regions = Region::query();
        $regions->whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE]);
        $regions->with('country_detail');
        return api_success('All Active Regions', $regions->get());
    }

    public function store(StoreRegionRequest $request)
    {
        $region = new Region;
        $region->region_id = (String) Str::uuid();
        $region->country_id = $request->country_id;
        $region->title = ucfirst($request->title);
        $region->addFlag(Region::FLAG_ACTIVE);

        if($region->save()) return api_success1('Region Added!');

        return api_error();
    }

    public function update(Request $request, $id)
    {
        $region = Region::where('region_id', $id)->first();
        $region->country_id = $request->input('country_id', $region->country_id);
        $region->title = $request->input('title', ucfirst($region->title));
        $region->removeFlag(Region::FLAG_ACTIVE);

        if ($request->has('status') && $request->filled('status') && $request->status == 'active') $region->addFlag(Region::FLAG_ACTIVE);

        if($region->save()) return api_success1('Region Updated!');

        return api_error();
    }

    public function get_regions_by_name (Request $request)
    {
        if ($request->has('country_id') && $request->filled('country_id')) {
            $all_regions = Region::where('country_id',  $request->country_id)->where('title', 'LIKE', '%'.$request->search.'%')->whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE])->with('country_detail')->get();

        } else {
            $all_regions = Region::where('title', 'LIKE', '%'.$request->search.'%')->whereRaw('`flags` & ?=?', [Region::FLAG_ACTIVE, Region::FLAG_ACTIVE])->with('country_detail')->get();

        }
        if (sizeof($all_regions) > 0) {
            return api_success('Regions Data', ['regions' => $all_regions]);

        }
        return api_error('No Region Found!');
    }
}
