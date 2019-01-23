<?php

namespace SouthCN\EasyUC;

use AbelHalo\ApiProxy\ApiProxy;
use SouthCN\EasyUC\Exceptions\ApiFailedException;

class UserCenterApi
{
    protected $proxy;

    public function __construct()
    {
        $this->proxy = (new ApiProxy)->setReturnAs('object');
    }

    /**
     * 调取用户中心的“用户详细数据”接口
     *
     * @return object
     * @throws ApiFailedException
     */
    public function getUserDetailInfo()
    {
        $url = config('easyuc.oauth.auth_url');

        /** @var object $response */
        $response = $this->proxy->post($url, [
            'access_token' => request('access_token'),
        ]);

        if (empty($response->data)) {
            throw new ApiFailedException("调用 $url 接口失败");
        }

        return $response->data;
    }

    /**
     * 调用平台统一登出接口
     *
     * @throws ApiFailedException
     */
    public function logout(): void
    {
        $url = config('easyuc.oauth.logout_url');

        /** @var object $response */
        $response = $this->proxy->post($url, [
            'logout_token' => session('uc:token'),
        ]);

        if (0 !== $response->errcode) {
            throw new ApiFailedException("调用 $url 接口失败");
        }
    }
}
