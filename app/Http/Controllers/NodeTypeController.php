<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\NodeType;

class NodeTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = (new NodeType)->all()->sortBy('id');

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

    public function save(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $parents = $request->input('parents');

        if(isset($id)) { // update
            $type = (new NodeType)->find($id);
            $type->name = $name;
            if(is_array($parents)) {
                $type->parents()->sync($parents);
            }
            $type->save();
        } else { // create

        }


/*        $parents = $type->parents;
        $parentsArray = array();
        foreach($parents as $parent) {
            $parentsArray[$parent->id] = $parent->name;

        }
*/
        //return view('content.nodetype.info', ['type' => $type, 'parents' => $parentsArray, 'allTypes' => $allTypes]);
    }
}
