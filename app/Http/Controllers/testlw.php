<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testlw extends Controller
{
    public function index()
    {
        return view('testlw')->with('url','home');
    }
}
