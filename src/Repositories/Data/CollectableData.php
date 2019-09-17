<?php

namespace SouthCN\EasyUC\Repositories\Data;

abstract class CollectableData
{
    public $data;

    public function __construct(?array $data)
    {
        $this->data = is_null($data) ? [] : $data;
    }

    public function has($id): bool
    {
        return false !== array_search($id, $this->ids());
    }

    public function ids(): array
    {
        return array_pluck($this->data, 'id');
    }

    public function isNotEmpty(): bool
    {
        return count($this->data) > 0;
    }
}
