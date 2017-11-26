<?php

use Illuminate\Database\Seeder;
use App\NodeType;
use App\Log;

class NodeTypesSeeder extends Seeder
{
    /**
     * @param $id
     * @param $name
     * @param array $parents
     * @param null $icon
     * @return NodeType|null
     */
    private function add($name, $parents = [], $icon = null)
    {
        if ($name == null) {
            //Log::put($this, 'name is not set!');
            return null;
        }

        $type = new NodeType(['name' => $name, 'icon' => $icon]);
        $type->save();

        if (is_array($parents)) {
            foreach ($parents as $parentName) {
                $node = (new NodeType)->where('name', '=', $parentName)->first();
                if ($node == null) {
                    //Log::put($this, 'parent not found!');
                    return null;
                }
                $type->parents()->save($node);
            }
        }

        return $type;
    }

    /**
     * @param $id
     * @param $parentId
     * @return mixed|null|static
     */
    private function addParent($id, $parentId)
    {
        $node = (new NodeType)->find($id);
        if ($node == null) {
            Log::put($this, '$node == null');
            return null;
        }

        $parent = (new NodeType)->find($parentId);
        if ($parent == null) {
            Log::put($this, '$parent == null');
            return null;
        }

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
        $this->add('Мир');
        $this->add('Здание', ['Мир'], 'building-o');
        $this->add('Помещение', ['Здание'], 'sign-in');
        $this->add('ПСП', ['Помещение'], 'braille');
        $this->add('Гребенка (60 пар)', ['ПСП'], 'microchip');
        $this->add('Бокс (100 пар)', ['ПСП'], 'microchip');
        $this->add('СПМ', ['Помещение'], 'braille');
        $this->add('Плата (КС)', ['СПМ'], 'object-group');
        $this->add('Плата (КСС)', ['СПМ'], 'object-group');
        $this->add('Шкаф (кросс)', ['Помещение'], 'object-group');
        $this->add('Бокс (кросс)', ['Шкаф (кросс)'], 'microchip');
        $this->add('Шкаф (телеком)', ['Помещение'], 'object-group');
        $this->add('Crone rack', ['Шкаф (телеком)'], 'object-group');
        $this->add('Гребенка Crone (10 пар)', ['Crone rack'], 'microchip');
        $this->add('Патч-панель (24 порта)', ['Шкаф (телеком)'], 'ellipsis-h');
        $this->add('Пара', [
            'Гребенка (60 пар)',
            'Бокс (100 пар)',
            'Плата (КС)',
            'Плата (КСС)',
            'Бокс (кросс)',
            'Гребенка Crone (10 пар)',
            'Патч-панель (24 порта)'
        ]);
    }
}
