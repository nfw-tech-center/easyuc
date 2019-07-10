<?php

namespace SouthCN\EasyUC\Repositories\Data;

class SiteList
{
    public $data;

    public function __construct(?array $data)
    {
        $this->data = is_null($data) ? [] : $data;
    }
}
