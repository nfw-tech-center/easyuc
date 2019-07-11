<?php

namespace SouthCN\EasyUC\Repositories\Data;

class ServiceAreaList
{
    public $data;

    public function __construct(?array $data)
    {
        $this->data = is_null($data) ? [] : $data;
    }

    public function ids(): array
    {
        return array_pluck($this->data, 'id');
    }
}
