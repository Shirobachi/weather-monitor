<?php

namespace App\Http\Controllers;

use App\Models\usersCities;

use Illuminate\Http\Request;
use Storage;

class weatherController extends Controller
{
    function main(){
        return view('weather');
    }

    function getCities(){

        $json = Storage::disk('local')->get('cities.min.json');
        $json = json_decode($json, true);
        
        return response($json, 201);
    }

    function updateCities(request $r){
        $userID = session()->get('userID');
        $cities = $r->cities;

        if(count($cities) > 10){
            $info = array(
                'title' => 'You are NOT a VIP',
                'desc' => 'You can make up to 10 following towns!',
                'type' => 'warning'
            );

            return view('weather', compact('info'));
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

        return view('weather', compact('info'));
    }
}
