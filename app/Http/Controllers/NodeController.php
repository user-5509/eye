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
    public function index(Request $request)
    {
        $currentNode = (new Node)->find(1);
        $nodes = Node::all()->where('parent_id', '=', 1);
        $parentIdList = [$currentNode->type_id];
        $availableNodeTypes = (new NodeType)->whereHas('parents', function ($query) use ($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();
        $nodePath = session("nodePath", "");

        return view('content.node.index', [
            'title' => 'Структура',
            'currentNode' => $currentNode,
            'nodes' => $nodes,
            'availableNodeTypes' => $availableNodeTypes,
            'nodePath' => $nodePath]);
    }

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
        $subTypes = (new NodeType)->whereHas('parents', function ($query) use ($parentIdList) {
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
        } else
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
        } else
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
        } else
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

    public function crossNodeAvailableInterfacesDropdown(Request $request)
    {
        $nodeId = Input::get('nodeId');
        $interfaces = (new Node)->find($nodeId)->properties;

        return view('content.node.available-interfaces-dropdown', ['interfaces' => $interfaces]);
    }

    public function crossNodeAvailableInterfacesSelect(Request $request)
    {
        $nodeId = Input::get('nodeId');
        $interfaces = (new Node)->find($nodeId)->properties;

        return view('content.node.available-interfaces-select', ['interfaces' => $interfaces]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function crossModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $node = (new Node)->find($nodeId);

            $interfaceId = Input::get('interfaceId');
            $interface = $node->properties()->find($interfaceId);


            $lines = (new LineController)->getLines();

            return view('content.node.cross-modal', ['lines' => $lines, 'node' => $node, 'interface' => $interface]);
        } else
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

            $interfaceId1 = $request->input('interfaceId1');
            $interfaceId2 = $request->input('interfaceId2');


            $node1 = (new Node)->find($nodeId1);
            $node1Property = $node1->properties()->where('id', $interfaceId1)->first();
            $node1Property->value = $nodeId2;
            $node1Property->save();

            $node2 = (new Node)->find($nodeId2);
            $node2Property = $node2->properties()->where('id', $interfaceId2)->first();
            $node2Property->value = $nodeId1;
            $node2Property->save();

            $lineId = $request->input('lineId');

            if ($node1->line_id == null) {
                $node1->line_id = $lineId;
                $node1->save();
            }
            if ($node2->line_id == null) {
                $node2->line_id = $lineId;
                $node2->save();
            }
            return 1;
        } else
            return "1212121221";
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
            if ($subNodesCount > 0) {
                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }
            if ($node->type->id == 6) {
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
            if ($node->line <> null) {
                $line = $node->line;
            } else {
                $line = null;
            }
            return view('content.node.about', ['node' => $node, 'line' => $line]);
        } else
            return null;
    }

    public function removeLineBinding($lineId)
    {
        $nodes = Node::all()->where('line_id', '=', $lineId);
        foreach ($nodes as $node) {
            if ($node->line_id == $lineId) {
                $node->line_id = null;
                $node->save();

                $nodeProperty = $node->properties()->where('name', 'stationLink')->first();
                $nodeProperty->value = null;
                $nodeProperty->save();

                $nodeProperty = $node->properties()->where('name', 'channelLink')->first();
                $nodeProperty->value = null;
                $nodeProperty->save();
            }
        }
        return $nodes;
    }

    public function savePath(Request $request)
    {
        $nodePath = $request->input('nodePath');
        session(["nodePath" => $nodePath]);
    }


    public function menu(Request $request)
    {
        $nodeId = Input::get('nodeId');
        $callback = Input::get('callback');

        $typeId = (new Node)->find($nodeId)->type->id;
        $parentIdList = [$typeId];
        $subTypes = (new NodeType)->whereHas('parents', function ($query) use ($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();

        $arr = array();
        foreach ($subTypes as $type) {
            $type_id = $type->id;
            $arr['type'.$type->id] = array('name' => $type->name, 'icon' => 'add', 'callback' => $callback.'('.$type_id.')');
        }

        return json_encode($arr);
    }
}
