<?php

namespace App\Hardware\Objects;

use Illuminate\Database\Eloquent\Model;
use App\Common\UUID;
use App\Common\ObjIndex;
use App\Hardware\Interfaces\IPair;

class Pair extends Model
{
    protected $table = 'obj_pairs';

    public function __construct($name = 'пара')
    {
        parent::__construct();
        $this->uuid = UUID::v4();
        $this->name = $name;
        $this->save();

        // Pair have 2 pins
        $this->interfaces()->saveMany([
            new IPair('канал'),
            new IPair('станция'),
        ]);
    }

    public function interfaces()
    {
        return $this->hasMany('IPair');
    }

    public function parent()
    {
        return $this->hasOne('ObjIndex', 'uuid');
    }

    public function connect(IPair $connectTo, LCrossPair $connectBy) {
        $this->connections[] = new Connection($connectTo, $connectBy);
    }
}
