<?php
namespace App\Hardware\Interfaces;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    public function link()
    {
        return $this->hasOne('App\Connections\Link');
    }
}
