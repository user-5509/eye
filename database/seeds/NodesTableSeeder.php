<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Node;

class NodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nodes')->insert([
            'name' => 'ЦССИ',
            'parent_id' => -1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('nodes')->insert([
            'name' => 'ПСП',
            'parent_id' => Node::where('name', 'ЦССИ')->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('nodes')->insert([
            'name' => 'СПМ',
            'parent_id' => Node::where('name', 'ЦССИ')->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
