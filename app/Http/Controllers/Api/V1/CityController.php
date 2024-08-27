<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use App\SearchFilters\SearchFilter as SearchFilter;

use App\Models\Core\Province;
use App\Models\Core\County;
use App\Models\Core\City;
use Carbon\Carbon;

class CityController extends BaseController{

    public function __construct(){
    }

    public function provinces(Request $request){
        $province = Province::get();
        if(!$province->first()){
            return response()->json([
                'message'   =>'استان یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($province);
    }

    public function counties($province = 21){
        $county = County::where('province_id',$province)
                    ->get();

        if(!$county->first()){
            return response()->json([
                'message'   =>'شهر یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($county);
    }

    public function cities($province = null, $county = null){
        $city = City::where('province_id', $province)
                    ->where('county_id', $county)
                    ->get();

        if(!$city->first()){
            return response()->json([
                'message'   =>'شهرستان یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($city);
    }
    
    public function city($province = null, $county = null, $city = null){
        $city = City::where('province_id', $province)
                    ->where('county_id', $county)
                    ->where('id', $city)
                    ->first();

        if(!$city->first()){
            return response()->json([
                'message'   =>'شهرستان یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($city);
    }
}