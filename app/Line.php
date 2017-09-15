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

    function getName()
    {
        return $this->name;
    }
}
