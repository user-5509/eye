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

        return view('content.type.index', ['title' => 'Типы объектов', 'types' => $types]);
    }

    public function getParents(Request $request)
    {
        $typeId = Input::get('typeId');
        $parents = (new NodeType)->find($typeId)->parents;

        $data = array();
        foreach($parents as $parent ) {
            $data[] = ['id' => $parent->id, 'name' => $parent->name];
        }

        return json_encode($data);
    }
}
