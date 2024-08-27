<?php
namespace App\Http\Controllers\API\V1\Portal;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SearchFilters\SearchFilter as SearchFilter;
use App\Http\Controllers\API\V1\Core\DatamisController as Datamis;

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

class HomeController extends BaseController{

    private $handler    = null;
    private $user_id    = null;
    private $type       = null;
    public function __construct(){
        $this->handler      = Auth::guard('portal')->user();
        if($this->handler == null) $this->handler  = Auth::guard()->user();
        if($this->handler == null){
            return response()->json([
                'message'   =>'Unauthorized',
                'code'      => (int) 401,
            ], 401);
        }
        $this->type = $this->handler->type;
    }

    public function index(Request $request){
        return $this->handler;
        $owghat = Datamis::owghat( 8 , 10 , 51.43 , 35.67 , 0 , 1 , 1 );
        return response()->json([
            'message'   =>'خانه',
            "owghat" => $owghat
        ], 404);
    }
    
}