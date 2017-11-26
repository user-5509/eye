<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\NodeType;

class NodeTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = (new NodeType)->all();

        return view('content.nodetype.index', ['title' => 'Типы', 'types' => $types]);
    }

    public function getParents(Request $request)
    {
        $typeId = Input::get('typeId');
        $parents = (new NodeType)->find($typeId)->parents;

        $data = array();
        foreach($parents as $parent ) {
            $data[] = array('id' => $parent->id, 'name' => $parent->name);
        }

        return json_encode($data);
    }

    public function getById($id)
    {
        $type = (new NodeType)->find($id);

        $parents = $type->parents;
        $parentsArray = array();
        foreach($parents as $parent) {
            $parentsArray[$parent->id] = $parent->name;
        }

        $allTypes = (new NodeType)->all();

        return view('content.nodetype.info', ['type' => $type, 'parents' => $parentsArray, 'allTypes' => $allTypes]);
    }
}
