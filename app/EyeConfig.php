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

        $result = (new EyeConfig)->where('name', '=', $name)->first();
        if($result !== null) {
            $result->name = $name;
            $result->value = $value;
            $result->save();
        } else {
            $this->name = $name;
            $this->value = $value;
            $this->save();
        }

        return $this;
    }

    public function get($name)
    {
        if (!isset($name)) {
            Log::put($this, '$name not set');
            return null;
        }

        $result = $this->where('name', '=', $name)->first();
        if($result !== null) {
            return $result->value;
        }
        else {
            return null;
        }
    }
}
