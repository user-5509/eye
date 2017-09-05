<?php

namespace App\Http\Controllers;


use App\Node;;
use App\NodeType;
use App\Line;
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
            $nodeId = Input::get('nodeId');
            $node = (new Node)->find($nodeId);
            if($node->line <> null){
                $lineId = $node->line->id;
                $lineName = $node->line->name;
            } else {
                $lineId = null;
                $lineName = "";
            }
            return view('content.node.cross-modal', ['lineId' => $lineId, 'lineName' => $lineName]);
        }
        else
            return null;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function crossExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = $request->input('nodeId1');
            $nodeId2 = $request->input('nodeId2');

            $node1 = (new Node)->find($nodeId1);
            $node1Property = $node1->properties()->where('name', 'stationLink' )->first();
            $node1Property->value = $nodeId2;
            $node1Property->save();

            $node2 = (new Node)->find($nodeId2);
            $node2Property = $node2->properties()->where('name', 'channelLink' )->first();
            $node2Property->value = $nodeId1;
            $node2Property->save();

            if($node1->line == null) {
                $line = new Line;
                $line->name = $request->input('lineName');
                $line->save();

                $node1->line()->associate($line);
                $node1->save();

                $node2->line()->associate($line);
                $node2->save();
            }
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
    public function index(Request $request)
    {
        $currentNode = (new Node)->find(1);
        $nodes = Node::all()->where('parent_id', '=', 1);
        $parentIdList = [$currentNode->type_id];
        $availableNodeTypes = (new NodeType)->whereHas('parents', function($query) use($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();

        return view('content.node.index', ['currentNode' => $currentNode,
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
        $nodes = Node::all()->sortBy('id')->where('parent_id', '=', $parentNodeId);
        $arr = array();
        foreach ($nodes as $node) {
            $tmpArr = array("title" => $node->fullName(), "key" => $node->id);
            $subNodesCount = (new Node)->where('parent_id', '=', $node->id)->count();
            if($subNodesCount > 0) {
                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }
            if($node->type->id == 6) {
                $tmpArr["about"] = "true";
            }
            $arr[] = $tmpArr;
        }
        return json_encode($arr);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getByLine($lineId)
    {
        $nodes = Node::all()->sortBy('id')->where('line_id', '=', $lineId);
            return $nodes;
    }

    public function parent($id)
    {
        return (new Node)->find($id)->parent;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function nodeAbout(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $node = (new Node)->find($nodeId);
            if($node->line <> null){
                $line = $node->line;
            } else {
                $line = null;
            }
            return view('content.node.about', ['node' => $node, 'line' => $line]);
        }
        else
            return null;
    }

}
