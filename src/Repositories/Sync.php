<?php

namespace SouthCN\EasyUC\Repositories;

use SouthCN\EasyUC\Repositories\Data\User;

class Sync
{
    protected $ucAPI;

    public function __construct()
    {
        $this->ucAPI = new UserCenterAPI;
    }

    public function users(): void
    {
        $userHandler = app('easyuc.user.handler');

        foreach ($this->ucAPI->getUserList() as $data) {
            $userHandler->syncUser(new User($data->user));
        }
    }
}
