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
        return view('content.line.index', ['title' => 'Тракты']);
    }

    public function getList(Request $request)
    {
        $lines = Line::all();

        return view('content.line.list', [
            'lines' => $lines]);
    }

    public function about(Request $request)
    {
        if ($request->ajax()) {
            $lineId = Input::get('lineId');
            $nodes = Node::all()->sortBy('id')->where('line_id', '=', $lineId);

            return view('content.line.about', ['nodes' => $nodes]);
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
            $line->save();

            return 1;
        }
        else
            return "1212121221";
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
        (new NodeController())->RemoveLineBinding($lineId);

        $line = (new Line)->find($lineId);
        $line->delete();
    }

}
