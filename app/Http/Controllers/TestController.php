<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test1(){
        return view('test.test1');
    }

    public function test2(){
        return view('test.test2');
    }
    //
}

