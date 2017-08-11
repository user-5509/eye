<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'node_types';

    /**
     * Get parent nodes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents()
    {
        return $this->belongsToMany('App\NodeType', 'type2type', 'child_id', 'parent_id');
    }

    private function getIdByName($name)
    {
        return NodeType::where('name', $name)->first();
    }
}
