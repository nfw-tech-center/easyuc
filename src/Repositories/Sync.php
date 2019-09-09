<?php

namespace SouthCN\EasyUC\Repositories;

use SouthCN\EasyUC\Repositories\Data\SiteList;
use SouthCN\EasyUC\Repositories\Data\User;

class Sync
{
    protected $ucAPI;
    protected $userHandler;

    public function __construct()
    {
        $this->ucAPI       = new UserCenterAPI;
        $this->userHandler = app('easyuc.user.handler');
    }

    public function users(): void
    {
        foreach ($this->ucAPI->getUserList() as $data) {
            $user = $this->userHandler->syncUser(new User($data->user));

            // 同时用户信息的同时，必须同步用户的站点列表
            if (!empty($data->site_list)) {
                $this->userHandler->syncUserSites($user, new SiteList($data->site_list));
            }
        }
    }

    public function sites(): void
    {
        $this->userHandler->syncSites(
            $this->ucAPI->getSiteList()
        );
    }
}
