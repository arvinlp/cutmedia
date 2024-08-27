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

class AdminController extends BaseController{

    //Current User is handler
    private $handler = null;
    private $user_id = null;
    public function __construct(){
        $this->handler      = Auth::guard('portal')->user();
        if($this->handler != null) $this->user_id   = $this->handler->id;

        if($this->user_id == 0){
            return response()->json([
                'message'   =>'Unauthorized',
                'code'      => (int) 401,
            ], 401);
        }
    }

    public function index(Request $request){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        if(!$request->has('order_by')) $request->merge(['order_by_desc' => 'last_name']);
        $users = SearchFilter::apply( $request, new Admin );
        if(!$users->first()){
            return response()->json([
                'message'   =>'پرسنلی یافت نشد.',
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
        
        $users = SearchFilter::apply( $request, new Admin, 'custom' );
        if($request->has('self'))$users = $users->where('id','!=',$this->user_id);
        $users = $users->get();
        if(!$users->first()){
            return response()->json([
                'message'   =>'پرسنلی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($users);
    }
    public function get(Request $request, $id){
        if(!$user = Admin::find($id)){
            return response()->json([
                'message'   =>'پرسنل یافت نشد.',
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
                'mobile'        => 'required|unique:users',
                'password'      => 'required',
            ],[
                'password.required'     => 'گذرواژه وارد نشده است',
                'mobile.unique'         => "شماره موبایل وارد شده تکراری می باشد",
                'mobile.required'       => 'شماره موبایل وارد نشده است',
            ]);
        }
        try{
            if(! $data = Admin::find($id) ){
                $data = new Admin;
            }
            $data->first_name   = $request->input('first_name');
            $data->last_name    = $request->input('last_name');
            $data->type         = "admin";
            $data->nickname     = $request->input('first_name') . " " . $request->input('last_name');
            if($request->has('status'))     $data->status   = $request->input('status');
            if($request->has('mobile'))     $data->mobile   = $request->input('mobile');
            if($request->has('password'))   $data->password = $request->input('password');
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

                if($oldImage = Image::where('file',$location)->where('user_id',$data->id)->first()){
                    Storage::delete($oldImage->file);
                    $oldImage->delete();
                }
                
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

        if($id == null)
            return response()->json([
                'message'   =>'پرسنلی جهت حدف مشخص نشده است',
                'code'      => (int) 409,
            ], 409);
        if($id == $this->handler->id)
            return response()->json([
                'message'   =>'امکان حذف حساب کاربری خودتان وجود ندارد.',
                'code'      => (int) 409,
            ], 409);
        try{
            if( $user = Admin::find($id) ){
                if(Admin::where('id', $id)->delete())
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

    public function getProfile(){
        if(!$user = Admin::find($this->user_id)){
            return response()->json([
                'message'   =>'اطلاعات شما یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($user);
    }
    
    public function updateProfile(Request $request){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        if($request->has('password')){
            $this->validate($request, [
                'password'      => 'required,confirmed',
            ],[
                'password.required'     => 'گذرواژه وارد نشده است',
                'password.confirmed'     => 'گذرواژه وارد نشده است',
            ]);
        }
        try{
            if(! $data = Admin::find($this->user_id) ){
                return response()->json([
                    'message'   =>'اطلاعات شما یافت نشد.',
                    'code'      => (int) 404,
                ], 404);
            }
            $data->first_name   = $request->input('first_name');
            $data->last_name    = $request->input('last_name');

            if(empty($request->input('nickname')))$data->nickname   = $request->input('nickname');
            else $data->nickname = $request->input('first_name') . " " . $request->input('last_name');

            if($request->has('mobile'))     $data->mobile   = (float)$request->input('mobile');
            if($request->has('password'))   $data->password = Hash::make($request->input('password'));
            if(empty($request->input('province'))){
                $data->province    = $request->input('province');
                if(empty($request->input('county')))$data->county        = $request->input('county');
                else $data->county = null;
            }
            if(empty($request->input('image'))){
                $location   = "/{$this->handler->id}/avatar";
                $fileContents = $request->input('image');
                $file   = Storage::disk('public')->put($location, $fileContents,'public');

                if($oldImage = Image::where('file',"LIKE","/{$this->handler->id}/avatar/%")->where('user_id',$this->handler->id)->first()){
                    Storage::delete($oldImage->file);
                    $oldImage->delete();
                }
                
                if(!$img = Image::where('file',$location)->first()){
                    $img = new Image;
                }
                $img->name = $request->input('name');
                $img->format = $fileContents->extension();
                $img->file = $location;
                if($this->handler)$img->user_id = $this->handler->id;
                $img->save();
            
                $data->avatar = env('PKSI_ASSEST_URL').$location;
            }
            $data->save();

            return response()->json([
                'message'   =>'اطلاعات بروز شد',
                'code'      => (int) 201
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500
            ], 500);
        }
    }
}