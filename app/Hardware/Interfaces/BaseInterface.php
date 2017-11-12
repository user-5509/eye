<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.11.2017
 * Time: 15:44
 */

namespace App\Hardware\Interfaces;


trait BaseInterface
{
    private $id;
    private $name;
    private $parentId;
    private $subInterfaces = [];
    private $connections = [];

    public function __construct($parentId) {
        $this->parentId = $parentId;
        $this->subInterfaces = null;
        $this->connections = null;
    }
}