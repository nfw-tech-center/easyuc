<?php

namespace SouthCN\EasyUC;

use SouthCN\EasyUC\Repositories\SiteAppMap;
use SouthCN\EasyUC\Repositories\User;
use SouthCN\EasyUC\Repositories\UserCenterApi;

class Repository
{
    public $data;

    /**
     * @throws Exceptions\ApiFailedException
     */
    public function __construct()
    {
        $this->data = (new UserCenterApi)->getUserDetail();
    }

    /**
     * 判断用户是否超级管理员
     */
    public function super(): bool
    {
        return 0 === $this->user()->group;
    }

    /**
     * 按 ID 确认用户是否拥有 app 的权限
     */
    public function authorized($appId): bool
    {
        return $this->siteAppMap()->hasApp($appId);
    }

    /**
     * 取logout token
     */
    public function logoutToken(): string
    {
        return $this->data->logout_token;
    }

    /**
     * 从 detailinfo 接口解析出用户对象
     */
    public function user(): User
    {
        return new User($this->data->user);
    }

    /**
     * 从 detailinfo 接口解析出站点-app权限表对象
     */
    public function siteAppMap(): SiteAppMap
    {
        return new SiteAppMap($this->data->site_list);
    }
}
