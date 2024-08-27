<?php
namespace App\Http\Controllers\API\V1\TV;

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
use App\Models\User\Code as UserCode;
use App\Models\User\Meta as UserMeta;
use App\Models\User;

class SerieController extends BaseController{

    public function __construct(){
    }

    public function index(Request $request){
        if(!$request->has('order_by')) $request->merge(['order_by_asc' => 'order']);
        $series = SearchFilter::apply( $request, Series::with(['lastEpisodes'])->where('is_homepage',true)->where('is_published',true) );
        $series->map(function($serie) {
            $serie->setRelation('last_episodes', $serie->lastEpisodes->take(10));
            return $serie;
        });
        if(!$series->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($series);
    }
    public function getAllSeries(Request $request){
        if(!$request->has('order_by')) $request->merge(['order_by_desc' => 'id']);
        $series = SearchFilter::apply( $request, Series::where('is_published',true) );
        if(!$series->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($series);
    }
    public function getAllSeriesWithEpisodes(Request $request){
        if(!$request->has('order_by')) $request->merge(['order_by_asc' => 'order']);
        $series = SearchFilter::apply( $request, Series::with(['lastEpisodes'])->where('is_published',true) );
        $series->map(function($serie) {
            $serie->setRelation('last_episodes', $serie->lastEpisodes->take(10));
            return $serie;
        });
        if(!$series->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($series);
    }

    public function getLastSeries(Request $request){
        $lastEpisodes = Episode::with(['tvShow'])->where('is_published',true)->limit(10)->orderBy('created_at', 'desc')->get();
        if(!$lastEpisodes->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($lastEpisodes);
    }

    public function getSpecialSeries(Request $request){
        $lastEpisodes = Episode::with(['tvShow'])->where('is_special',true)->where('is_published',true)->limit(10)->orderBy('id', 'desc')->get();
        if(!$lastEpisodes->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($lastEpisodes);
    }

    public function getSerie(Request $request, $show = 0){
        if($show == 0)
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        if(!$series = Series::with(['persons'])->where('id',$show)->where('is_published',true)->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($series);
    }

    public function getSerieEpisodes(Request $request, $show = 0){
        if($show == 0)
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        $episodes = SearchFilter::apply( $request, Episode::where('serie_id',$show)->where('is_published',true)->orderBy('id', 'desc') );
        if(!$episodes->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($episodes);
    }

    public function getEpisode(Request $request, $show = 0, $id = 0){
        if($show == 0)
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        if(!$episode = Episode::where('id',$id)->where('is_published',true)->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($episode);
    }
}