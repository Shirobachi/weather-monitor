<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\user;

class authController extends Controller
{
    function tryLogin(request $r){
        $user = user::where('login', $r->login) -> first();

        if($user && Hash::check($r->password, $user->password)){
            session()->put('userID', $user->id);
            return redirect(url('dashboard'));
        }
        else{
            $info['desc'] = __('auth.failed');
            $info['type'] = 'danger';
            return view('auth/login', compact('info'));
        }
    }

    function create(request $r){
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

        $info['title'] = __('auth.registerSuccess');

        return(view('auth/login', compact('info')));
    }
}
