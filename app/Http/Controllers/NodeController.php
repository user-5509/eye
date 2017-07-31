<?php

namespace App\Http\Controllers;


use App\Node;


class NodeController extends Controller
{
    public function index()
    {
        $nodes = Node::all();

        return $nodes;
    }

    public function show(Node $id)
    {
        return compact('id');
    }

    public function subnodes($id)
    {
        return Node::find($id)->childs;
    }

    public function topnode($id)
    {
        return Node::find($id)->parent;
    }
}
