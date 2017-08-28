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
            $node = new Node;
            $node->name = $request->input('nodeName');
            $node->type_id = $request->input('nodeTypeId');
            $node->parent_id = $request->input('parentNodeId');
            $node->save();

            if($node->type_id == (new NodeType)->getByName("Гребенка (60 пар)")->id) {
                $pairNamePrefixes = ["АБ", "ВГ", "ДЕ"];
                foreach ($pairNamePrefixes as $pairNamePrefix) {
                    for($i = 1; $i <= 20; $i++) {
                        $subName = $pairNamePrefix . $i;
                        $subNode = new Node;
                        $subNode->name = $subName;
                        $subType = new NodeType();
                        $subNode->type_id = $subType->getByName("Пара")->id;
                        $subNode->parent_id = $node->id;
                        $subNode->save();

                        $properties = array(
                            new NodeProperties(array('name' => "interface", 'value' => 0)),
                            new NodeProperties(array('name' => "interface", 'value' => 0))
                        );
                        $subNode->properties()->saveMany($properties);
                    }
                }
            }

            if($node->type_id == (new NodeType)->getByName("Бокс (100 пар)")->id) {
                for($i = 1; $i <= 100; $i++) {
                    $subName = $i;
                    $subNode = new Node;
                    $subNode->name = $subName;
                    $subType = new NodeType();
                    $subNode->type_id = $subType->getByName("Пара")->id;
                    $subNode->parent_id = $node->id;
                    $subNode->save();

                    $properties = array(
                        new NodeProperties(array('name' => 'hardLink', 'value' => null)),
                        new NodeProperties(array('name' => 'softLink', 'value' => null))
                    );
                    $subNode->properties()->saveMany($properties);
                }
            }

            if($node->type_id == (new NodeType)->getByName("Плата")->id) {
                for($i = 1; $i <= 30; $i++) {
                    $subName = $i;
                    $subNode = new Node;
                    $subNode->name = $subName;
                    $subType = new NodeType;
                    $subNode->type_id = $subType->getByName("Гнездо")->id;
                    $subNode->parent_id = $node->id;
                    $subNode->save();

                    $pair = new Node;
                    $pair->name = "Передача";
                    $pair->type_id = $subType->getByName("Пара")->id;
                    $pair->parent_id = $subNode->id;
                    $pair->save();

                    $properties = array(
                        new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                        new NodeProperties(array('name' => 'stationLink', 'value' => null))
                    );
                    $subNode->properties()->saveMany($properties);

                    $pair = new Node;
                    $pair->name = "Прием";
                    $pair->type_id = $subType->getByName("Пара")->id;
                    $pair->parent_id = $subNode->id;
                    $pair->save();

                    $properties = array(
                        new NodeProperties(array('name' => 'channelLink')),
                        new NodeProperties(array('name' => 'stationLink'))
                    );
                    $subNode->properties()->saveMany($properties);
                }
            }

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
            $tmpArr = array("title" => $node->name, "key" => $node->id);
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
