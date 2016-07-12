<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct() {}

    public function searching() { return view('search.searching'); }

    public function search() { return view('search.search'); }

}
