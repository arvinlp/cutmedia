<?php
namespace App\Http\Controllers\API\V1\Portal;

use App\Http\Controllers\APIController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\SearchFilters\SearchFilter as SearchFilter;

use App\Model\Advertise\ProductType;
use Carbon\Carbon;

class ProductTypeController extends BaseController{

    //Current User is handler
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
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        if(!$request->has('per_page')) $request->merge(['per_page' => env('PORTAL_PAGINATION_NUMBER',20)]);
        if(!$request->has('order_by')) $request->merge(['order_by_desc' => 'name']);
        $data = SearchFilter::apply( $request, new ProductType );
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }
    
    public function list(Request $request){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        $data = SearchFilter::apply( $request, new ProductType, 'all' );
        if(!$data->first()){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }
    public function get(Request $request, $id){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);
        
        if(!$data = ProductType::find($id)){
            return response()->json([
                'message'   =>'موردی یافت نشد.',
                'code'      => (int) 404,
            ], 404);
        }
        return response()->json($data);
    }
    public function addOrUpdate(Request $request, $id = null){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);

        $this->validate($request, [
            'name'    => 'required',
        ],[
            'name.required'   => 'نام وارد نشده است',
        ]);
        try{
            if(! $data = ProductType::find($id) ){
                $data = new ProductType;
            }
            $data->name             = $request->input('name');
            $data->save();

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
            return response()->json([
                'message'   =>'خطا سرور رخ داد، مجدد سعی کنید.',
                'code'      => (int) 500
            ], 500);
        }
    }
    public function delete($id){
        if($this->handler == null)
            return response()->json([
                'message'   =>'شما دسترسی مجاز به سیستم را ندارید.',
                'code'      => (int) 403,
            ], 403);

        try{
            if(ProductType::where('id', $id)->delete())
                return response()->json([
                    'message'   =>'آیتم مد نظر حذف شد',
                    'code'      => (int) 201
                ], 201);
            else
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