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
                'desc' => "Follow some towns before you see dashbord!",
                'type' => 'warning'
            );
            return view('updateTownList', compact('info'));
        }

        return view('dashboard');
    }

    function updateCitiesShow(){
        if(! session()->has('userID'))
            return redirect(url('/'));
        else
            return view('updateTownList');
    }

    function getTowns(){
        $temp = town::select('name') -> distinct() -> get();
        $respond = [];

        foreach($temp as $t)
            array_push($respond, $t->name);
        
        return response($respond, 201);
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

            array_push($respons, $temp);
        }

        return response($respons, 201);
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

    function showMoreJSON($id){
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
        // array_push($respond, $temp);
        // array_push($respond, $humidity);

        return response($respond, 201);
    }

    function getUserTownList($id){

        $list = usersCities::where('user', $id) -> get();

        $respond = [];

        foreach($list as $l)
            array_push($respond, $l->city);

        return response($respond, 201);
    }

    function addTown(request $r){
        $town = town::where('name', $r->town) -> first();

        if(! $town){
            $info = array(
                'title' => 'Wrong town',
                'desc' => "Did you tried to mess up?!",
                'type' => 'danger'
            );

            return view('dashboard', compact('info'));
        }
        else if(usersCities::where('user', session()->get('userID')) -> where('city', $town->APIID) -> count() > 0){
            $info = array(
                'title' => 'You already follow it',
                'desc' => "You cannot add town to follow what you already following!",
                'type' => 'warning'
            );

            return view('dashboard', compact('info'));
        }
        else if(usersCities::where('user', session()->get('userID')) -> count() >= 10){
            $info = array(
                'title' => 'You are NOT a VIP',
                'desc' => 'You can make up to 10 following towns!',
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
                'title' => 'Added',
                'desc' => "Now we'll collect info about this town for you ;)",
            );

            return view('dashboard', compact('info'));
        }
    }

    function removeTown($id){
        if(usersCities::where('user', session()->get('userID')) -> where('city', $id) -> count() == 0 ){
            $info = array(
                'title' => 'Wrong town',
                'desc' => "Did you tried to mess up?!",
                'type' => 'danger'
            );

            return view('dashboard', compact('info'));
        }
        else{
            $town = usersCities::where('user', session()->get('userID')) -> where('city', $id) -> delete();
            $info = array(
                'title' => 'Removed',
                'desc' => "You not following this town anymore",
            );

            return view('dashboard', compact('info'));
        }

    }
}
