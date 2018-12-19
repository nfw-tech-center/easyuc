<?php

namespace SouthCN\EasyUC\Controllers;

use SouthCN\EasyUC\Contracts\UserCenterUser;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Exceptions\UnauthorizedException;
use SouthCN\EasyUC\OAuthData;
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
     * 处理 OAuth 回调
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ApiFailedException
     * @throws UnauthorizedException
     */
    public function obtainToken()
    {
        Auth::login($this->syncUser());

        return redirect(config('easyuc.oauth.redirect_url'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     * @throws ApiFailedException
     * @throws UnauthorizedException
     */
    protected function syncUser()
    {
        /** @var UserCenterUser $user */
        $user               = app(UserCenterUser::class);
        $switchToDetailInfo = config('easyuc.oauth.switch_to_detail_info', false);
        $auth               = new OAuthData($this->getOAuthInfo(), $switchToDetailInfo);

        if (!$user->exists($auth->id)) {
            if (!$auth->super) {
                throw new UnauthorizedException('管理中心未授权此用户');
            }

            // 超管不受限
            $user->createByUid($auth->id);
        }

        return $user->update($auth);
    }

    /**
     * 调取用户中心的“用户数据”接口
     *
     * @return object
     * @throws ApiFailedException
     */
    protected function getOAuthInfo()
    {
        $url = config('easyuc.oauth.auth_url');

        /** @var object $oauthResponse */
        $oauthResponse = $this->proxy->post($url, [
            'access_token' => request('access_token'),
        ]);

        if (empty($oauthResponse->data)) {
            throw new ApiFailedException("调用 $url 接口失败");
        }

        return $oauthResponse->data;
    }
}
