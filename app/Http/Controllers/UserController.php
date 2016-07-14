<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \Auth;
use \DB;

class UserController extends Controller
{
    // get user by id
    public function getUserById($id)
    {
    	$userData = DB::table('users')
    		->where('id', $id)
    		->get();

    	return json_encode($userData);
    }
}