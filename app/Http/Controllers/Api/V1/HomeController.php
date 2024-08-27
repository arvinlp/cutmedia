<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use App\SearchFilters\SearchFilter as SearchFilter;

use Carbon\Carbon;
use App\Models\Core\ADS;
use App\Models\Core\Page;
use App\Models\Core\Slide;
use App\Models\Core\Setting;
use App\Models\TV\Serie as Series;
use App\Models\TV\Episode;
use App\Models\TV\Person;
use App\Models\User\Code;
use App\Models\User\Meta;
use App\Models\User;

class HomeController extends BaseController{

    public function __construct(){
    }

    public function getSlider(Request $request){
        $data = Slide::limit(10)->where('is_published',true);
        $data = $data->orderBy('created_at', 'desc');
        $data = $data->get();
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }

    public function getAds(Request $request){
        $data = ADS::limit(10)->where('is_published',true);
        $data = $data->where('expire_date', '>=', Carbon::now());
        $data = $data->orderBy('created_at', 'desc');
        if($request->has('location'))$data = $data->where('location', $request->input('location'));
        $data = $data->get();
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }

    public function getSeries(Request $request){
        $data = Series::with(['lastEpisodes']);
        $data = $data->orderBy('order', 'asc');
        $data = $data->get();
        $data = $data->map(function($serie) {
            $serie->setRelation('last_episodes', $serie->lastEpisodes->take(10));
            return $serie;
        });
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }

}