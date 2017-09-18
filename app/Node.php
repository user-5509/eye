<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Node extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nodes';

    public function init($name, $typeId, $parentId)
    {
        $this->name = $name;
        $this->type_id = $typeId;
        $this->parent_id = $parentId;
        $this->save();

        if ( $this->type->id == NodeType::COMMON_BOX_60 ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            $pairNamePrefixes = ["АБ", "ВГ", "ДЕ"];
            foreach ($pairNamePrefixes as $pairNamePrefix) {
                for ($i = 1; $i <= 20; $i++) {
                    $subName = $pairNamePrefix . $i;
                    $subNode = new Node;
                    $subNode->name = $subName;
                    $subType = new NodeType();
                    $subNode->type_id = $this->type->id == NodeType::PAIR;
                    $subNode->parent_id = $this->id;
                    $subNode->save();

                    $properties = array(
                        new NodeProperty(array('name' => "Канал", 'alias' => "channel", 'value' => null)),
                        new NodeProperty(array('name' => "Станция", 'alias' => "station", 'value' => null))
                    );
                    $subNode->properties()->saveMany($properties);
                }
            }
        }

        if ( $this->type->id == NodeType::CRONE_BOX_100 ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 100; $i++) {
                $subName = $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ( $this->type->id == NodeType::BOARD_CS ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);

                // Прием
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пр)';
                $subType = new NodeType;
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ( $this->type->id == NodeType::BOARD_CSS) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция 1', 'alias' => "station1", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция 2', 'alias' => "station2", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);

                // Прием
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пр)';
                $subType = new NodeType;
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция 1', 'alias' => "station1", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция 2', 'alias' => "station2", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ( $this->type->id == NodeType::CROSS_BOX ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 24; $i++) {
                $subName =  $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => "Канал", 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => "Станция", 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ( $this->type->id == NodeType::CRONE_BOX_10 ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 10; $i++) {
                $subName = $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $this->type->id == NodeType::PAIR;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ( $this->type->id == NodeType::PATCH_PANEL_24 ) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 24; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Порт №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);

                // Прием
                $subNode = new Node;
                $subNode->name = 'Порт №' . $i . ' (пр)';
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperty(array('name' => 'Канал', 'alias' => "channel", 'value' => null)),
                    new NodeProperty(array('name' => 'Станция', 'alias' => "station", 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }
    }

    /**
     * Get node type
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\NodeType', 'type_id');
    }

    /**
     * Get node line
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function line()
    {
        return $this->belongsTo('App\Line', 'line_id');
    }

    /**
     * Get parent node
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Node', 'parent_id');
    }

    /**
     * Get propertys
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\NodeProperty');
    }

    /**
     * @return mixed|string
     */
    public function fullName($lineId = null)
    {
        if($this->line <> null) {
            //$lineName = (new Line)->find($lineId)->getName();
            $lineName = $this->line->getName();
            $tooltip = " data-toggle=\"tooltip\" data-placement=\"top\" title=\"$lineName\"";
            $badge = "<span class=\"badge badge-success\">$lineName</span>";
        }
        else {
            $tooltip = "";
            $badge = "";
        }

        if($this->type->id == NodeType::PAIR) {
            $nodeName = $this->name;
            $fullName = "<span>";

            $linkedNode1 = null; //$this->getLinkedNodeByAlias('channel');
            if($linkedNode1) {
                $fullName .= '<small class="text-muted">' . $linkedNode1->parent->name . '-' . $linkedNode1->name . '</small>';
            }

            $fullName .= " &rArr; <b>".$nodeName. "</b> &rArr; ";

            $linkedNode2 =  null; //$this->getLinkedNodeByAlias('station');
            if($linkedNode2) {
                $fullName .= '<small class="text-muted">' . $linkedNode2->parent->name . '-' . $linkedNode2->name . '</small>';
            }

            $fullName .= "</span>   $badge";

            return $fullName;
        } else {
            $nodeDescription = $this->description;
            if($nodeDescription <> null) {
                $nodeName = $this->name;
                $fullName = "$nodeName  <small class=\"text-muted\">($nodeDescription)</small>";
                return $fullName;
            }

        }
        return $this->name;
    }

    public function nameWithParent()
    {
        if($this->type->name == 'Пара') {
            $name = $this->parent->name . "-" . $this->name;
        } else {
            $name =  $this->name;
        }
        return $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPath()
    {
        $path = "";
        $curNode = $this->parent;
        while($curNode->parent->type->id <> NodeType::_WORLD_) {
            $path = $curNode->parent->name . " \\ " . $path;
            $curNode = $curNode->parent;
        }
        return $path;
    }

    public function setLine()
    {
        $hasLine = 0;
        foreach ($this->properties as $property) {
            $crossedNodeId = $property->value;
            if($crossedNodeId <> null) {
                $crossedNode = (new Node)->find($crossedNodeId);
                if ($crossedNode->line_id <> null) {
                    $hasLine = 1;
                    break;
                }
            }
        }
        if($hasLine == 0) {
            $this->line_id = null;
            $this->save();
        }
    }

    public function canCreate()
    {
        if($this->type <> null) {
            $typeId = $this->type->id;
            if($typeId == NodeType::PAIR ||
                $typeId == NodeType::CRONE_BOX_10 ||
                $typeId == NodeType::BOARD_CSS ||
                $typeId == NodeType::BOARD_CS ||
                $typeId == NodeType::CROSS_BOX ||
                $typeId == NodeType::CRONE_BOX_100 ||
                $typeId == NodeType::COMMON_BOX_60)
                return false;
            else
                return true;
        }
        return false;
    }

    public function canCross()
    {
        if($this->type <> null) {
            $typeId = $this->type->id;
            if($typeId == NodeType::PAIR) {
                $cnt = $this->properties()->where('value', null)->count();
                if($cnt > 0)
                    return true;
            }
        }
        return false;
    }
    public function canDecross()
    {
        if($this->type <> null) {
            $typeId = $this->type->id;
            if($typeId == NodeType::PAIR) {
                $cnt = $this->properties()->where('value', '<>',null)->count();
                if($cnt > 0)
                    return true;
            }
        }
        return false;
    }

    public function canDelete()
    {
        if($this->type <> null) {
            $typeId = $this->type->id;
            if($typeId <> NodeType::PAIR)
                return true;
        }
        return false;
    }

    public function canEdit()
    {
        if($this->type <> null) {
            $typeId = $this->type->id;
            if($typeId <> NodeType::PAIR)
                return true;
        }
        return false;
    }

    public function canMassLink()
    {
        if($this->type == null)
            return false;

        $typeId = $this->type->id;
        if($typeId == NodeType::CROSS_BOX &&
            $typeId == NodeType::BOARD_CSS &&
            $typeId == NodeType::BOARD_CS &&
            $typeId == NodeType::CRONE_BOX_100 &&
            $typeId == NodeType::CRONE_BOX_10 &&
            $typeId == NodeType::COMMON_BOX_60)
            return false;

        //$massLinkedInterface = $this->properties()->where('name', '=', 'massLinkedInterface')->first();
        //if($massLinkedInterface == null)
        //    return false;

        //if($massLinkedInterface->alias <> null)
        //    return false;


        return true;
    }

    public function canMassUnlink()
    {
        if($this->type == null)
            return false;

        $typeId = $this->type->id;
        if($typeId <> NodeType::CROSS_BOX &&
            $typeId <> NodeType::BOARD_CSS &&
            $typeId <> NodeType::BOARD_CS &&
            $typeId <> NodeType::CRONE_BOX_100 &&
            $typeId <> NodeType::CRONE_BOX_10 &&
            $typeId <> NodeType::COMMON_BOX_60)
            return false;

        $massLinkedInterface = $this->properties()->where('name', '=', 'massLinkedInterface')->first();
        if($massLinkedInterface == null)
            return false;

        if($massLinkedInterface->alias <> null)
            return true;


        return false;
    }

    public function getMassLink()
    {
        if($this->type == null)
            return null;

        $typeId = $this->type->id;
        if($typeId <> NodeType::CROSS_BOX &&
            $typeId <> NodeType::BOARD_CSS &&
            $typeId <> NodeType::BOARD_CS &&
            $typeId <> NodeType::CRONE_BOX_100 &&
            $typeId <> NodeType::CRONE_BOX_10 &&
            $typeId <> NodeType::COMMON_BOX_60)
            return null;

        $massLinkedInterface = $this->properties()->where('name', '=', 'massLinkedInterface')->first();
        if($massLinkedInterface == null)
            return null;

        return $massLinkedInterface->alias;
    }

    public function availableMassLinkInterfaces()
    {
        if($this->canMassLink()) {
            $subNode = (new Node)->where('parent_id', '=', $this->id)->first();
            return $subNode->properties;
        }
        else
            return null;
    }

    public function setMassLink($alias)
    {
        if($this->type == null)
            return 0;

        $typeId = $this->type->id;
        if($typeId <> NodeType::CROSS_BOX &&
            $typeId <> NodeType::BOARD_CSS &&
            $typeId <> NodeType::BOARD_CS &&
            $typeId <> NodeType::CRONE_BOX_100 &&
            $typeId <> NodeType::CRONE_BOX_10 &&
            $typeId <> NodeType::COMMON_BOX_60)
            return 0;

        $massLinkedInterface = $this->properties()->where('name', '=', 'massLinkedInterface')->first();
        if($massLinkedInterface == null)
            return 0;

        $massLinkedInterface->alias = $alias;
        $massLinkedInterface->save();

        return 1;
    }

    public function getLinkedInterfaceByAlias($alias)
    {
        if($this->type == null)
            return null;

        $typeId = $this->type->id;
        if($typeId <> NodeType::PAIR)
            return null;

        $linkedInterfaceId = $this->properties()->where('alias', '=', $alias)->first()->value;

        return (new NodeProperty)->find($linkedInterfaceId);
    }

    public function getLinkedNodeByAlias($alias)
    {
        if($this->type == null)
            return null;

        $typeId = $this->type->id;
        if($typeId <> NodeType::PAIR)
            return null;

        $remoteInterfaceId = $this->properties()->where('alias', '=', $alias)->first()->value;

        //$remoteInterfaceId = (new NodeProperty)->find($localInterfaceId)->id;
        $remoteNode = (new Node)->whereHas('properties', function ($query) use ($remoteInterfaceId) {
            $query->where('id', '=', $remoteInterfaceId);
        })->first();

        return $remoteNode;
}

    public function getOrder()
    {
        if($this->type == null)
            return 0;

        switch($this->type->id) {
            case NodeType::PSP :
                $order = "name";
                break;
            default:
                $order = "id";
                break;
        }

        return $order;
    }

    public function updateLine()
    {
        $interfaces = $this->properties()->where('value', '<>', null)->get();
        foreach($interfaces as $interface) {
            $remoteInterfaceId = $interface->value;
            $remoteNode = (new Node)->whereHas('properties', function ($query) use ($remoteInterfaceId) {
                $query->where('id', '=', $remoteInterfaceId);
            })->first();

            if(  $this->line_id <> null && $remoteNode->line_id <> $this->line_id) {
                $remoteNode->line_id = $this->line_id;
                $remoteNode->save();
                $remoteNode->updateLine();
            }
        }
    }

    public function haveConnections()
    {
        $interfaces = $this->properties()->where('value', '<>', null)->get();
        if($interfaces->count() > 0)
            return true;
        else
            return false;
    }

    public function getFirstInLine($lineId)
    {
        return $this->where('line_id', '=', $lineId)->whereHas('properties',
            function ($query)
            {
                $query->where('alias', '=', 'channel')->where('value', '=', null);
            })->first();
    }

    public function getIcon()
    {

        if($this->type == null)
            return null;

        return $this->type->getIcon();
    }
}
