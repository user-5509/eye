<?php
namespace App\Hardware\Interfaces;

use Illuminate\Database\Eloquent\Model;
use App\Hardware\Contact;

class Pin extends Model
{
    protected $table = 'pins';

    public function interfaces()
    {
        return $this->hasMany('App\Hardware\Contact');
    }

    public function __construct($name = 'pin')
    {
        $this->name = $name;
        $this->save();

        // Each pin have 2 contacts
        $this->interfaces()->saveMany([
            new Contact(),
            new Contact(),
        ]);
    }
}
