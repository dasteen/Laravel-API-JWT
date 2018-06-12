<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\Facades\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return Response::sendError(['error' => trans('auth.failed')], 401);
            }

            /*
             * Check to see if the users account is confirmed and active
             */
            $user = auth()->user();

            $token = JWTAuth::fromUser($user, [
                'rol' => $user->roles->implode('id', ','),
                'name' => $user->name
            ]);


        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Response::sendError(['error' => trans('auth.failed')], 500);
        }

        // all good so return the token
        return Response::sendJSON(compact('token'));
    }

//    public function index()
//    {
//
//        $token = JWTAuth::getPayload();
//        $token = json_decode($token, true);
//
//        return Response::sendJSON(compact('token'));
//    }
}
