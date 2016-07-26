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
    private $jwtauth;

    public function __construct(JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
    }
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
        $user = $this->jwtauth->toUser();
        return new Response($user, 200);

        //return new Response('Couldn\'t fetch the data', 500);
    }
}
