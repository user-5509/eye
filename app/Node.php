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

        if($this->type_id == (new NodeType)->getByName("Гребенка (60 пар)")->id) {
            $pairNamePrefixes = ["АБ", "ВГ", "ДЕ"];
            foreach ($pairNamePrefixes as $pairNamePrefix) {
                for($i = 1; $i <= 20; $i++) {
                    $subName = $pairNamePrefix . $i;
                    $subNode = new Node;
                    $subNode->name = $subName;
                    $subType = new NodeType();
                    $subNode->type_id = $subType->getByName("Пара")->id;
                    $subNode->parent_id = $this->id;
                    $subNode->save();

                    $properties = array(
                        new NodeProperties(array('name' => "channelLink", 'value' => null)),
                        new NodeProperties(array('name' => "stationLink", 'value' => null))
                    );
                    $subNode->properties()->saveMany($properties);
                }
            }
        }

        if($this->type_id == (new NodeType)->getByName("Бокс (100 пар)")->id) {
            for($i = 1; $i <= 100; $i++) {
                $subName = $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                    new NodeProperties(array('name' => 'stationLink', 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if($this->type_id == (new NodeType)->getByName("Плата (КС)")->id) {
            for($i = 1; $i <= 36; $i++) {

                // Передача
                $subName = 'Гнездо №'.$i.' (пер)';
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Гнездо")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $pair = new Node;
                $pair->name = "Канал";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                    new NodeProperties(array('name' => 'stationLink', 'value' => null))
                );
                $pair->properties()->saveMany($properties);

                $pair = new Node;
                $pair->name = "Станция";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink')),
                    new NodeProperties(array('name' => 'stationLink'))
                );
                $pair->properties()->saveMany($properties);

                // Прием
                $subName = 'Гнездо №'.$i.' (пр)';
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Гнездо")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $pair = new Node;
                $pair->name = "Канал";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                    new NodeProperties(array('name' => 'stationLink', 'value' => null))
                );
                $pair->properties()->saveMany($properties);

                $pair = new Node;
                $pair->name = "Станция";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink')),
                    new NodeProperties(array('name' => 'stationLink'))
                );
                $pair->properties()->saveMany($properties);
            }
        }

        if($this->type_id == (new NodeType)->getByName("Плата (СКС)")->id) {
            for($i = 1; $i <= 36; $i++) {

                // Передача
                $subName = 'Гнездо №'.$i.' (пер)';
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Гнездо")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $pair = new Node;
                $pair->name = "Канал";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                    new NodeProperties(array('name' => 'stationLink', 'value' => null))
                );
                $pair->properties()->saveMany($properties);

                $pair = new Node;
                $pair->name = "Станция 1";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink')),
                    new NodeProperties(array('name' => 'stationLink'))
                );
                $pair->properties()->saveMany($properties);

                $pair = new Node;
                $pair->name = "Станция 2";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink')),
                    new NodeProperties(array('name' => 'stationLink'))
                );
                $pair->properties()->saveMany($properties);

                // Прием
                $subName = 'Гнездо №'.$i.' (пр)';
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Гнездо")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $pair = new Node;
                $pair->name = "Канал";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink', 'value' => null)),
                    new NodeProperties(array('name' => 'stationLink', 'value' => null))
                );
                $pair->properties()->saveMany($properties);

                $pair = new Node;
                $pair->name = "Станция";
                $pair->type_id = $subType->getByName("Пара")->id;
                $pair->parent_id = $subNode->id;
                $pair->save();

                $properties = array(
                    new NodeProperties(array('name' => 'channelLink')),
                    new NodeProperties(array('name' => 'stationLink'))
                );
                $pair->properties()->saveMany($properties);
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
        return $this->hasMany('App\NodeProperties');
    }

    /**
     * @return mixed|string
     */
    public function fullName()
    {
        if($this->type->name == 'Пара') {
            $fullName = $this->name . " К:" . $this->properties()->where('name', 'channelLink' )->first()->value;
            $fullName .= ", С:" . $this->properties()->where('name', 'stationLink' )->first()->value;
            if($this->line <> null) {
                $fullName .= ", Линия:" . $this->line->name;
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
}
