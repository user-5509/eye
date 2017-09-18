<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Node;
use App\NodeType;

class NodesSeeder extends Seeder
{
    /**
     * Add procedure wrapper.
     *
     * @return App\Node
     */
    private function add($name, $typeName, $parentName = '')
    {
        $tmpNode = new Node(array('name' => $name));
        $type  = NodeType::where('name', $typeName)->first();
        $tmpNode->type()->associate($type);
        if($parentName <> ''){
            $parent  = Node::where('name', $parentName)->first();
            $tmpNode->parent()->associate($parent);
        }
        $tmpNode->save();

        return $tmpNode;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->add('Мир', 'Мир', '');
        $this->add('ЦССИ', 'Здание', 'Мир');
        $this->add('пом.415', 'Помещение', 'ЦССИ');
        $this->add('ПСП №1', 'ПСП', 'пом.415');
        $this->add('СПМ №1', 'СПМ', 'пом.415');
        //$this->add('Плата №1', 'Плата', 'СПМ №1');
    }
}
