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

    /**
     * @param $name
     * @return Model|null|static
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }
}
