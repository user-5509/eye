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
        return $this->belongsToMany('App\NodeType', 'type2type', 'parent_id', 'child_id');
    }
}
