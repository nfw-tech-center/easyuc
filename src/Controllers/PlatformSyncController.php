<?php

namespace SouthCN\EasyUC\Controllers;

use Illuminate\Routing\Controller;
use SouthCN\EasyUC\PlatformResponse;
use SouthCN\EasyUC\Repositories\Data\User;
use SouthCN\EasyUC\Repositories\UserCenterAPI;

class PlatformSyncController extends Controller
{
    public function syncUser(UserCenterAPI $ucAPI)
    {
        $userHandler = app('easyuc.user.handler');

        foreach ($ucAPI->getUserList() as $data) {
            $userHandler->syncUser(new User($data->user));
        }

        return new PlatformResponse(0, 'ok');
    }
}
