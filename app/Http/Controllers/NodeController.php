<?php

namespace App\Http\Controllers;

use App\Node;
use App\NodeType;
use App\NodeProperty;
use App\Line;
use App\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\CssSelector\XPath\Extension\NodeExtension;
use DateTime;

class NodeController extends Controller
{
    public function index(Request $request)
    {
        $nodeId = Input::get('nodeId');

        if($nodeId)
            $nodePath = (new Node)->find($nodeId)->getKeyPath();
        else
            $nodePath = session("nodePath", "/2");

        return view('content.node.index', [
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
    public function     createNodeExecute(Request $request)
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
        $node1InterfaceAlias = Input::get('node1InterfaceAlias');


        $interfaces = (new Node)->find($nodeId)->properties;

        return view('content.node.available-interfaces-select', [
            'interfaces' => $interfaces,
            'node1InterfaceAlias' => $node1InterfaceAlias]);
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

            $node1InterfaceAlias = $interface->alias;

            if($node->line <> null)
                $predefinedLineId = $node->line->id;
            else
                $predefinedLineId = null;

            $lines = (new LineController)->getLines();

            return view('content.node.cross-modal', [
                'lines' => $lines,
                'node' => $node,
                'interface' => $interface,
                'predefinedLineId' => $predefinedLineId,
                'node1InterfaceAlias' => $node1InterfaceAlias]);
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


            return view('content.node.masslink-modal', [
                'node' => $node,
                'interfaceName' => $interfaceName,
                'interfaceAlias' => $interfaceAlias]);
        } else
            return null;
    }

    public function massLinkAvailableInterfacesSelect(Request $request)
    {
        $nodeId                 = Input::get('nodeId');
        $node1InterfaceAlias    = Input::get('node1InterfaceAlias');

        $node = (new Node)->find($nodeId);

        if(!$node->canMassLink())
            return;

        $availableMassLinkInterfaces = $node->availableMassLinkInterfaces();

        return view('content.node.available-interfaces-select', [
            'interfaces'            => $availableMassLinkInterfaces,
            'node1InterfaceAlias'   => $node1InterfaceAlias]);
    }

    public function select(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');

        $nodes = (new Node)->where('parent_id', '=', $parentNodeId)->orderBy('id')->get();

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

            $subNodes1 = (new Node)->where('parent_id', '=', $nodeId1)->orderBy('id')->get()->toArray();
            $subNodes2 = (new Node)->where('parent_id', '=', $nodeId2)->orderBy('id')->get()->toArray();

//            if (count($subNodes1) < count($subNodes2))
//                $count = count($subNodes1);
//            else
//                $count = count($subNodes2);

            $order1 = $request->input('order1');
            if($order1 == 0) {
                $step1 = 1;
            } else {
                $step1 = 2;
            }

            $order2 = $request->input('order2');
            if($order2 == 0) {
                $step2 = 1;
            } else {
                $step2 = 2;
            }

            $i = $startNodeNum1;
            $j = $startNodeNum2;
            $k = 0;
            //$count += $j;

            while( $k < $count ) {
                $subNode1 = $subNodes1[$i];
                $subNodeProperty1 = (new NodeProperty)->where('node_id', '=', $subNode1['id'])->where('alias', $interfaceAlias1)->first();

                $subNode2 = $subNodes2[$j];
                $subNodeProperty2 = (new NodeProperty)->where('node_id', '=', $subNode2['id'])->where('alias', $interfaceAlias2)->first();

                $subNodeProperty1->value = $subNodeProperty2->id;
                $subNodeProperty1->save();

                $subNodeProperty2->value = $subNodeProperty1->id;
                $subNodeProperty2->save();

                $i += $step1;
                $j += $step2;
                $k++;
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
            $nodeId1 = Input::get('nodeId');

            $node1 = (new Node)->find($nodeId1);

            $nodeName1 = $node1->name;

            $node2 = $node1->getMassLinkedNode();

            if($node2)
                $nodeId2 = $node2->id;
            else
                $nodeId2 = '';

            return view('content.node.massUnlink-modal', ['nodeId2' => $nodeId2, 'nodeName' => $nodeName1]);

        } else
            return null;
    }

    public function massUnlinkExecute(Request $request)
    {
        if ($request->ajax()) {

            $nodeId1 = $request->input('nodeId1');
            $nodeId2 = $request->input('nodeId2');

            $node1 = (new Node)->find($nodeId1);

            if($node1 == null)
                return;

            $interfaceAlias1 = $node1->getMassLinkAlias();

            if($interfaceAlias1 == null)
                return;

            $subNodes1 = (new Node)->where('parent_id', '=', $nodeId1)->get();

            foreach ($subNodes1 as $subNode1) {

                // firstly clear remote interface...
                $interface2 = $subNode1->getLinkedInterfaceByAlias($interfaceAlias1);

                if($interface2)
                    $interface2->setValue(null);

                // ...then local
                $interface1 = $subNode1->getInterfaceByAlias($interfaceAlias1);

                if($interface1)
                    $interface1->setValue(null);
            }

            $node1->setMassLink(null);

            $node2 = (new Node)->find($nodeId2);

            if($node2 <> null)
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

            $lines = (new LineController)->getLines();

            return view('content.node.decross-modal', [
                'node1' => $node1,
                'interface1' => $interface1,
                'node2' => $node2,
                'interface2' => $interface2,
                'lines' => $lines]);
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

            $line1Id = Input::get('line1Id');
            $line2Id = Input::get('line2Id');

            $newLine1Name = Input::get('newLine1Name');
            $newLine2Name = Input::get('newLine2Name');


            $node1 = (new Node)->find($nodeId1);
            $node1Interface = $node1->getInterfaceById($interfaceId1);
            $node1Interface->setValue(null);

            if($line1Id == -1) {

                (new Line)->create(['name' => $newLine1Name]); // create new line
            }
            else {

                if($node1->getLine()->id <> $line1Id ) {

                    $node1->setLine($line1Id);
                }
            }

            $node2 = (new Node)->find($nodeId2);
            $node2Interface = $node2->getInterfaceById($interfaceId2);
            $node2Interface->setValue(null);

            if($line2Id == -1) {

                $newLine = new Line;
                $newLine->name = $newLine2Name;
                $newLine->save();
                $node2->setLine($newLine->id);
            }
            else {

                if($node2->getLine()->id <> $line2Id ) {

                    $node2->setLine($line2Id);
                }
            }
        }
    }


    public function getTreeData(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');

        $arr = array();

        $order = (new Node)->find($parentNodeId)->getOrder();

        $nodes = (new Node)->select('id as key', 'name as title')->where('parent_id', '=', $parentNodeId)->orderBy($order)->get()->toJson();

        Log::put($nodes);

        return $nodes;

        foreach ($nodes as $node) {
,
            $tmpArr = array();

            $tmpArr["key"] = $node->id;
            $tmpArr["title"] = $node->name; //fullName();
            $tmpArr["type"] = $node->type->id;
            $tmpArr["_icon"] = $node->getIcon();

            $subNodesCount = (new Node)->where('parent_id', '=', $node->id)->count();

            if ($subNodesCount > 0) {

                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }

            $type = $node->getType();
            if ($type <> null) {

                if ($type->id == NodeType::PAIR) {

                    $tmpArr["about"] = "true";
                }
            }

            $line = $node->getLine();
            if ($line <> null) {

                $tmpArr["line"] = $line->id;
            }

            $tmpArr["canCreate"]    = $node->canCreate();
            $tmpArr["canEdit"]      = $node->canEdit();
            $tmpArr["canCross"]     = $node->canCross();
            $tmpArr["canDecross"]   = $node->canDecross();
            $tmpArr["canMassLink"]  = $node->canMassLink();
            $tmpArr["canMassUnlink"] = $node->canMassUnlink();
            $tmpArr["canDelete"]    = $node->canDelete();

            $arr[] = $tmpArr;
        };

        return json_encode($arr);
    }

    public function getTreeData1(Request $request)
    {
        $parentNodeId = Input::get('parentNodeId');

        $arr = array();

        $order = (new Node)->find($parentNodeId)->getOrder();

        $nodes = (new Node)->where('parent_id', '=', $parentNodeId)->orderBy($order)->get();
        //$nodes = (new Node)->where('parent_id', '=', $parentNodeId)->get();


        foreach ($nodes as $node) {

            $tmpArr = array();

            $tmpArr["key"] = $node->id;
            $tmpArr["title"] = $node->fullName();
            $tmpArr["_icon"] = $node->getIcon();

            $subNodesCount = (new Node)->where('parent_id', '=', $node->id)->count();

            if ($subNodesCount > 0) {

                $tmpArr["folder"] = "true";
                $tmpArr["lazy"] = "true";
            }

            $type = $node->getType();
            if ($type <> null) {

                if ($type->id == NodeType::PAIR) {

                    $tmpArr["about"] = "true";
                }
            }

            $line = $node->getLine();
            if ($line <> null) {

                $tmpArr["line"] = $line->id;
            }

            $tmpArr["canCreate"]    = $node->canCreate();
            $tmpArr["canEdit"]      = $node->canEdit();
            $tmpArr["canCross"]     = $node->canCross();
            $tmpArr["canDecross"]   = $node->canDecross();
            $tmpArr["canMassLink"]  = $node->canMassLink();
            $tmpArr["canMassUnlink"] = $node->canMassUnlink();
            $tmpArr["canDelete"]    = $node->canDelete();

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

        $arr = array();

        $interfaces = (new Node)->find($nodeId)->properties;

        foreach ($interfaces as $interface) {

            $interface_id = $interface->id;

            if($interface->value <> null)
                $disabled = true;
            else
                $disabled = false;

            $arr["interface".$interface_id] = array(
                "name"      => $interface->name,
                "icon"      => $interface->getIcon(),
                "disabled"  => $disabled,
                "callback"  => "function () { $callback($interface_id); }"
            );
        }
        $json = json_encode($arr);

        return json_encode($json);
    }

    public function contextSubMenuDecross(Request $request)
    {
        $callback = Input::get('callback');

        $nodeId = Input::get('nodeId');

        $node = (new Node)->find($nodeId);

        $massLinkedAlias = $node->parent->getMassLinkAlias();

        $arr = array();

        $interfaces = $node->properties;

        foreach ($interfaces as $interface) {

            $interface_id = $interface->id;

            if($interface->value == null || $interface->alias == $massLinkedAlias) {

                $disabled = true;

            } else {

                $disabled = false;
            }

            $arr["interface".$interface_id] = array(
                "name"      => $interface->name,
                "icon"      => $interface->getIcon(),
                "disabled"  => $disabled,
                "callback"  => "function () { $callback($interface_id); }"
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
                "icon" => $interface->getIcon(),
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

    public function getPath(Request $request)
    {
        if ($request->ajax()) {
            $nodeId = Input::get('nodeId');
            $path = "";
            $curNode = (new Node)->find($nodeId);
            while($curNode->type->id <> NodeType::_WORLD_) {
                $path = "/" . $curNode->id . $path;
                $curNode = $curNode->parent;
            }
            return $path;
        }
    }

}
