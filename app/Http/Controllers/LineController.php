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
        //$lines = (new Line)->orderBy('name')->get();
        //return view('content.line.index', ['title' => 'Тракты', 'lines' => $lines]);
        return view('content.line.index');
    }

    public function getList(Request $request)
    {
        $lines = (new Line)->orderBy('type')->orderBy('name')->get();
        return view('content.line.list', ['lines' => $lines]);

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

    public function createLineModal(Request $request)
    {
        if ($request->ajax()) {
            return view('content.line.create-modal');
        }
        else
            return null;
    }

    public function createLineExecute(Request $request)
    {
        if ($request->ajax()) {
            $line = new Line();
            $line->name = $request->input('lineName');
            $line->type = $request->input('lineType');
            $line->save();
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
