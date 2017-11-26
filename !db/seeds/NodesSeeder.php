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
    private function add($id, $name, $parents = [], $icon = null)
    {
        if ($id == null) {
            Log::put($this, '$id == null');
            return null;
        }

        $type = new NodeType(array('id' => $id, 'name' => $name, 'icon' => $icon));
        $type->save();

        if (is_array($parents)) {
            foreach ($parents as $parentId) {
                $node = (new NodeType)->find($parentId);
                if ($node == null) {
                    Log::put($this, '$parent == null');
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
        $this->add(NodeType::_WORLD_, 'Мир');
        $this->add(NodeType::BUILDING, 'Здание', [NodeType::_WORLD_], 'building-o');
        $this->add(NodeType::ROOM, 'Помещение', [NodeType::BUILDING], 'sign-in');
        $this->add(NodeType::PSP, 'ПСП', [NodeType::ROOM], 'braille');
        $this->add(NodeType::COMMON_BOX_60, 'Гребенка (60 пар)', [NodeType::PSP], 'microchip');
        $this->add(NodeType::CRONE_BOX_100, 'Бокс (100 пар)', [NodeType::PSP], 'microchip');
        $this->add(NodeType::SPM, 'СПМ', [NodeType::ROOM], 'braille');
        $this->add(NodeType::BOARD_CS, 'Плата (КС)', [NodeType::SPM], 'object-group');
        $this->add(NodeType::BOARD_CSS, 'Плата (КСС)', [NodeType::SPM], 'object-group');
        $this->add(NodeType::CROSS_ENCLOSURE, 'Шкаф (кросс)', [NodeType::ROOM], 'object-group');
        $this->add(NodeType::CROSS_BOX, 'Бокс (кросс)', [NodeType::CROSS_ENCLOSURE], 'microchip');
        $this->add(NodeType::TELCO_ENCLOSURE, 'Шкаф (телеком)', [NodeType::ROOM], 'object-group');
        $this->add(NodeType::CRONE_RACK, 'Crone rack', [NodeType::TELCO_ENCLOSURE], 'object-group');
        $this->add(NodeType::CRONE_BOX_10, 'Гребенка Crone (10 пар)', [NodeType::CRONE_RACK], 'microchip');
        $this->add(NodeType::PATCH_PANEL_24, 'Патч-панель (24 порта)', [NodeType::TELCO_ENCLOSURE], 'ellipsis-h');
        $this->add(NodeType::PAIR, 'Пара', [
            NodeType::COMMON_BOX_60,
            NodeType::CRONE_BOX_100,
            NodeType::BOARD_CS,
            NodeType::BOARD_CSS,
            NodeType::CROSS_BOX,
            NodeType::CRONE_BOX_10,
            NodeType::PATCH_PANEL_24
        ]);
    }
}
