<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.11.2017
 * Time: 16:43
 */

namespace App\Common;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $table = 'connections';

    public function __construct($connectTo, $connectBy)
    {
        $this->name = $name;
        $this->save();
    }
}