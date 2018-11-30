<?php

namespace Abel\EasyUC\Controllers;

use Abel\EasyUC\Contracts\UserCenterUser;
use Abel\EasyUC\Middleware\AuthenticateUserCenterRequests;
use Abel\EasyUC\PlatformResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class UserController extends \Illuminate\Routing\Controller
{
    use ValidatesRequests;

    protected $user;

    public function __construct(UserCenterUser $user)
    {
        $this->middleware(AuthenticateUserCenterRequests::class);

        $this->user = $user;
    }

    public function listUser()
    {
        return $this->user->all();
    }

    public function addUser(Request $request)
    {
        $this->validate($request, ['uid' => 'required']);

        $this->user->createByUid($request->uid);

        return new PlatformResponse(0);
    }

    public function destoryUser(Request $request)
    {
        $this->validate($request, ['uid' => 'required']);

        $this->user->destroy($request->uid);

        return new PlatformResponse(0);
    }
}
