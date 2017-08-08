<?php

namespace App\Http\Controllers;


use App\Node;
use App\NodeType;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Response;


class NodeController extends Controller
{
    public function detail(Node $id)
    {
        return compact('id');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getFormContent(Request $request)
    {
        if ($request->ajax()) {
            $nodeTypeId = Input::get('nodeTypeId');
            return view('node.createNode', ['nodeTypeId' => $nodeTypeId]);
        }
        else
            return null;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function accept(Request $request)
    {
        if ($request->ajax()) {
            $node = new Node;
            $node->name = $request->input('nodeName');
            $node->type_id = $request->input('nodeTypeId');
            $node->parent_id = $request->input('parentNodeId');
            $node->save();
            //$nodeName = $request->input('nodeName');
            //$nodeName = $request->all();
            //return $nodeName;
            return 1;
        }
        else
            return "1212121221";
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $nodeId = -1)
    {
        $request->session()->put('currentNodeId', $nodeId);
        $nodes = Node::all()->where('parent_id', '=', $nodeId);
        $currentNode = Node::find($nodeId);
        $availableNodeTypes = NodeType::all()->where('parent_id', '=', $currentNode->type_id);

        return view('node.index', ['currentNode' => $currentNode,
                                        'nodes' => $nodes,
                                        'availableNodeTypes' => $availableNodeTypes]);
    }

    public function delete(Request $request, $nodeId)
    {
        $node = Node::find($nodeId);
        $node->delete();
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
