<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.11.2017
 * Time: 13:24
 */

namespace App\Containers;

use Illuminate\Database\Eloquent\Model;
use App\Common\UUID;

class Country extends Model
{
    protected $table = 'container_country';

    private $uuid;
    private $name;
    private $parentId;

    public function __construct($name) {
        parent::__construct();
        $this->uuid = UUID::v4();
        $this->name = $name;
        $this->parentId = -1; // WORLD
        $this->save();
    }

    public function parent()
    {
        return $this->hasOne('GlobalIndex', 'uuid');
    }
}