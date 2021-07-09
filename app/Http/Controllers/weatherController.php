<?php

namespace App\Http\Controllers;

use App\Models\usersCities;
use App\Models\town;
use App\Models\weatherInfo;

use Illuminate\Http\Request;

class weatherController extends Controller
{
    function dashboard(){
        if(! session()->has('userID'))
            return redirect(url('/'));

        if(usersCities::where('user', session()->get('userID'))->get()->count() == 0){
            $info = array(
                'title' => 'No following towns yet',
                'desc' => "Follow some towns before you see dashbord!",
                'type' => 'warning'
            );
            return view('updateTownList', compact('info'));
        }

        return view('dashboard');
    }

    function updateCitiesShow(){
        return view('updateTownList');
    }

    function getTowns(){
        return response(town::all(), 201);
    }

    function updateCities(request $r){

        $userID = session()->get('userID');
        $cities = $r->cities;

        if($cities && count($cities) > 10){
            $info = array(
                'title' => 'You are NOT a VIP',
                'desc' => 'You can make up to 10 following towns!',
                'type' => 'warning'
            );

            return view('dashboard', compact('info'));
        }
        else if(! $cities){
            usersCities::where('user', $userID)->delete();

            $info = array(
                'title' => 'No following towns',
                'desc' => 'Your following town list is empty now!',
                'type' => 'warning'
            );

            return view('updateTownList', compact('info'));
        }

        $temp = [];
        usersCities::where('user', $userID)->delete();

        foreach ($cities as $c)
            usersCities::create( [ 'user' => $userID, 'city' => $c ] );    

        foreach ($temp as $c)
            usersCities::create($c);

        $info = array(
            'title' => 'Updated!',
            'desc' => 'Your list of following towns is now updated!',
        );

        return view('dashboard', compact('info'));
    }

    function weatherNow($id){
        $towns = usersCities::where('user', $id) -> get();
        $respons = [];

        foreach($towns as $t){
            $data = weatherInfo::where('townID', $t -> city) -> orderBy('created_at', 'desc') -> first();
            
            $temp = [];
            $temp['townName'] = town::where('APIID', $t -> city) -> first() -> name;
            
            if($data == null){
                $temp['temp'] = null;
                $temp['humidity'] = null;
            }
            else{
                $temp['temp'] = $data -> temp;
                $temp['humidity'] = $data -> humidity;
            }

            array_push($respons, $temp);
        }

        return response($respons, 201);
    }
}
