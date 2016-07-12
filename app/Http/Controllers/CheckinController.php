<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function __construct() {}

    public function overview() { return view('db.checkin.overview'); }

}
