<?php

namespace SouthCN\EasyUC\Repositories;

/**
 * @property-read int    id
 * @property-read string name
 * @property-read string email
 * @property-read int    group
 */
class User
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        return $this->data->$name;
    }
}
