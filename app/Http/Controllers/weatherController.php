<?php

namespace App\Http\Controllers;

use App\Models\usersCities;
use App\Models\town;
use App\Models\weatherInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class weatherController extends Controller
{
	function dashboard(){
		if(! session()->has('userID'))
			return redirect(url('/'));

		if(usersCities::where('user', session()->get('userID'))->get()->count() == 0){
			$info = array(
				'title' => 'No following towns yet',
				'desc' => "Follow some towns before you see dashboard!",
				'type' => 'warning'
			);
			return view('dashboard', compact('info'));
		}

		return view('dashboard');
	}

	function getTowns(){
		$temp = town::select('name') -> distinct() -> get();
		$respond = [];

		foreach($temp as $t)
			array_push($respond, $t->name);
		
		return response($respond, 201);
	}

	function showMore($id){
		if(! session()->has('userID'))
			return redirect(url('/'));
		else if(usersCities::where('user', session()->get('userID')) -> where('city', $id) -> count() == 0){
			$info = array(
				'title' => 'You not follow this town',
				'desc' => "To see graph of that town you need to follow it first!",
				'type' => 'info'
			);
			return view('dashboard', compact('info'));
		}
		else
			return view('showMore', compact('id'));
	}

	function getUserTownList($id){

		$list = usersCities::where('user', $id) -> get();

		$respond = [];

		foreach($list as $l)
			array_push($respond, $l->city);

		return response($respond, 201);
	}

}
