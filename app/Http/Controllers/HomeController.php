<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $countries = collect(config('countries'));
        return view('index',compact('countries'));
    }
}
