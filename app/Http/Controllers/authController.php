<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authController extends Controller
{
    function login(){
        return view('auth/login');
    }
    
    function register(){
        return view('auth/register');
    }
}
