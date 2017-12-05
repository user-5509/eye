<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Line;
use App\Node;

class LineController extends Controller
{


    public function index(Request $request)
    {
        $lines = (new Line)->orderBy('name')->get();
        return view('content.line.index', ['lines' => $lines]);
    }



    public function getList(Request $request)
    {
        $lines = (new Line)->orderBy('type')->orderBy('name')->get()->toArray();
        return json_encode($lines);
        //return view('content.line.list', ['lines' => $lines]);
    }

    public function getLines()
    {
        return Line::all();
    }

    public function about(Request $request)
    {
        if ($request->ajax()) {

            $lineId = Input::get('lineId');

            $nodeId = Input::get('nodeId');

            $lineName = (new Line)->find($lineId)->getName();

            $nodes = (new NodeController)->getOrderedByLine($lineId);

            return view('content.line.about', [
                'lineName'  => $lineName,
                'nodes'     => $nodes,
                'nodeId'    => $nodeId
            ]);
        }
        else
            return null;
    }

    public function createModal(Request $request)
    {
        if ($request->ajax()) {
            $parentsArray = array();

            return view('content.line.create-edit-modal', ['action' => 'create']);
        }
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->input('name');
            $type = $request->input('type');

            $line = (new Line);
            $line->name = $name;
            $line->type = $type;
            $line->save();
        }
    }

    public function editModal(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $line = (new Line)->find($id);

            return view('content.line.create-edit-modal', ['action' => 'edit', 'line' => $line]);
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

    public function deleteLineModal(Request $request)
    {
        if ($request->ajax()) {
            $line = (new Line)->find(Input::get('lineId'));

            return view('content.line.delete-modal', ['line' => $line]);
        }
        else
            return null;
    }

    public function deleteLineExecute(Request $request, $lineId)
    {
        (new NodeController)->RemoveLineBinding($lineId);

        $line = (new Line)->find($lineId);
        $line->delete();
    }

    public function editExecute(Request $request)
    {
        if ($request->ajax()) {
            $lineId = $request->input('lineId');
            $lineName = $request->input('lineName');
            $lineType = $request->input('lineType');

            $line = (new Line)->find($lineId);
            $line->name = $lineName;
            $line->type = $lineType;
            $line->save();
        }
    }
}
