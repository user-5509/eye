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

class Area extends Model
{
    protected $table = 'container_area';

    private $uuid;
    private $name;
    private $parentId;

    public function __construct($name, $parentId)
    {
        parent::__construct();
        $this->uuid = UUID::v4();
        $this->name = $name;
        $this->parentId = $parentId;
        $this->save();
    }

    private function globalIndexRecord()
    {
        return $this->hasOne('GlobalIndex', 'uuid');
    }

    public function parent()
    {
        $parentClassName = $this->globalIndexRecord()->className;
        $parentUuid = $this->globalIndexRecord()->uuid;
        return (new $parentClassName)->where('uuid', '=', $parentUuid);
    }
}