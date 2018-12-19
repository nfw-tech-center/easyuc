<?php

namespace SouthCN\EasyUC\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Contracts\UserCenterUser;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Exceptions\UnauthorizedException;
use SouthCN\EasyUC\OAuthData;
use SouthCN\EasyUC\UserCenterApi;

class OAuthController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->api = new UserCenterApi;
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
        $auth               = new OAuthData($this->api->getUserDetailInfo(), $switchToDetailInfo);

        if (!$user->exists($auth->id)) {
            if (!$auth->super) {
                throw new UnauthorizedException('管理中心未授权此用户');
            }

            // 超管不受限
            $user->createByUid($auth->id);
        }

        return $user->update($auth);
    }
}
