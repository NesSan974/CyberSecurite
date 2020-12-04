<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use App\Models\User;
use phpDocumentor\Reflection\Location;
use Tymon\JWTAuth\Exceptions\JWTException;

session_start();

class UserController extends Controller
{


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');


        $expireSessionTime = 65;
        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
          }else if (time() - $_SESSION['CREATED'] > $expireSessionTime){
            session_unset(); 
            session_destroy();
          }
          
          if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 1;
          }
          
        if ($_SESSION['count'] >= 3) {
            $i = $expireSessionTime - (time() - $_SESSION['CREATED'] );
            error_log("tentative de connection superieur a 3, avec l'ip : ".$_SERVER['REMOTE_ADDR']."\n", 3, '/home/quentin/CyberSecurite/loginjwt/storage/logs/tentativeLogin.log');
            return "too much attempt, revenez dans :".round ($i/60) . 'minute(s) ou '.$i.'s' ;
        }
        

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $_SESSION['count']++;
                return response()->json(['error' => 'invalid credential', 'token' => $token], 401);;
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $_SESSION['count'] = 0;
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
