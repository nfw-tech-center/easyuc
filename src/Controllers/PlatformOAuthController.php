<?php

namespace SouthCN\EasyUC\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Contracts\UserCenterUser;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;
use SouthCN\EasyUC\Exceptions\UnauthorizedException;
use SouthCN\EasyUC\PlatformResponse;
use SouthCN\EasyUC\Repository;
use SouthCN\EasyUC\Services\UC;

class PlatformOAuthController extends Controller
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * 处理平台 OAuth 回调，并实现统一登入
     *
     * @throws ApiFailedException
     * @throws UnauthorizedException
     * @throws ConfigUndefinedException
     */
    public function login()
    {
        Auth::login($this->syncUser());

        UC::token()->setLogout(
            $this->repository->logoutToken()
        );

        return redirect(config('easyuc.oauth.redirect_url'));
    }

    /**
     * 平台统一登出
     * 此方法由用户中心服务端调用，因此是处于***无状态环境***
     *
     * @param  Request  $request
     * @return PlatformResponse
     */
    public function acceptLogoutSignal(Request $request)
    {
        UC::signal($request->logout_token)->setLogout();

        return new PlatformResponse(0, 'ok');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     * @throws ApiFailedException
     * @throws UnauthorizedException
     * @throws ConfigUndefinedException
     */
    protected function syncUser()
    {
        // 初始化时就会调用 detailinfo 接口
        $this->repository = new Repository;

        /** @var UserCenterUser $user */
        $user = app(UserCenterUser::class);

        // 超管不受任何限制
        if ($this->repository->super()) {
            return $user->sync($this->repository);
        }

        $siteAppId = config('easyuc.site_app_id');

        if (!$siteAppId) {
            throw new ConfigUndefinedException('请配置UC_SITE_APP_ID');
        }

        // 非超管需要有 APP 授权
        if ($this->repository->authorized($siteAppId)) {
            return $user->sync($this->repository);
        }

        throw new UnauthorizedException('管理中心未授权此用户');
    }
}
