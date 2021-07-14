<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\town;

class townController extends Controller
{

	function index(){
		$temp = town::select('name') -> distinct() -> get();
		$respond = [];

		foreach($temp as $t)
			array_push($respond, $t->name);
		
		return response($respond, 201);
	}
}
