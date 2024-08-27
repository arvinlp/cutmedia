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

class PageController extends BaseController{

    public function __construct(){
    }

    public function index(Request $request){
        if(!$request->has('order_by')) $request->merge(['order_by_desc' => 'id']);
        $series = SearchFilter::apply( $request, new Page );
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }

    public function get(Request $request, $slug = ''){
        $data = Page::where('slug',$slug)->where('is_published',true);
        $data = $data->first();
        if(!$data){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }
}