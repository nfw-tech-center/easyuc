<?php

namespace SouthCN\EasyUC\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Contracts\UserCenterUser;
use SouthCN\EasyUC\Exceptions\ApiFailedException;
use SouthCN\EasyUC\Exceptions\UnauthorizedException;
use SouthCN\EasyUC\Repository;

class OAuthController extends Controller
{
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
        // 初始化时就会调用 detailinfo 接口
        $repository = new Repository;

        /** @var UserCenterUser $user */
        $user = app(UserCenterUser::class);

        // 超管不受任何限制
        if ($repository->super()) {
            return $user->sync($repository);
        }

        $siteAppId = config('easyuc.site_app_id');

        // 非超管需要有 APP 授权
        if ($repository->authorized($siteAppId)) {
            return $user->sync($repository);
        }

        throw new UnauthorizedException('管理中心未授权此用户');
    }
}
