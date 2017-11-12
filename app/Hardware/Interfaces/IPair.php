<?php

namespace App\Hardware\Interfaces;

use Illuminate\Database\Eloquent\Model;

class IPair extends Model
{
    use BaseInterface;

    protected $table = 'int_pairs';

    public function __construct($name)
    {
        parent::__construct();

        $this->name = $name;

        $this->save();
    }

    public function connectedTo()
    {
        return $this->hasOne('App\Hardware\IPair');
    }

    public function connectedBy()
    {
        return $this->hasOne('App\Links\LCrossPair');
    }

    public function connect(IPair $connectTo, LCrossPair $connectBy)
    {
        if($connectBy === null) {
            $connectBy = new \LCrossPair();
        }

        $this->connectedTo()->save($connectTo);
        $this->connectedBy()->save($connectBy);
    }
}
