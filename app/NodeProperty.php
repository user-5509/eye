<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NodeProperty extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'node_properties';

    protected $fillable = array('name', 'alias', 'value');

    public function setValue($value)
    {
        $this->value = $value;
        $this->save();
    }

    public function getIcon()
    {
        switch($this->alias) {
            case 'channel' :
                $icon = 'fa-arrow-left';
                break;
            case 'station' :
                $icon = 'fa-arrow-right';
                break;
            default:
                $icon = null;
        }

        return $icon;
    }
}
