<?php

namespace App\Http\Controllers;

use App\Models\usersCities;
use App\Models\town;
use App\Models\weatherInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class usersTownsController extends Controller
{
	function index($id){
		$towns = usersCities::where('user', $id) -> get();
		$respond = [];

		foreach($towns as $t){
			$data = weatherInfo::where('townID', $t -> city) -> orderBy('created_at', 'desc') -> first();
			
			$temp = [];
			$temp['APIID'] = $t -> city;
			$temp['townName'] = town::where('APIID', $t -> city) -> first() -> name;
			
			if($data == null)
			{
				try{
					Artisan::call('weather:pull');
					$data = weatherInfo::where('townID', $t -> city) -> orderBy('created_at', 'desc') -> first();
				}
				catch (SomeException $e){
					$temp['temp'] = null;
					$temp['humidity'] = null; 
				}
			}
				
			$temp['temp'] = $data -> temp;
			$temp['humidity'] = $data -> humidity;

			array_push($respond, $temp);
		}

		return response($respond, 201);
	}
		
		function show($id){
			$infos = weatherInfo::where('townID', $id) -> get();
	
			$respond = [];
	
			$temp = [];
			$humidity = [];
			$label = [];
	
			foreach($infos as $t){
				array_push($temp, $t->temp);
				array_push($humidity, $t->humidity);
				array_push($label, $t->created_at->format('d') . 
					( $t->created_at->format('d') % 10 == 1 ? 'st' : ($t->created_at->format('d') % 10 == 2 ? 'nd' : 'th' )) . 
					' of ' . $t->created_at->format('F H:i'));
			}
	
			array_push($respond, $label, $temp, $humidity);
	
			return response($respond, 201);
		}
    
    function store(request $r){
		$town = town::where('name', $r->town) -> first();

		if(! $town){
			$info = array(
				'desc' => __('town.wrong'),
				'type' => 'danger'
			);

			return view('dashboard', compact('info'));
		}
		else if(usersCities::where('user', session()->get('userID')) -> where('city', $town->APIID) -> count() > 0){
			$info = array(
				'desc' => __('town.alreadyFollowed'),
				'type' => 'warning'
			);

			return view('dashboard', compact('info'));
		}
		else if(usersCities::where('user', session()->get('userID')) -> count() >= 10){
			$info = array(
				'desc' => __('town.limit'),
				'type' => 'warning'
			);

			return view('dashboard', compact('info'));
		}
		else{
			$temp = array(
				'user' => session()->get('userID'),
				'city' => $town -> APIID
			);

			usersCities::create($temp);

			$info = array(
				'desc' => __('town.added'),
			);

			return view('dashboard', compact('info'));
		}
	}

    function destroy($id){
		if(usersCities::where('user', session()->get('userID')) -> where('city', $id) -> count() == 0 ){
			$info = array(
				'desc' => __('town.wrong'),
				'type' => 'danger'
			);

			return view('dashboard', compact('info'));
		}
		else{
			$town = usersCities::where('user', session()->get('userID')) -> where('city', $id) -> delete();
			$info = array(
				'desc' => __('town.removed'),
			);

			return view('dashboard', compact('info'));
		}
	}
	
}
