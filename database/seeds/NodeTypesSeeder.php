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

        $type1 = new NodeType(array('name' => 'Мир'));
        //$type2 = NodeType::create(array('name' => 'Здание',     'parent_id' => $type1->id));
        $type2 = NodeType::create(array('name' => 'Здание'));
        $type2->parents()->save($type1);
        $type3 = NodeType::create(array('name' => 'Помещение'));
        $type3->parents()->save($type2);
        $type4 = NodeType::create(array('name' => 'ПСП'));
        $type4->parents()->save($type3);
        $type7 = NodeType::create(array('name' => 'Гребёнка'));
        $type7->parents()->save($type4);
        $type8 = NodeType::create(array('name' => 'Бокс'));
        $type8->parents()->save($type4);
        $type9 = NodeType::create(array('name' => 'Пара'));
        $type9->parents()->save($type7);
        $type9->parents()->save($type8);
        $type5 = NodeType::create(array('name' => 'СПМ'));
        $type5->parents()->save($type3);
        $type6 = NodeType::create(array('name' => 'Плата'));
        $type6->parents()->save($type5);
    }
}
