<?php

namespace SouthCN\EasyUC\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use SouthCN\EasyUC\Repositories\User;

interface UserCenterUser
{
    /**
     * 使用 OAuth 数据同步业务系统用户
     *
     * @param User $oAuthUser
     * @return Authenticatable
     */
    public function sync(User $oAuthUser);
}
