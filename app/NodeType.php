<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    const _WORLD_  = 1;
    const COUNTRY  = 10;
    const DISTRICT  = 20;
    const REGION  = 30;
    const SETTLEMENT  = 40;
    const BUILDING = 50;
    const ORGANIZATION = 60;
    const ROOM      = 70;
    const PSP       = 100;
    const LEGACY_BOX   = 110;
    const CRONE_BOX_10  = 120;
    const CRONE_BOX_100  = 130;
    const SPM       = 140;
    const BOARD_CS  = 150;
    const BOARD_CSS  = 160;
    const PAIR      = 170;
    const CROSS_ENCLOSURE  = 180;
    const CROSS_BOX  = 190;
    const TELCO_ENCLOSURE  = 200;
    const CRONE_RACK  = 210;
    const PATCH_PANEL_24  = 220;
    const MODEM      = 170;
    const SWITCH      = 170;
    const ROUTER      = 170;



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
