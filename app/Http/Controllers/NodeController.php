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
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $nodeId = 1)
    {
        $request->session()->put('currentNodeId', $nodeId);
        $currentNode = Node::find($nodeId);
        $nodes = Node::all()->where('parent_id', '=', $nodeId);
        $parentIdList = [$currentNode->type_id];
        $availableNodeTypes = NodeType::whereHas('parents', function($query) use($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();

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

            if($node->name == "Гребенка (60 пар)") {
                $pairNamePrefixes = ["АБ", "ВГ", "ДЕ"];
                foreach ($pairNamePrefixes as $pairNamePrefix) {
                    for($i = 1; $i <= 20; $i++) {
                        $pairName = $pairNamePrefix + $i;
                        $tmpNode = new Node;
                        $tmpNode->name = $pairName;
                        $tmpNode->type_id = NodeType::getIdByName("Пара");
                        $tmpNode->parent_id = $request->input('parentNodeId');
                        $tmpNode->save();

                    }
                }
            }


            return 1;
        }
        else
            return "1212121221";
    }

}
