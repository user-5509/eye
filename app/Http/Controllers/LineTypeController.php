<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\LineType;

class LineTypeController extends Controller
{
    public function index()
    {
        $types = (new LineType)->all()->sortBy('id');

        return view('content.linetype.index', ['title' => 'Типы', 'types' => $types]);
    }

    public function getById($id)
    {
        $type = (new LineType)->find($id);

        return view('content.linetype.info', ['type' => $type]);
    }

    public function createModal(Request $request)
    {
        if ($request->ajax()) {
            return view('content.linetype.create-edit-modal', ['action' => 'create']);
        }
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->input('name');
            $icon = $request->input('icon');
            $wires = $request->input('wires');

            $type = (new LineType);
            $type->name = $name;
            $type->icon = $icon;
            $type->wires = $wires;
            $type->save();
        }
    }

    public function editModal(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $type = (new LineType)->find($id);

            return view('content.linetype.create-edit-modal', ['action' => 'edit', 'type' => $type]);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $name = $request->input('name');
            $icon = $request->input('icon');
            $wires = $request->input('wires');

            if (isset($id)) { // todo: add other props validation
                $type = (new LineType)->find($id);
                $type->name = $name;
                $type->icon = $icon;
                $type->wires = $wires;
                $type->save();
            }
        }
    }

    public function deleteModal(Request $request)
    {
        // todo: add check for existed objects of this type
        if ($request->ajax()) {
            $id = $request->input('id');
            $type = (new LineType)->find($id);
            return view('content.linetype.delete-modal', ['type' => $type]);
        }
    }

    public function delete(Request $request)
    {
        // todo: add check for existed objects of this type
        if ($request->ajax()) {
            $id = $request->input('id');
            if (isset($id)) {
                $type = (new LineType)->find($id);
                $type->delete();
            }
        }
    }
}
