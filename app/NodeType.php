<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    /**
     * Get parent node
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\NodeType', 'parent_id');
    }
}
