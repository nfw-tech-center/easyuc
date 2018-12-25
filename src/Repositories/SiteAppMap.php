<?php

namespace SouthCN\EasyUC\Repositories;

use Illuminate\Support\Collection;

class SiteAppMap
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function hasApp(int $id): bool
    {
        return collect($this->data)
            ->pluck('app_list')// 提取每个站点的 app_list
            ->flatten(1)// 压缩结构
            ->pluck('id')// 提取 APP ID
            ->unique()// 排重
            ->flip()// 翻转 APP ID 为数组 key
            ->has($id);
    }

    public function sites(): Collection
    {
        return collect($this->data);
    }
}
