<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Line;

class LineController extends Controller
{
    public function index(Request $request)
    {
        $lines = Line::all();

        return view('content.line.index', ['lines' => $lines]);
    }

    public function getNodes($lineId)
    {
        $lines = Line::all();

        return view('content.line.index', ['lines' => $lines]);
    }
}
