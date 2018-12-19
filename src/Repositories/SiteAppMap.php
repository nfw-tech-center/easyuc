<?php

namespace SouthCN\EasyUC\Repositories;

class SiteAppMap
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function hasApp($id)
    {
        dd($this->data);
    }
}
