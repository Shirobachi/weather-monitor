<?php

namespace Database\Seeders;

use Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class towns extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('cities.min.json');
        $json = json_decode($json, true);

        

        DB::table('towns')->insert($json);
    }
}
