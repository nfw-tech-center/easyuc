<?php

namespace SouthCN\EasyUC;

use AbelHalo\ApiProxy\ApiProxy;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;
use SouthCN\EasyUC\Services\UC;

class UserCenterApi
{
    protected $proxy;

    public function __construct()
    {
        $this->proxy = (new ApiProxy)->returnAsObject();
    }

    /**
     * 调取用户中心的「获取用户详细信息」接口
     *
     * @param  bool        $filterSiteApp  只保留开启了本应用的站点的列表
     * @param  array|null  $serviceAreas   筛选指定的服务区ID
     * @return object
     * @throws ApiFailedException
     */
    public function getUserDetail(bool $filterSiteApp = false, ?array $serviceAreas = null)
    {
        $url = config('easyuc.oauth.auth_url');

        /** @var object $response */
        $response = $this->proxy->post($url, [
            'access_token' => request('access_token'),
            'site_app_id' => $filterSiteApp ? config('easyuc.site_app_id') : null,
            'service_area_ids' => is_null($serviceAreas) ? null : implode(',', $serviceAreas),
        ]);

        if (empty($response->data)) {
            throw new ApiFailedException("调用 $url 接口失败");
        }

        return $response->data;
    }

    /**
     * 调用用户中心的统一登出接口
     *
     * @throws ApiFailedException
     * @throws ConfigUndefinedException
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
