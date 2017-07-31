<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nodes';

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
     * Get child nodes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany('App\Node', 'parent_id');
    }
}
