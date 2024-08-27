<?php
namespace App\Http\Controllers\API\V1\Portal;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

class UserController extends BaseController{

    //Current User is handler
    private $handler    = null;
    private $user_id    = null;
    private $type       = null;
    public function __construct(){
        $this->handler      = Auth::guard('portal')->user();
        if($this->handler == null) $this->handler  = Auth::guard()->user();
        if($this->handler == null){
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 401,
            ], 401);
        }
        $this->type = $this->handler->type;
    }

    public function index(Request $request){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        if(!$request->has('per_page')) $request->merge(['per_page' => env('PORTAL_PAGINATION_NUMBER',20)]);
        if(!$request->has('order_by')) $request->merge(['order_by_desc' => 'nickname']);
        $users = SearchFilter::apply( $request, new User, 'custom' );
        $users = $users->paginate($request->input('per_page'));
        if(!$users->first()){
            return response()->json([
                'message'   =>'کاربر یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($users);
    }
    
    public function list(Request $request){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        $users = SearchFilter::apply( $request, new User, 'all' );
        if(!$users->first()){
            return response()->json([
                'message'   =>'کاربر یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($users);
    }
    public function get(Request $request, $id){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        if(!$user = User::find($id)){
            return response()->json([
                'message'   =>'کاربر یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($user);
    }

    public function addOrUpdate(Request $request, $id = null){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);

        $this->validate($request, [
            'first_name'    => 'required',
            'last_name'     => 'required',
        ],[
            'first_name.required'   => 'نام وارد نشده است',
            'last_name.required'    => 'نام خانوادگی وارد نشده است',
        ]);
        if($id == null){
            $this->validate($request, [
                'mobile'        => 'required|unique:users|integer',
            ],[
                'mobile.unique'         => "شماره موبایل وارد شده تکراری می باشد",
                'mobile.integer'        => 'شماره موبایل وارد شده صحیح نمی باشد صفر ابتدا را حذف کنید',
                'mobile.required'       => 'شماره موبایل وارد نشده است',
            ]);
        }
        try{
            if(! $data = User::find($id) ){
                $data = new User;
            }
            $data->first_name   = $request->input('first_name');
            $data->last_name    = $request->input('last_name');
            $data->type         = "user";
            $data->nickname     = $request->input('first_name') . " " . $request->input('last_name');
            if($request->has('status'))     $data->status   = $request->input('status');
            if($request->has('mobile'))     $data->mobile   = $request->input('mobile');
            if($request->has('province')){
                $data->province    = $request->input('province');
                if($request->has('county'))$data->county        = $request->input('county');
                else $data->county = null;
            }

            $data->save();
            if($request->input('image') != null){
                $location   = "/avatar";
                $base64_image = $request->input('image');

                $fileContents = base64_decode($base64_image);
                $fileExtention = $request->input('extention');
                $location .= "/{$data->id}.".$fileExtention;
                $file   = Storage::disk('public')->put($location, $fileContents,'public');
                
                if(!$img = Image::where('file',$location)->first()){
                    $img = new Image;
                }
                $img->name = $data->id;
                $img->format = $fileExtention;
                $img->file = $location;
                if($this->handler)$img->user_id = $data->id;
                $img->save();
            
                $data->avatar = env('PKSI_ASSEST_URL').$location;
                $data->save();
            }

            if($id != null)
                return response()->json([
                    'message'   =>'اطلاعات بروز شد',
                    'code'      => (int) 201
                ], 201);
            else
                return response()->json([
                    'message'   =>'افزوده شد',
                    'code'      => (int) 201
                ], 201);

        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500
            ], 500);
        }
    }

    public function delete($id = null){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);

        try{
            if( $user = User::find($id) ){
                if(User::where('id', $id)->delete())
                    return response()->json([
                        'message'   =>'کاربر حذف شد',
                        'code'      => (int) 201
                    ], 201);
                else
                    return response()->json([
                        'message'   =>'خطا در حذف رخ داد',
                        'code'      => (int) 409
                    ], 409);
            }
            return response()->json([
                'message'   =>'خطا در حذف رخ داد',
                'code'      => (int) 409
            ], 409);

        } catch (\Exception $e) {
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500
            ], 500);
        }
    }
}