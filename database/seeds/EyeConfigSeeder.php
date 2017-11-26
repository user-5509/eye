<?php

use Illuminate\Database\Seeder;
use App\EyeConfig;

class EyeConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new EyeConfig)->set('globalRootNode', 'WORLD');
        (new EyeConfig)->set('currentRootNode', 'WORLD');
    }
}
