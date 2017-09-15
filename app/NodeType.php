<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    const BOX_60P = 0;
    const BOX_100P = 1;
    const SPM_BOARD = 2;

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
        switch($this->name) {

            case 'Пара' :
                $icon = "&#x02237;";
                break;

                default:
                $icon = null;
                break;
        }

        return $icon;
    }
}
