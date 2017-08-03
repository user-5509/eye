<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Node;

class NodesSeeder extends Seeder
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
            //'parent_id' => 1,
            'parent_id' => -1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $rootNode = Node::where('name', 'ЦССИ')->first();
        /*
        $rootNode = new Node;
        $rootNode->name = 'ЦССИ';
        $rootNode->child_id = -1;
        $rootNode->created_at = Carbon::now();
        $rootNode->updated_at = Carbon::now();
        */


        /*
        DB::table('nodes')->insert([
            'name' => 'ПСП',
            //'parent_id' => 1,
            'child_id' => -1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $tmpNode1 = Node::where('name', 'ПСП')->first();
        */
        $tmpNode1 = new Node;
        $tmpNode1->name = 'ПСП';
        $tmpNode1->parent_id = -1;
        $tmpNode1->created_at = Carbon::now();
        $tmpNode1->updated_at = Carbon::now();
        /*
        DB::table('nodes')->insert([
            'name' => 'СПМ',
            //'parent_id' => 1,
            'child_id' => -1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $tmpNode2 = Node::where('name', 'СПМ')->first();
        */
        $tmpNode2 = new Node;
        $tmpNode2->name = 'СПМ';
        $tmpNode2->parent_id = -1;
        $tmpNode2->created_at = Carbon::now();
        $tmpNode2->updated_at = Carbon::now();

        $tmpNode3 = new Node;
        $tmpNode3->name = 'Плата №1';
        $tmpNode3->parent_id = -1;
        $tmpNode3->created_at = Carbon::now();
        $tmpNode3->updated_at = Carbon::now();

        $rootNode->childs()->save($tmpNode1);
        $rootNode->childs()->save($tmpNode2);
        $tmpNode1->parent()->associate($rootNode);
        $tmpNode2->parent()->associate($rootNode);

        $tmpNode2->childs()->save($tmpNode3);
        $tmpNode3->parent()->associate($tmpNode2);
}
}
