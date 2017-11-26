<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    const WORLD  = 1;
    const BUILDING  = 2;
    const ROOM      = 3;
    const PSP       = 4;
    const COMMON_BOX_60   = 5;
    const PAIR      = 6;
    const CRONE_BOX_100  = 7;
    const SPM       = 8;
    const BOARD_CS  = 9;
    const BOARD_CSS  = 10;
    const CROSS_ENCLOSURE  = 11;
    const CROSS_BOX  = 12;
    const TELCO_ENCLOSURE  = 14;
    const CRONE_RACK  = 15;
    const CRONE_BOX_10  = 16;
    const PATCH_PANEL_24  = 17;

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
        return $this->belongsToMany('App\NodeType', 'node_types_node_types', 'child_id',
            'parent_id');
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return Model|null|static
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function getIcon()
    {
        return $this->icon;
    }
}
