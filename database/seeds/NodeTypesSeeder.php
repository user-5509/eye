<?php

use Illuminate\Database\Seeder;
use App\NodeType;

class NodeTypesSeeder extends Seeder
{
    /**
     * Add procedure wrapper.
     *
     * @return NodeType
     */
    private function add($name, $parentName = '')
    {
        $tmpTypeNode = new NodeType(array('name' => $name));
        $tmpTypeNode->save();
        if($parentName <> ''){
            $parent  = NodeType::where('name', $parentName)->first();
            $tmpTypeNode->parents()->save($parent);
        }
        return $tmpTypeNode;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->add('Мир', '');
        $this->add('Здание', 'Мир');
        $this->add('Помещение', 'Здание');
        $this->add('ПСП', 'Помещение');
        $this->add('Гребенка (60 пар)', 'ПСП');
        $this->add('Пара', 'Гребенка');
        $this->add('Бокс (100 пар)', 'ПСП');
        $this->add('Пара', 'Бокс');
        $this->add('СПМ', 'Помещение');
        $this->add('Плата', 'СПМ');
        $this->add('Гнездо', 'Плата');
    }
}
