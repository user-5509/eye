<?php

namespace App\Http\Controllers;

use App\NodeType;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('content.admin.index');
    }

    public function types(Request $request)
    {
        $types = (new NodeType)->all();
        return view('content.admin.types', ['types' => $types]);
    }
}
