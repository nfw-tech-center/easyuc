<?php

namespace SouthCN\EasyUC\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use SouthCN\EasyUC\Repository;

interface UserCenterUser
{
    /**
     * 使用 OAuth 数据同步业务系统用户
     *
     * @param Repository $repository
     * @return Authenticatable
     */
    public function sync(Repository $repository);
}
