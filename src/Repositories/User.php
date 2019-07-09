<?php

namespace SouthCN\EasyUC\Repositories;

/**
 * @property-read int    id
 * @property-read string name
 * @property-read string email
 * @property-read int    group
 * @property-read bool   super
 */
class User
{
    public $super;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;

        $this->super = ($this->group <= 1);
    }

    public function __get($name)
    {
        return $this->data->$name;
    }
}
