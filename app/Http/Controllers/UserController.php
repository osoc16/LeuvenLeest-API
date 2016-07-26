<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \Auth;
use \DB;
use Illuminate\Http\Response;
use \JWTAuth;

class UserController extends Controller
{
    // get user by id
    public function getUserById($id)
    {
        $userData = DB::table('users')
            ->where('id', $id)
            ->get();
        if ($userData)
        {
            return new Response(json_encode($userData), 200);
        }
        return new Response('We didn\'t found an user with this id', 404);
    }

    public function getAccountDetails()
    {

        try {

        if (! $user = JWTAuth::parseToken()->authenticate()) {
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
        // $user = JWTAuth::parseToken()->authenticate();

        // if ($user)
        // {
        //     return new Response($user, 200);
        // }
        // return new Response('Couldn\'t fetch the data', 500);
    }
}
