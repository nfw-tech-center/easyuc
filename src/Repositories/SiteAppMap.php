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

    public function hasApp(): bool
    {
        return collect($this->data)->count();
    }

    /**
     * 直接返回用户拥有的所有站点，无论是否有本应用权限
     */
    public function sites(): Collection
    {
        return collect($this->data);
    }

    /**
     * 返回用户开启了指定应用权限的站点
     */
    public function sitesWithAppPermission(int $app): Collection
    {
        return collect($this->data)
            // 排除未开启指定应用权限的站点
            ->reject(function ($site) use ($app) {
                return !collect($site->app_list)->pluck('id')->flip()->has($app);
            })
            // 去除数组数字键
            ->values();
    }
}
