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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
