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

        if ($this->type_id == (new NodeType)->getByName("Гребенка (60 пар)")->id) {
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
                    $subNode->type_id = $subType->getByName("Пара")->id;
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

        if ($this->type_id == (new NodeType)->getByName("Бокс (100 пар)")->id) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 100; $i++) {
                $subName = $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
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

        if ($this->type_id == (new NodeType)->getByName("Плата (КС)")->id) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
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
                $subNode->name = 'Гнездо №' . $i . ' (пр)';
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

        if ($this->type_id == (new NodeType)->getByName("Плата (СКС)")->id) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Пара")->id;
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
                $subNode->type_id = $subType->getByName("Пара")->id;
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

        if ($this->type_id == (new NodeType)->getByName("Бокс (кросс)")->id) {
            $property = new NodeProperty(array('name' => "massLinkedInterface", 'value' => null));
            $this->properties()->save($property);
            $this->save();

            for ($i = 1; $i <= 24; $i++) {
                $subName =  $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $subType->getByName("Пара")->id;
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
    public function fullName()
    {
        if($this->type->name == 'Пара') {
            $nodeName = $this->name;
            $fullName = "";

            $linkedNode1 = $this->getLinkedNodeByAlias('channel');
            if($linkedNode1) {
                $fullName .= '<small class="text-muted">' . $linkedNode1->parent->name . '-' . $linkedNode1->name . '</small>';
            }

            $fullName .= " &rArr; <b>".$this->name . "</b> &rArr; ";

            $linkedNode2 = $this->getLinkedNodeByAlias('station');
            if($linkedNode2) {
                $fullName .= '<small class="text-muted">' . $linkedNode2->parent->name . '-' . $linkedNode2->name . '</small>';
            }
            return $fullName;
        } else {
            return $this->name;
        }
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

    public function getPath()
    {
        $path = "";
        $curNode = $this->parent;
        while($curNode->parent <> null) {
            $path = $curNode->parent->name . "\\" . $path;
            $curNode = $curNode->parent;
        }
        return $path;
    }

    public function updateLine()
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
            $typeName = $this->type->name;
            if($typeName == 'Пара' ||
                $typeName == 'Бокс (кросс)' ||
                $typeName == 'Плата (СКС)' ||
                $typeName == 'Плата (КС)' ||
                $typeName == 'Бокс (кросс)' ||
                $typeName == 'Бокс (100 пар)' ||
                $typeName == 'Гребенка (60 пар)')
                return false;
            else
                return true;
        }
        return false;
    }

    public function canCross()
    {
        if($this->type <> null) {
            $typeName = $this->type->name;
            if($typeName == 'Пара') {
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
            $typeName = $this->type->name;
            if($typeName == 'Пара') {
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
            $typeName = $this->type->name;
            if($typeName <> 'Пара')
                return true;
        }
        return false;
    }

    public function canEdit()
    {
        if($this->type <> null) {
            $typeName = $this->type->name;
            if($typeName <> 'Пара')
                return true;
        }
        return false;
    }

    public function canMassLink()
    {
        if($this->type == null)
            return false;

        $typeName = $this->type->name;
        if($typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Плата (СКС)' &&
            $typeName <> 'Плата (КС)' &&
            $typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Бокс (100 пар)' &&
            $typeName <> 'Гребенка (60 пар)')
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

        $typeName = $this->type->name;
        if($typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Плата (СКС)' &&
            $typeName <> 'Плата (КС)' &&
            $typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Бокс (100 пар)' &&
            $typeName <> 'Гребенка (60 пар)')
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

        $typeName = $this->type->name;
        if($typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Плата (СКС)' &&
            $typeName <> 'Плата (КС)' &&
            $typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Бокс (100 пар)' &&
            $typeName <> 'Гребенка (60 пар)')
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

        $typeName = $this->type->name;
        if($typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Плата (СКС)' &&
            $typeName <> 'Плата (КС)' &&
            $typeName <> 'Бокс (кросс)' &&
            $typeName <> 'Бокс (100 пар)' &&
            $typeName <> 'Гребенка (60 пар)')
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

        $typeName = $this->type->name;
        if($typeName <> 'Пара')
            return null;

        $linkedInterfaceId = $this->properties()->where('alias', '=', $alias)->first()->value;

        return (new NodeProperty)->find($linkedInterfaceId);
    }

    public function getLinkedNodeByAlias($alias)
    {
        if($this->type == null)
            return null;

        $typeName = $this->type->name;
        if($typeName <> 'Пара')
            return null;

        $remoteInterfaceId = $this->properties()->where('alias', '=', $alias)->first()->value;

        //$remoteInterfaceId = (new NodeProperty)->find($localInterfaceId)->id;
        $remoteNode = (new Node)->whereHas('properties', function ($query) use ($remoteInterfaceId) {
            $query->where('id', '=', $remoteInterfaceId);
        })->first();

        return $remoteNode;
    }
}
