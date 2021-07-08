<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\usersCities;
use App\Models\weatherInfo;

class weather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull weather info from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $townsIDs = usersCities::select('city')->distinct()->get();
        
        $jsonCode = '';

        foreach($townsIDs as $s)
            $jsonCode .= $s -> city . ',';
        $jsonCode = substr($jsonCode, 0, -1);

        $key=env('WEATHER_API_KEY', 'ERROR');
        $link = "https://api.openweathermap.org/data/2.5/group?appid=$key&units=metric&id=$jsonCode";

        $respond = json_decode(Http::get($link), true);
        $data = [];
        
        foreach($respond['list'] as $f){
            array_push($data, [ 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'), 
                'temp' => $f['main']['temp'], 
                'humidity' => $f['main']['humidity'], 
                'townID' => $f['id'] ] );
        }

        weatherInfo::insert($data);
    }
}
