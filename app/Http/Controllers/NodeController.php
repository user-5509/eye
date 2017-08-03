<?php

namespace App\Http\Controllers;


use App\Node;


class NodeController extends Controller
{
    public function detail(Node $id)
    {
        return compact('id');
    }

    public function subnodes($id = -1)
    {
        $nodes = Node::all()->where('parent_id', '=', $id);
        return view('node.list', ['nodes' => $nodes]);
    }

    public function parent($id)
    {
        return Node::find($id)->parent;
    }
}
