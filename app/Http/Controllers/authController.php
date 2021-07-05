<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\user;

class authController extends Controller
{
    function login(){
        return view('auth/login');
    }

    function tryLogin(request $r){
        $user = user::where('login', $r->login) -> first();

        if($user && Hash::check($r->password, $user->password)){
            session()->put('userID', $user->id);
            return redirect(url('weather'));
        }
        else{
            $info['type'] = 'danger';
            $info['title'] = 'Account not found!';
            $info['desc'] = 'Login or/and password is/are wrong!';
            return view('auth/login', compact('info'));
        }
    }
    
    function register(){
        return view('auth/register');
    }

    function signup(request $r){
        $r -> validate([
            'login' => "min:3|max:15|required|unique:users",
            'e-mail' => "email:rfc,dns|unique:users",
            'password'  => 'min:6|max:50',
            'password2' => 'same:password'
        ]);

        $temp = $r -> all();
        $temp['password'] = Hash::make($r->password);
        unset($temp['password2']);

        user::create($temp);

        $info['title'] = 'Register successful';
        $info['desc'] = 'You can log in now!';

        return(view('auth/login', compact('info')));
    }
}
