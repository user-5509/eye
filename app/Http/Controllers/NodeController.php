<?php

namespace App\Http\Controllers;


use App\Node;;
use App\NodeType;
use App\NodeProperty;
use App\Line;
use App\Log;
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
    public function editNodeModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $node = (new Node)->find($nodeId);
            return view('content.node.edit-modal', ['node' => $node]);
        } else
            return null;
    }

    public function editNodeExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = $request->input('nodeId');
            $node = (new Node)->find($nodeId);
            $node->name = $request->input('nodeName');
            $node->description = $request->input('nodeDescription');
            $node->save();
        }
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

        $nodePath = session("nodePath");
        $nodePathArray = explode('/', $nodePath);
        if(array_search($nodeId, $nodePathArray))
            session(["nodePath" => ""]);
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
            $node1Property->value = $interfaceId2;
            $node1Property->save();

            $node2 = (new Node)->find($nodeId2);
            $node2Property = $node2->properties()->where('id', $interfaceId2)->first();
            $node2Property->value = $interfaceId1;
            $node2Property->save();

            $lineId = $request->input('lineId');

            $node1->line_id = $lineId;
            $node1->save();
            $node1->updateLine();

            $node2->line_id = $lineId;
            $node2->save();
            $node2->updateLine();



            return 1;
        } else
            return "1212121221";
    }

    public function massLinkModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $node = (new Node)->find($nodeId);

            $interfaceAlias = Input::get('interfaceAlias');
            $interfaceName = (new NodeProperty)->where('alias', '=', $interfaceAlias)->first()->name;


            return view('content.node.masslink-modal', ['node' => $node, 'interfaceName' => $interfaceName, 'interfaceAlias' => $interfaceAlias]);
        } else
            return null;
    }

    public function massLinkAvailableInterfacesSelect(Request $request)
    {
        $nodeId = Input::get('nodeId');
        $node = (new Node)->find($nodeId);

        if(!$node->canMassLink())
            return;

        $availableMassLinkInterfaces = $node->availableMassLinkInterfaces();

        return view('content.node.available-interfaces-select', ['interfaces' => $availableMassLinkInterfaces]);
    }

    public function select(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');

        $nodes = (new Node)->where('parent_id', '=', $parentNodeId)->get();

        return view('content.node.select', ['nodes' => $nodes, 'counter' => 0]);
    }

    public function massLinkExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = $request->input('nodeId1');
            $nodeId2 = $request->input('nodeId2');

            $interfaceAlias1 = $request->input('interfaceAlias1');
            $interfaceAlias2 = $request->input('interfaceAlias2');

            $startNodeNum1 = $request->input('startNodeNum1');
            $startNodeNum2 = $request->input('startNodeNum2');
            $count = $request->input('count');

            $subNodes1 = (new Node)->where('parent_id', '=', $nodeId1)->get()->toArray();
            $subNodes2 = (new Node)->where('parent_id', '=', $nodeId2)->get()->toArray();

