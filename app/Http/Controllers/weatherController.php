<?php

namespace App\Http\Controllers;

use App\Models\usersCities;

use Illuminate\Http\Request;
use Storage;

class weatherController extends Controller
{
    function dashboard(){
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

        $json = Storage::disk('local')->get('cities.min.json');
        $json = json_decode($json, true);
        
        return response($json, 201);
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

            return view('dashboard', compact('info'));
        }

        $temp = [];
        usersCities::where('user', $userID)->delete();

        foreach ($cities as $c)
            usersCities::create( [ 'user' => $userID, 'city' => $c ] );    

        foreach ($temp as $c)
            usersCities::create($c);

        $info = array(
            'title' => 'Updated!',
            'desc' => 'Your list of followinf towns is now updated!',
        );

        return view('dashboard', compact('info'));
    }
}
