<?php

namespace SouthCN\EasyUC;

use SouthCN\EasyUC\Repositories\SiteAppMap;
use SouthCN\EasyUC\Repositories\User;
use SouthCN\EasyUC\Repositories\UserCenterApi;

/**
 * EasyUC Repository
 *
 * @property-read object data 接口原始数据
 * @property-read User   user 封装好的用户对象
 */
class Repository
{
    protected $data;
    protected $user;

    public function __construct()
    {
        $this->data = (new UserCenterApi)->getUserDetail();

        $this->user = new User($this->data->user);
    }

    /**
     * 确认用户拥有的站点中，是否拥有本应用的权限
     */
    public function authorized(): bool
    {
        return $this->siteAppMap()->hasApp();
    }

    /**
     * 取logout token
     */
    public function logoutToken(): string
    {
        return $this->data->logout_token;
    }

    /**
     * 从 detailinfo 接口解析出站点-app权限表对象
     */
    public function siteAppMap(): SiteAppMap
    {
        return new SiteAppMap($this->data->site_list);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
