<?php

use Illuminate\Database\Seeder;
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

        $type1 = NodeType::create(array('name' => 'Мир',        'parent_id' => '-1'));
        $type2 = NodeType::create(array('name' => 'Здание',     'parent_id' => $type1->id));
        $type3 = NodeType::create(array('name' => 'Помещение',  'parent_id' => $type2->id));
        $type4 = NodeType::create(array('name' => 'ПСП',  'parent_id' => $type3->id));
        $type5 = NodeType::create(array('name' => 'СПМ',  'parent_id' => $type3->id));
        $type6 = NodeType::create(array('name' => 'Плата',  'parent_id' => $type5->id));
    }
}
