<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('homes.index');
    }

    public function myWorld()
    {
        return view('homes.myWorld');
    }
}
