<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lines';

    protected $fillable = array('name');

    function getName()
    {
        return $this->name;
    }
}
