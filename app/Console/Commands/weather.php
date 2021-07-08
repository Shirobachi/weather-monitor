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
        // echo 'test';
        // usersCities::create( [ 'user' => 0, 'city' => 0 ] );    

        $temp = usersCities::select('city')->distinct()->get();
        dump($temp);
        
        $jsonCode = '';

        foreach($temp as $s)
            {
                $jsonCode .= $s -> city . ',';
            }

        $jsonCode = substr($jsonCode, 0, -1);
        dump($jsonCode);
        dump(count($temp));

        $key=env('WEATHER_API_KEY', 'ERROR');
        dump($key);

        $link = "https://api.openweathermap.org/data/2.5/group?appid=$key&units=metric&id=$jsonCode";
        dump($link);

        $t = Http::get($link);
        $t = json_decode($t, true);

        dump($t);

        $data = [];
        
        foreach($t['list'] as $f){
            dump($f['main']['temp'] . '°C and ' . $f['main']['humidity'] . '% of humidity in ' . $f['name'] . '[ ' . $f['id'] . ' ]');
            array_push($data, [ 'temp' => $f['main']['temp'], 'humidity' => $f['main']['humidity'] ] );
        }

        dump(weatherInfo::all()->count());
        dump($data);

        weatherInfo::insert($data);

        dump(weatherInfo::all()->count());

        dump(date('Y-m-d H:i:s' . 'lol'));

    }
}
