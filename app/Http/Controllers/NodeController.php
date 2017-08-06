<?php

namespace App\Http\Controllers;


use App\Node;
use App\NodeType;


class NodeController extends Controller
{
    public function detail(Node $id)
    {
        return compact('id');
    }

    public function ajax()
    {
        return "12345!!!";
    }

    public function subnodes($id = -1)
    {
        $nodes = Node::all()->where('parent_id', '=', $id);

        if($id <> -1)
            $availableTypes = NodeType::all()->where('parent_id', '=', $id);
        else
            $availableTypes = null;

        return view('node.list', ['curNodeId' => $id,
                                        'nodes' => $nodes,
                                        'availableTypes' => $availableTypes]);
    }

    public function parent($id)
    {
        return Node::find($id)->parent;
    }

    public function create($parentNodeId, $nodeTypeId)
    {
        $nodeType = NodeType::find($nodeTypeId);
        return view('node.create', ['parentNodeId' => $parentNodeId,
            'nodeType' => $nodeType]);
    }
}
