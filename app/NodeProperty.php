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


}
