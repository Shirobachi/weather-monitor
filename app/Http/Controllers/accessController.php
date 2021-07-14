<?php

namespace App\Http\Controllers;

use App\Models\usersCities;

class accessController extends Controller
{
	function dashboard(){
		if(! session()->has('userID'))
			return redirect(url('/'));

		if(usersCities::where('user', session()->get('userID'))->get()->count() == 0){
			$info = array(
				'title' => __('notifications.noFollowedTownTitle'),
				'desc' => __('notifications.noFollowedTownDesc'),
				'type' => 'warning'
			);
			return view('dashboard', compact('info'));
		}

		return view('dashboard');
	}

	function showMore($id){
		if(! session()->has('userID'))
			return redirect(url('/'));
		else if(usersCities::where('user', session()->get('userID')) -> where('city', $id) -> count() == 0){
			$info = array(
				'title' => __('notifications.noFollowingTitle'),
				'desc' => __('notifications.noFollowingDesc'),
				'type' => 'info'
			);
			return view('dashboard', compact('info'));
		}
		else
			return view('showMore', compact('id'));
	}

	function login(){
		if(session()->has('userID'))
				return redirect(url('dashboard'));
		else
				return view('auth/login');
	}
    
	function register(){
			if(session()->has('userID'))
					return redirect(url('dashboard'));
			else
					return view('auth/register');
	}
}
