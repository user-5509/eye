<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EyeConfig extends Model
{
    protected $table = 'eye_config';

    public function set($name, $value = '')
    {
        if (!isset($name)) {
            Log::put($this, '$name - not set!');
            return null;
        }

        $this->where('name', '=', $name);

        $this->name = $name;
        $this->value = $value;
        $this->save();

        return $this;
    }

    public function get($name)
    {
        if (!isset($name)) {
            Log::put($this, '$name not set');
            return null;
        }

        $record =  $this->where('name', '=', $name);
        if($record !== null) {
            return $this->value;
        }
        else {
            return null;
        }
    }
}
