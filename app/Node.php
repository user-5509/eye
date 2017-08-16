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

    public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        Node::created(function($node)
        {
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
        });
    }

}
