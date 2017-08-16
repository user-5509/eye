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

            $type = new NodeType();

            if($node->type_id == $type->getByName("Гребенка (60 пар)")->id) {
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
                            new NodeProperties(array('name' => "hardLink", 'value' => null)),
                            new NodeProperties(array('name' => "softLink", 'value' => null))
                        );
                        $subNode->properties()->saveMany($properties);
                    }
                }
            }

            if($node->type_id == $type->getByName("Бокс (100 пар)")->id) {
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

            if($node->type_id == $type->getByName("Плата")->id) {
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

}
