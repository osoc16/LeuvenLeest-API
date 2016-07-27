<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \Auth;
use \DB;
use Illuminate\Http\Response;
use \JWTAuth;
use App\Http\Controllers\Auth\AuthController;

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
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),json_encode($userData), 200);
        }
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We didn\'t found an user with this id', 404);
    }

    public function getAccountDetails()
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user)
        {
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$user, 200);
        }
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'Couldn\'t fetch the data', 500);
    }
}
