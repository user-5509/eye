<?php

use Illuminate\Database\Seeder;
use App\NodeType;
use App\Log;

class NodeTypesSeeder extends Seeder
{
    private function add($id, $name, $parentId = null)
    {
        if($id == null) {
            Log::put($this,'$id == null');
            return null;
        }


        $type = new NodeType(array('id' => $id, 'name' => $name));
        $type->save();

        if($parentId <> null){
            $parent  = (new NodeType)->find($parentId);
            if($parent == null) {
                Log::put($this,'$parent == null');
                return null;
            }
            $type->parents()->save($parent);
        }

        return $type;
    }

    private function addParent($id, $parentId)
    {
        $node = (new NodeType)->find($id);
        if($node == null) {
            Log::put($this,'$node == null');
            return null;
        }

        $parent = (new NodeType)->find($parentId);
        if($parent == null) {
            Log::put($this,'$parent == null');
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
        $this->add(NodeType::BUILDING, 'Здание', NodeType::_WORLD_);
        $this->add(NodeType::ROOM, 'Помещение', NodeType::BUILDING);
        $this->add(NodeType::PSP, 'ПСП', NodeType::ROOM);
        $this->add(NodeType::COMMON_BOX_60, 'Гребенка (60 пар)', NodeType::PSP);
        $this->add(NodeType::PAIR, 'Пара', NodeType::COMMON_BOX_60);
        $this->add(NodeType::CRONE_BOX_100, 'Бокс (100 пар)', NodeType::PSP);
        $this->addParent(NodeType::PAIR, NodeType::CRONE_BOX_100);
        $this->add(NodeType::SPM, 'СПМ', NodeType::ROOM);
        $this->add(NodeType::BOARD_CS, 'Плата (КС)', NodeType::SPM);
        $this->addParent(NodeType::PAIR, NodeType::BOARD_CS);
        $this->add(NodeType::BOARD_CSS, 'Плата (КСС)', NodeType::SPM);
        $this->addParent(NodeType::PAIR, NodeType::BOARD_CSS);
        $this->add(NodeType::CROSS_ENCLOSURE, 'Шкаф (кросс)', NodeType::ROOM);
        $this->add(NodeType::CROSS_BOX, 'Бокс (кросс)', NodeType::CROSS_ENCLOSURE);
        $this->addParent(NodeType::PAIR, NodeType::CROSS_BOX);
        $this->add(NodeType::TELCO_ENCLOSURE, 'Шкаф (телеком)', NodeType::ROOM);
        $this->add(NodeType::CRONE_RACK, 'Crone rack', NodeType::TELCO_ENCLOSURE);
        $this->add(NodeType::CRONE_BOX_10, 'Гребенка Crone (10 пар)', NodeType::CRONE_RACK);
        $this->addParent(NodeType::PAIR, NodeType::CRONE_BOX_10);
        $this->add(NodeType::PATCH_PANEL_24, 'Патч-панель (24 порта)', NodeType::TELCO_ENCLOSURE);
        $this->addParent(NodeType::PAIR, NodeType::PATCH_PANEL_24);
    }
}
