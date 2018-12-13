<?php

namespace Abel\EasyUC\Controllers;

use Abel\EasyUC\Contracts\UserCenterUser;
use Abel\EasyUC\OAuthData;
use AbelHalo\ApiProxy\ApiProxy;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    protected $proxy;

    public function __construct()
    {
        $this->proxy = (new ApiProxy)->setReturnAs('object');
    }

    /**
     * 处理OAuth回调
     */
    public function obtainToken()
    {
        Auth::login($this->syncUser());

        return redirect(config('easyuc.oauth.redirect_url'));
    }

    protected function syncUser()
    {
        /** @var UserCenterUser $user */
        $user               = app(UserCenterUser::class);
        $switchToDetailInfo = config('easyuc.oauth.switch_to_detail_info', false);
        $auth               = new OAuthData($this->getOAuthInfo(), $switchToDetailInfo);

        if (!$user->exists($auth->id)) {
            if (!$auth->super) {
                exit('管理中心未授权此用户');
            }

            // 超管不受限
            $user->createByUid($auth->id);
        }

        return $user->update($auth);
    }

    protected function getOAuthInfo()
    {
        $url = config('easyuc.oauth.auth_url');

        /** @var \stdClass $oauthResponse */
        $oauthResponse = $this->proxy->post($url, [
            'access_token' => request('access_token'),
        ]);

        if (empty($oauthResponse->data)) {
            exit("调用 $url 接口失败");
        }

        return $oauthResponse->data;
    }
}
