<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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

        foreach($townsIDs as $t)
            $jsonCode .= $t -> city . ',';
        $jsonCode = substr($jsonCode, 0, -1);

        $key=env('WEATHER_API_KEY', 'ERROR');
        $link = "https://api.openweathermap.org/data/2.5/group?appid=$key&units=metric&id=$jsonCode";

        $respond = json_decode(Http::get($link), true);
        $data = [];
        
        foreach($respond['list'] as $r){
            array_push($data, [ 
                'created_at' => now() -> addHour(2), 
                'updated_at' => now() -> addHour(2), 
                'temp' => $r['main']['temp'], 
                'humidity' => $r['main']['humidity'], 
                'townID' => $r['id'] ] );
        }

        weatherInfo::insert($data);

        // Remove all data older than day
        weatherInfo::where('created_at', '<', now() -> addDay(-1)) -> delete();
    }
}
