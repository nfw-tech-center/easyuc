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
    protected $repository;

    /**
     * @throws ApiFailedException
     */
    public function __construct()
    {
        $this->repository = new Repository;
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
        $user = app(UserCenterUser::class);

        if ($this->repository->super()) {
            return $user->sync($this->repository->user());
        }

        if ($this->repository->authorized(1)) {
            return $user->sync($this->repository->user());
        }

        throw new UnauthorizedException('管理中心未授权此用户');
    }
}
