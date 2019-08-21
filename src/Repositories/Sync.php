<?php

namespace SouthCN\EasyUC\Repositories;

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
            $this->userHandler->syncUser(new User($data->user));
        }
    }

    public function sites(): void
    {
        $this->userHandler->syncSites(
            $this->ucAPI->getSiteList()
        );
    }
}
