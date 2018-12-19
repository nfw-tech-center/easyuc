<?php

namespace SouthCN\EasyUC;

use AbelHalo\ApiProxy\ApiProxy;
use SouthCN\EasyUC\Exceptions\ApiFailedException;

class UserCenterApi
{
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
        $response = (new ApiProxy)
            ->setReturnAs('object')
            ->post($url, [
                'access_token' => request('access_token'),
            ]);

        if (empty($response->data)) {
            throw new ApiFailedException("调用 $url 接口失败");
        }

        return $response->data;
    }
}
