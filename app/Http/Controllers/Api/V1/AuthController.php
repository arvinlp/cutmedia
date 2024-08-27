<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\API\V1\Core\SMSController;
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

class AuthController extends BaseController{

    private $sms;

    public function __construct(){
        $this->sms = new SMSController;
    }
    
    public function auth(Request $request){
        $this->validate($request, [
            'mobile'    => 'required',
            'code'      => 'required',
        ]);
        
        try{
            $userInfo    = User::where('mobile',(float)$request->input('mobile'))->first();
            
            if(UserCode::where('user_id',$userInfo->id)->where('code',$request->input('code'))->where('send', '>', Carbon::now())->first()){
                if (! $token = Auth::login($userInfo)) {
                    return response()->json([
                        'message'   => 'شما دسترسی مجاز به سیستم را ندارید .',
                        'code'      => (int) 401,
                    ], 401);
                }
                $a = 3600 * 60 * 30 * 24;
                Auth::setTTL($a);
                
                return $this->respondWithToken($token,$userInfo);
            }else{
                return response()->json([
                    'message'   => 'کد ورود وارد شده معتبر نمی باشد، مجددا سعی نمایید.',
                    'code'      => (int) 405,
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500,
            ], 500);
        }
    }
    public function login(Request $request){
        $this->validate($request, [
            'mobile'    => 'required',
        ]);

        try{
            if($user = User::where('mobile',(float)$request->input('mobile'))->first()){
                $code = self::getCode($user->id);
                return self::sendVerifyCode((float) $user->mobile, $code);
            }else{
                
                $user           = new User;
                $user->mobile   = (float)$request->input('mobile');
                $user->save();
                
                $user           = User::find($user->id);
                $user->first_name = "کاربر";
                $user->last_name = (string) $user->id;
                $user->nickname = "کاربر ".$user->id;
                $user->wallet = 0;
                $user->save();

                $code = self::getCode($user->id);
                return self::sendVerifyCode((float) $user->mobile, $code);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500,
            ], 500);
        }
    }

    public function loginAdmin(Request $request){
        $this->validate($request, [
            'mobile'    => 'required',
            'password'  => 'required',
        ]);
        
        try{
            $userInfo = Admin::where('mobile',(float)$request->input('mobile'))->first();
            $password = (float) $request->input('mobile');//$request->input('password');
            // $userInfo->password = Hash::make($password);
            // $userInfo->save();
            if ($token = Auth::guard('portal')->attempt(['mobile' => (float)$request->input('mobile'), 'password' => $password])) {
                return $this->respondWithToken($token,$userInfo);
            }else{
                return response()->json([
                    'message'   => 'شما دسترسی مجاز به سیستم را ندارید .',
                    'code'      => (int) 401,
                ], 401);
            }
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500,
            ], 500);
        }
    }
    public function resetPassword(Request $request){
        $this->validate($request, [
            'mobile'    => 'required',
        ]);

        try{
            if($user = User::where('mobile',(float)$request->input('mobile'))->where('status',1)->first()){
                $code = self::getCode($user->id);
                return self::sendVerifyCode((float) $user->mobile, $code);
            }else{
                return response()->json([
                    'message'   => 'شما دسترسی مجاز به سیستم را ندارید .',
                    'code'      => (int) 401,
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500,
            ], 500);
        }
    }
    public function resetPasswordVerfy(Request $request){
        $this->validate($request, [
            'mobile'    => 'required',
            'code'      => 'required'
        ]);

        try{
            $userInfo   = Admin::where('mobile',(float)$request->input('mobile'))->first();
            
            if($user = UserCode::where('user_id',$userInfo->id)->where('code',$request->input('code'))->where('send', '>', Carbon::now())->first()){
                $password = rand(10000,99999);
                $userInfo->password = Hash::make($password);
                $userInfo->save();
                return self::newPassword((float)$request->input('mobile'), $password);
            }else{
                return response()->json([
                    'message'   => 'شما دسترسی مجاز به سیستم را ندارید .',
                    'code'      => (int) 401,
                ], 401);
            }
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500,
            ], 500);
        }
    }

    public function register(Request $request){
        $this->validate($request, [
            'mobile'        => 'required',
        ]);
        
        try{
            if(!$user = User::where('mobile',$request->input('mobile'))->first()){

                $user           = new User;
                $user->mobile   = (float)$request->input('mobile');
                $user->save();

                $code = self::getCode($user->id);
                return self::sendVerifyCode((float) $user->mobile, $code);
            }else{
                return response()->json([
                    'message'   => 'شما قبلا در سیستم ثبت نام کرده اید.',
                    'code'      => (int) 403,
                ], 403);
            }
        } catch (\Exception $e) {
            //return error message
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500
            ], 500);
        }
    }

    private function getCode($userID){
        $code = rand(11110,99999);
        if(!$userCode = UserCode::where('user_id',$userID)->first()){
            $userCode = new UserCode;
            $userCode->user_id  = $userID;
            $userCode->send     = Carbon::now()->add('30','minute');
            $userCode->code     = $code;
        }else{
            if($userCode->send <= Carbon::now()){
                $userCode->code = $code;
                $userCode->send = Carbon::now()->add('30','minute');
            }else{
                $code = $userCode->code;
            }
        }
        $userCode->save();

        return $code;
    }

    private function sendVerifyCode($mobile, $code){
        if($a = $this->sms->verifyCode($mobile, $code)){
            return response()->json([
                'message'   => 'کد ورود شما ارسال شد.',
                'code'      => (int) 200,
                $a
            ], 200);
        }else{
            return response()->json([
                'message'   => 'خطا در ارسال کد ورود هویت',
                'code'      => (int) 409,
            ], 409);
        }
    }

    private function newPassword($mobile, $code){
        if($a = $this->sms->newPassword($mobile, $code)){
            return response()->json([
                'message'   => 'کد ورود شما ارسال شد.',
                'code'      => (int) 200,
                $a
            ], 200);
        }else{
            return response()->json([
                'message'   => 'خطا در ارسال کد ورود هویت',
                'code'      => (int) 409,
            ], 409);
        }
    }
}