//            if (count($subNodes1) < count($subNodes2))
//                $count = count($subNodes1);
//            else
//                $count = count($subNodes2);

            $order = $request->input('order');
            if($order == 0) {
                $step = 1;
            } else {
                $step = 2;
            }

            $i = $startNodeNum1;
            $j = $startNodeNum2;
            //while( $i < count($subNodes1) && $j < count($subNodes2) ) {
            //for ($i = $start; $i < $count; $i += $step) {
            $count += $j;
            while( $j < $count ) {
                $subNode1 = $subNodes1[$i];
                $subNodeProperty1 = (new NodeProperty)->where('node_id', '=', $subNode1['id'])->where('alias', $interfaceAlias1)->first();

                $subNode2 = $subNodes2[$j];
                $subNodeProperty2 = (new NodeProperty)->where('node_id', '=', $subNode2['id'])->where('alias', $interfaceAlias2)->first();

                $subNodeProperty1->value = $subNodeProperty2->id;
                $subNodeProperty1->save();

                $subNodeProperty2->value = $subNodeProperty1->id;
                $subNodeProperty2->save();

                $i += $step;
                $j++;
            }
            $node1 = (new Node)->find($nodeId1);
            $node1->setMassLink($interfaceAlias1);
            $node2 = (new Node)->find($nodeId2);
            $node2->setMassLink($interfaceAlias2);
        }
    }

    public function massUnlinkModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $nodeName = (new Node)->find($nodeId)->name;

            return view('content.node.massUnlink-modal', ['nodeId' => $nodeId, 'nodeName' => $nodeName]);
        } else
            return null;
    }

    public function massUnlinkExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = $request->input('nodeId');
            $node1 = (new Node)->find($nodeId1);

            $interfaceAlias1 = $node1->getMassLink();
            if($interfaceAlias1 == null)
                return;

            $subNodes1 = (new Node)->where('parent_id', '=', $nodeId1)->get()->toArray();
            $subNodeProperty1 = (new NodeProperty)->where('node_id', '=', $subNodes1[0]['id'])->where('alias', $interfaceAlias1)->first();
            $subNodeProperty2 = (new NodeProperty)->find($subNodeProperty1->value);
            $subNode2 = (new Node)->find($subNodeProperty2->node_id);
            $subNodes2 = (new Node)->where('parent_id', '=', $subNode2->parent_id)->get()->toArray();
            $node2 = (new Node)->find($subNode2->parent_id);
            $interfaceAlias2 = $node2->getMassLink();

            if (count($subNodes1) < count($subNodes2))
                $count = count($subNodes1);
            else
                $count = count($subNodes2);

            for ($i = 0; $i < $count; $i++) {
                $subNode1 = $subNodes1[$i];
                $subNodeProperty1 = (new NodeProperty)->where('node_id', '=', $subNode1['id'])->where('alias', $interfaceAlias1)->first();

                $subNode2 = $subNodes2[$i];
                $subNodeProperty2 = (new NodeProperty)->where('node_id', '=', $subNode2['id'])->where('alias', $interfaceAlias2)->first();

                $subNodeProperty1->value = null;
                $subNodeProperty1->save();

                $subNodeProperty2->value = null;
                $subNodeProperty2->save();
            }

            $node1->setMassLink(null);
            $node2->setMassLink(null);
        }
    }

    public function decrossModal(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = Input::get('nodeId');
            $node1 = (new Node)->find($nodeId1);
            $interfaceId1 = Input::get('interfaceId');
            $interface1 = $node1->properties()->find($interfaceId1);

            $interface2 = (new NodeProperty)->find($interface1->value);
            $interfaceId2 = $interface2->id;
            $node2 = (new Node)->whereHas('properties', function ($query) use ($interfaceId2) {
                $query->where('id', '=', $interfaceId2);
            })->first();

            return view('content.node.decross-modal', ['node1' => $node1, 'interface1' => $interface1, 'node2' => $node2, 'interface2' => $interface2]);
        } else
            return null;
    }

    public function decrossExecute(Request $request)
    {
        if ($request->ajax()) {
            $nodeId1 = $request->input('nodeId1');
            $nodeId2 = $request->input('nodeId2');

            $interfaceId1 = $request->input('interfaceId1');
            $interfaceId2 = $request->input('interfaceId2');


            $node1 = (new Node)->find($nodeId1);
            $node1Property = $node1->properties()->where('id', $interfaceId1)->first();
            $node1Property->value = null;
            $node1Property->save();

            if(!$node1->haveConnections())
                $node1->line_id = null;

            $node2 = (new Node)->find($nodeId2);
            $node2Property = $node2->properties()->where('id', $interfaceId2)->first();
            $node2Property->value = null;
            $node2Property->save();

            if(!$node2->haveConnections())
                $node2->line_id = null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTreeData(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');

        $arr = array();

        $order = (new Node)->find($parentNodeId)->getOrder();
        $nodes = (new Node)->where('parent_id', '=', $parentNodeId)->orderBy($order)->get();
        foreach ($nodes as $node) {
            $tmpArr = array();

            //$line = (new Node)->find($node->id)->line;
            $line = $node->line;
            if($line <> null)
                $lineId = $line->id;
            else
                $lineId = null;

            $tmpArr["title"] = $node->fullName();
            $tmpArr["key"] = $node->id;

            $tmpArr["_icon"] = (new Node)->find($node->id)->getIcon();
            $tmpArr["_icon"] = $node->getIcon();

            $subNodesCount = (new Node)->where('parent_id', '=', $node->id)->count();
            if ($subNodesCount > 0) {
                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }
            if ($node->type->id == 6) {
                $tmpArr["about"] = "true";
            }

            $tmpArr["canCreate"] = $node->canCreate();
            $tmpArr["canCross"] = $node->canCross();
            $tmpArr["canDecross"] = $node->canDecross();
            $tmpArr["canDelete"] = $node->canDelete();
            $tmpArr["canEdit"] = $node->canEdit();
            $tmpArr["canMassLink"] = $node->canMassLink();
            $tmpArr["canMassUnlink"] = $node->canMassUnlink();

            $arr[] = $tmpArr;
        };
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


    public function contextSubMenuCreate(Request $request)
    {
        $callback = Input::get('callback');

        $nodeId = Input::get('nodeId');
        $typeId = (new Node)->find($nodeId)->type->id;
        $parentIdList = [$typeId];

        $subTypes = (new NodeType)->whereHas('parents', function ($query) use ($parentIdList) {
            $query->whereIn('id', $parentIdList);
        })->get();

        $arr = array();
        foreach ($subTypes as $type) {
            $type_id = $type->id;
            $arr["type".$type_id] = array(
                "name" => $type->name,
                "callback" => "function () { $callback($type_id); }"
            );
        }
        $json = json_encode($arr);

        return json_encode($json);
    }

    public function contextSubMenuCross(Request $request)
    {
        $callback = Input::get('callback');

        $nodeId = Input::get('nodeId');
        $interfaces = (new Node)->find($nodeId)->properties;

        $arr = array();
        foreach ($interfaces as $interface) {
            $interface_id = $interface->id;

            if($interface->value <> null)
                $disabled = true;
            else
                $disabled = false;

            $arr["interface".$interface_id] = array(
                "name" => $interface->name,
                "disabled" => $disabled,
                "callback" => "function () { $callback($interface_id); }"
            );
        }
        $json = json_encode($arr);

        return json_encode($json);
    }

    public function contextSubMenuDecross(Request $request)
    {
        $callback = Input::get('callback');

        $nodeId = Input::get('nodeId');
        $interfaces = (new Node)->find($nodeId)->properties;

        $arr = array();
        foreach ($interfaces as $interface) {
            $interface_id = $interface->id;

            if($interface->value == null)
                $disabled = true;
            else
                $disabled = false;

            $arr["interface".$interface_id] = array(
                "name" => $interface->name,
                "disabled" => $disabled,
                "callback" => "function () { $callback($interface_id); }"
            );
        }
        $json = json_encode($arr);

        return json_encode($json);
    }

    public function contextSubMenuMassLink(Request $request)
    {
        $callback = Input::get('callback');

        $nodeId = Input::get('nodeId');
        $availableMassLinkInterfaces = (new Node)->find($nodeId)->availableMassLinkInterfaces();

        $arr = array();
        foreach ($availableMassLinkInterfaces as $interface) {
            $interfaceAlias = $interface->alias;

            $arr["interface_".$interfaceAlias] = array(
                "name" => $interface->name,
                "callback" => "function () { $callback('$interfaceAlias'); }"
            );
        }
        $json = json_encode($arr);

        return json_encode($json);
    }

    public function getOrderedByLine($lineId)
    {
        $orderedNodes = array();
        $node = (new Node)->getFirstInLine($lineId);

        while($node <> null) {
            $orderedNodes[] = $node;
            $node = $node->getLinkedNodeByAlias('station');
        }

        return $orderedNodes;
    }

}
