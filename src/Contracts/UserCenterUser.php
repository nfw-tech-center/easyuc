<?php

namespace SouthCN\EasyUC\Contracts;

use SouthCN\EasyUC\OAuthData;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

interface UserCenterUser
{
    /**
     * 为指定的 UID 创建业务系统用户
     *
     * @param $uid
     * @return void
     */
    public function createByUid($uid);

    /**
     * 使用 OAuth 数据更新业务系统用户
     *
     * @param OAuthData $authdata
     * @return Authenticatable
     */
    public function update(OAuthData $authdata);

    /**
     * 根据 UID 确定业务系统是否存在此用户
     *
     * @param $uid
     * @return bool
     */
    public function exists($uid);
}
