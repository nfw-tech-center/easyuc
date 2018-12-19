<?php

namespace SouthCN\EasyUC;

use SouthCN\EasyUC\Repositories\SiteAppMap;
use SouthCN\EasyUC\Repositories\User;

class Repository
{
    protected $data;

    /**
     * @throws Exceptions\ApiFailedException
     */
    public function __construct()
    {
        $this->data = (new UserCenterApi)->getUserDetailInfo();
    }

    /**
     * 判断用户是否超级管理员
     *
     * @return bool
     */
    public function super(): bool
    {
        return 0 === $this->user()->group;
    }

    /**
     * 按 ID 确认用户是否拥有 app 的权限
     *
     * @param $appId
     * @return bool
     */
    public function authorized($appId): bool
    {
        return $this->siteAppMap()->hasApp($appId);
    }

    /**
     * 从 detailinfo 接口解析出用户对象
     *
     * @return User
     */
    public function user(): User
    {
        return new User($this->data->user);
    }

    /**
     * 从 detailinfo 接口解析出站点-app权限表对象
     *
     * @return SiteAppMap
     */
    protected function siteAppMap(): SiteAppMap
    {
        return new SiteAppMap($this->data->user);
    }
}
