<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class IndexController extends Controller
{
    public function home(){       
        return view('generic.home');
    }

    public function about(){
        return view('generic.about');
    }

}
