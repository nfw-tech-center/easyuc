<?php

namespace SouthCN\EasyUC\Repositories;

use AbelHalo\ApiProxy\ApiProxy;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Services\UC;

class UserCenterApi
{
    protected $proxy;

    public function __construct()
    {
        $this->proxy = (new ApiProxy)->returnAsObject();
    }

    /**
     * 用户中心「获取用户详细信息」接口
     *
     * @return object
     * @throws ApiFailedException
     */
    public function getUserDetail()
    {
        $url = config('easyuc.oauth.auth_url');

        /** @var object $response */
        $response = $this->proxy->post($url, [
            'access_token' => request('access_token'),
            'site_app_id' => config('easyuc.oauth.filter_site_app') ? config('easyuc.site_app_id') : null,
            'service_area_ids' => null,
        ]);

        if (empty($response->data)) {
            throw new ApiFailedException("调用 $url 接口失败");
        }

        return $response->data;
    }

    /**
     * 用户中心「统一登出」接口
     *
     * @throws ApiFailedException
     */
    public function logout(): void
    {
        $url = config('easyuc.oauth.logout_url');

        if (UC::signal()->checkLogout()) {
            // 被动登出情景下，无需再向用户中心通知登出
            UC::signal()->unsetLogout();

            return;
        }

        $token = UC::token()->getLogout();

        /** @var object $response */
        $response = $this->proxy->post($url, [
            'logout_token' => $token,
        ]);

        if (0 !== $response->errcode) {
            throw new ApiFailedException("调用 $url 接口失败：{$response->errmessage}（Token={$token}）");
        }
    }
}
