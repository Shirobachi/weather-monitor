<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\usersCities;

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
    }
}
