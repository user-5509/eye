<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\NodeType;

class NodeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $type1 = new NodeType;
        $type1->name = 'Мир';
        $type1->parent_id = -1;
        */

        DB::table('nodetypes')->insert([
            'name' => 'Мир',
            'parent_id' => -1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $type1 = NodeType::where('name', 'Мир')->first();

        $type2 = new NodeType;
        $type2->name = 'Здание';
        $type2->parent()->associate($type1);

        $type3 = new NodeType;
        $type3->name = 'Помещение';
        $type3->parent()->associate($type2);

    }
}
