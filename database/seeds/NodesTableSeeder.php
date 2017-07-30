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
            'parent_id' => 0,
            'node_id' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $rootNode = Node::where('name', 'ЦССИ')->first();
        DB::table('nodes')->insert([
            'name' => 'ПСП',
            'parent_id' => 0,
            'node_id' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $tmpNode1 = Node::where('name', 'ПСП')->first();
        $tmpNode1->parent()->associate($rootNode);
        $rootNode->childs()->save($tmpNode1);
        DB::table('nodes')->insert([
            'name' => 'СПМ',
            'parent_id' => 0,
            'node_id' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $tmpNode2 = Node::where('name', 'СПМ')->first();
        $tmpNode2->parent()->associate($rootNode);
        $rootNode->childs()->save($tmpNode2);
}
}
