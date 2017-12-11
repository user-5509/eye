<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\NodeType;

class NodeTypeController extends Controller
{
    public function index()
    {
        $types = (new NodeType)->all()->sortBy('id');

        return view('content.nodetype.index', ['title' => 'Типы', 'types' => $types]);
    }

    public function getParents()
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

    public function createModal(Request $request)
    {
        if ($request->ajax()) {
            $parentsArray = array();
            $allTypes = (new NodeType)->all();

            return view('content.nodetype.create-edit-modal',
                ['action' => 'create', 'parents' => $parentsArray, 'allTypes' => $allTypes]);
        }
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->input('name');
            $alias = $request->input('alias');
            $icon = $request->input('icon');
            $parents = $request->input('parents');

            $type = new NodeType;
            $type->name = $name;
            $type->alias = $alias;
            $type->icon = $icon;
            $type->save();

            if (is_array($parents)) {
                // convert [string] to [int]
                $intArray = array_map(
                    function ($value) {
                        return (int)$value;
                    },
                    $parents
                );
                $type->parents()->sync($intArray);
                $type->save();
            }
        }
    }

    public function editModal(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $type = (new NodeType)->find($id);

            $parents = $type->parents;
            $parentsArray = array();
            foreach($parents as $parent) {
                $parentsArray[$parent->id] = $parent->name;
            }

            $allTypes = (new NodeType)->all();

            return view('content.nodetype.create-edit-modal',
                ['action' => 'edit', 'type' => $type, 'parents' => $parentsArray, 'allTypes' => $allTypes]);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $name = $request->input('name');
            $alias = $request->input('alias');
            $icon = $request->input('icon');
            $parents = $request->input('parents');

            if (isset($id)) { // todo: add other props validation
                $type = (new NodeType)->find($id);
                $type->name = $name;
                $type->alias = $alias;
                $type->icon = $icon;

                if (is_array($parents)) {
                    // convert [string] to [int]
                    $intArray = array_map(
                        function ($value) {
                            return (int)$value;
                        },
                        $parents
                    );
                    $type->parents()->sync($intArray);
                }
                $type->save();
            }
        }
    }

    public function deleteModal(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $type = (new NodeType)->find($id);
            return view('content.nodetype.delete-modal', ['type' => $type, 'trigger']);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            if (isset($id)) {
                $type = (new NodeType)->find($id);
                $type->delete();
            }
        }
    }
}
