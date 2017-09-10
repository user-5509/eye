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
                        new NodeProperties(array('name' => "Канал", 'value' => null)),
                        new NodeProperties(array('name' => "Станция", 'value' => null))
                    );
                    $subNode->properties()->saveMany($properties);
                }
            }
        }

        if ($this->type_id == (new NodeType)->getByName("Бокс (100 пар)")->id) {
            for ($i = 1; $i <= 100; $i++) {
                $subName = $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperties(array('name' => 'Канал', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция', 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ($this->type_id == (new NodeType)->getByName("Плата (КС)")->id) {
            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperties(array('name' => 'Канал', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция', 'value' => null))
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
                    new NodeProperties(array('name' => 'Канал', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция', 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ($this->type_id == (new NodeType)->getByName("Плата (СКС)")->id) {
            for ($i = 1; $i <= 36; $i++) {
                // Передача
                $subNode = new Node;
                $subNode->name = 'Гнездо №' . $i . ' (пер)';
                $subType = new NodeType;
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperties(array('name' => 'Канал', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция 1', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция 2', 'value' => null))
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
                    new NodeProperties(array('name' => 'Канал', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция 1', 'value' => null)),
                    new NodeProperties(array('name' => 'Станция 2', 'value' => null))
                );
                $subNode->properties()->saveMany($properties);
            }
        }

        if ($this->type_id == (new NodeType)->getByName("Бокс (кросс)")->id) {
            for ($i = 1; $i <= 24; $i++) {
                $subName =  $i;
                $subNode = new Node;
                $subNode->name = $subName;
                $subType = new NodeType();
                $subNode->type_id = $subType->getByName("Пара")->id;
                $subNode->parent_id = $this->id;
                $subNode->save();

                $properties = array(
                    new NodeProperties(array('name' => "Канал", 'value' => null)),
                    new NodeProperties(array('name' => "Станция", 'value' => null))
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
        return $this->hasMany('App\NodeProperties');
    }

    /**
     * @return mixed|string
     */
    public function fullName()
    {
        if($this->type->name == 'Пара') {
            $fullName = $this->name . " ";
            //$properties = $this->properties();
            foreach ($this->properties as $property) {
                $fullName .= ", " . $property->name . ": " . $property->value;
            }
            if($this->line <> null) {
                $fullName .= ", тракт: " . $this->line->name;
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
