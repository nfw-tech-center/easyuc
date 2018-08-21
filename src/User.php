<?php

namespace Abel\EasyUC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface User
{
    /**
     * 获取 UID 列表
     *
     * @return Collection|array
     */
    public function all();

    /**
     * 为指定的 UID 创建业务系统用户
     *
     * @param $uid
     * @return void
     */
    public function create($uid);

    /**
     * 根据 UID 删除业务系统用户
     *
     * @param $uid
     * @return void
     */
    public function destroy($uid);

    /**
     * 在 OAuth 过程中从用户中心同步用户数据到业务系统
     *
     * @param OAuthData $user
     * @return Model 业务系统的 User 模型
     */
    public function sync($user);
}
