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
        /*$this->add('Мир', '');
        $this->add('Здание', 'Мир');
        $this->add('Помещение', 'Здание');
        $this->add('ПСП', 'Помещение');
        $this->add('Гребенка (60 пар)', 'ПСП');
        $this->add('Пара', 'Гребенка (60 пар)');
        $this->add('Бокс (100 пар)', 'ПСП');
        $this->addParent('Пара', 'Бокс (100 пар)');
        $this->add('СПМ', 'Помещение');
        $this->add('Плата (КС)', 'СПМ');
        $this->addParent('Пара', 'Плата (КС)');
        $this->add('Плата (СКС)', 'СПМ');
        $this->addParent('Пара', 'Плата (СКС)');
        $this->add('Шкаф (кросс)', 'Помещение');
        $this->add('Бокс (кросс)', 'Шкаф (кросс)');
        $this->addParent('Пара', 'Бокс (кросс)');
        $this->add('Шкаф (телеком)', 'Помещение');
        $this->add('Бокс Crone', 'Шкаф (телеком)');
        $this->add('Гребенка Crone (10 пар)', 'Бокс Crone');
        $this->addParent('Пара', 'Гребенка Crone (10 пар)');*/
        $this->add('Патч-панель (аналог)', 'Шкаф (телеком)');
        $this->addParent('Пара', 'Патч-панель (аналог)');
    }
}
