<?php

namespace App\Hardware\Interfaces;

use Illuminate\Database\Eloquent\Model;

class IPin extends Model
{
    use BaseInterface;

    protected $table = 'i_pins';

    public function interfaces()
    {
        return $this->hasMany('App\Hardware\Contact');
    }

    public function __construct($name = 'pin')
    {
        $this->name = $name;
        $this->save();
    }

    public function connect(IPin $connectTo, LCrossWire $connectBy) {
        $this->connections[] = new Connection($connectTo, $connectBy);
    }
}
