<?php

namespace App\Http\Controllers;


use App\Node;
use App\NodeProperties;
use App\NodeType;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\CssSelector\XPath\Extension\NodeExtension;


class NodeController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createNodeAvailableTypesDropdown(Request $request)
    {
        $nodeId = Input::get('nodeId');
        $typeId = (new Node)->find($nodeId)->type->id;
        $parentIdList = [$typeId];
        $subTypes = (new NodeType)->whereHas('parents', function($query) use($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();
        return view('content.node.available-types-dropdown', ['nodeId' => $nodeId, 'subTypes' => $subTypes]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createNodeModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeTypeId = Input::get('nodeTypeId');
            $nodeTypeName = (new NodeType)->find($nodeTypeId)->name;
            $parentNodeId = Input::get('parentNodeId');

            return view('content.node.create-modal', ['nodeTypeId' => $nodeTypeId, 'nodeTypeName' => $nodeTypeName, 'parentNodeId' => $parentNodeId]);
        }
        else
            return null;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createNodeExecute(Request $request)
    {
        if ($request->ajax()) {
            $node = new Node();
            $node->init($request->input('nodeName'),
                        $request->input('nodeTypeId'),
                        $request->input('parentNodeId'));

            return 1;
        }
        else
            return "1212121221";
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteNodeModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $nodeName = (new Node)->find($nodeId)->name;

            return view('content.node.delete-modal', ['nodeId' => $nodeId, 'nodeName' => $nodeName]);
        }
        else
            return null;
    }

    /**
     * @param Request $request
     * @param $nodeId
     */
    public function deleteNodeExecute(Request $request, $nodeId)
    {
        $node = (new Node)->find($nodeId);
        $node->delete();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function nodeCrossModal(Request $request)
    {
        if ($request->ajax()) {
            return view('content.node.cross-modal');
        }
        else
            return null;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function crossNodeExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = $request->input('nodeId1');
            $nodeId2 = $request->input('nodeId2');
            $property = (new Node)->find($nodeId1)->properties()->where('name', 'stationLink' )->first();
            $property->value = $nodeId2;
            $property->save();
            $property = (new Node)->find($nodeId2)->properties()->where('name', 'channelLink' )->first();
            $property->value = $nodeId1;
            $property->save();

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
    public function index(Request $request, $nodeId = 1)
    {
        $request->session()->put('currentNodeId', $nodeId);
        $currentNode = (new Node)->find($nodeId);
        $nodes = Node::all()->where('parent_id', '=', $nodeId);
        $parentIdList = [$currentNode->type_id];
        $availableNodeTypes = (new NodeType)->whereHas('parents', function($query) use($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();

        return view('node.index', ['currentNode' => $currentNode,
                                        'nodes' => $nodes,
                                        'availableNodeTypes' => $availableNodeTypes]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTreeData(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');
        $nodes = Node::all()->where('parent_id', '=', $parentNodeId);
        $arr = array();
        foreach ($nodes as $node) {
            $tmpArr = array("title" => $node->fullName(), "key" => $node->id);
            $subNodesCount = (new Node)->where('parent_id', '=', $node->id)->count();
            if($subNodesCount > 0) {
                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }
            $arr[] = $tmpArr;
        }
        return json_encode($arr);
    }



    public function parent($id)
    {
        return (new Node)->find($id)->parent;
    }

    public function create($parentNodeId, $nodeTypeId)
    {
        $nodeType = (new NodeType)->find($nodeTypeId);
        return view('node.create', ['parentNodeId' => $parentNodeId,
            'nodeType' => $nodeType]);
    }



}
