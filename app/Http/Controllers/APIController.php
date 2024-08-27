<?php
/*
 * @Author: arvinlp 
 * @Date: 2020-06-02 16:25:06 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-02-23 15:49:03
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class APIController extends BaseController{

    protected function respondWithToken($token,$user = null, $workTimeStatus = true){
        if(!$workTimeStatus){
            return response()->json([
                'info' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => env('JWT_TTL'), 
                'status' => 250,
                'expire_time' => Carbon::now()->add(env('JWT_TTL'), 'minute')
            ], 200);
        }
        if($user){
            return response()->json([
                'info' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => env('JWT_TTL'),
                'status' => 200,
                'expire_time' => Carbon::now()->add(env('JWT_TTL'), 'minute')
            ], 200);
        }
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL'),
            'status' => 200,
            'expire_time' => Carbon::now()->add(env('JWT_TTL'), 'minute')
        ], 200);
    }

}
