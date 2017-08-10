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
        //$type2 = NodeType::create(array('name' => 'Здание',     'parent_id' => $type1->id));
        $type2 = NodeType::create(array('name' => 'Здание'));
        $type2->parents()->save($type1);
        $type3 = NodeType::create(array('name' => 'Помещение',  'parent_id' => $type2->id));
        $type4 = NodeType::create(array('name' => 'ПСП',  'parent_id' => $type3->id));
        $type7 = NodeType::create(array('name' => 'Гребёнка',  'parent_id' => $type4->id));
        $type8 = NodeType::create(array('name' => 'Бокс',  'parent_id' => $type4->id));
        $type9 = NodeType::create(array('name' => 'Пара',  'parent_id' => $type7->id));
        $type5 = NodeType::create(array('name' => 'СПМ',  'parent_id' => $type3->id));
        $type6 = NodeType::create(array('name' => 'Плата',  'parent_id' => $type5->id));
    }
}
