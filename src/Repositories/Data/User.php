<?php

namespace SouthCN\EasyUC\Repositories\Data;

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

    public function super(): bool
    {
        return $this->group <= 1;
    }

    public function __get($name)
    {
        return $this->data->$name;
    }
}
