<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'line_types';

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
