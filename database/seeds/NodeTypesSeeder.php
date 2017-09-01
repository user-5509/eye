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

    private function addParent($name, $parentName)
    {
        $node = NodeType::where('name', $name)->first();
        $parent = NodeType::where('name', $parentName)->first();
        $node->parents()->save($parent);
        return $node;
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
        $this->add('Пара', 'Гребенка (60 пар)');
        $this->add('Бокс (100 пар)', 'ПСП');
        $this->addParent('Пара', 'Бокс (100 пар)');
        $this->add('СПМ', 'Помещение');
        $this->add('Плата (КС)', 'СПМ');
        $this->add('Гнездо', 'Плата (КС)');
        $this->addParent('Пара', 'Гнездо');
        $this->add('Плата (СКС)', 'СПМ');
        $this->addParent('Гнездо', 'Плата (СКС)');
    }
}
