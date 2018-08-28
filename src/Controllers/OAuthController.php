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
        $this->proxy = (new ApiProxy)->setReturnAs(ApiProxy::RETURN_AS_OBJECT);
    }

    public function obtainToken()
    {
        Auth::login($this->syncUser());

        return redirect(config('easyuc.oauth.redirect_url'));
    }

    protected function syncUser()
    {
        /** @var UserCenterUser $user */
        $user = app(UserCenterUser::class);
        $auth = new OAuthData($this->getOAuthInfo());

        return $user->exists($auth->id)
            ? $user->update($auth)
            : $user->create($auth);
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
