<?php

namespace Abel\EasyUC\Controllers;

use Abel\EasyUC\Contracts\User;
use Abel\EasyUC\Middleware\AuthenticateUserCenterRequests;
use Illuminate\Http\Request;

class UserController extends \Illuminate\Routing\Controller
{
    protected $user;

    public function __construct(User $user)
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
        $this->user->createByUid($request->uid);
    }

    public function destoryUser(Request $request)
    {
        $this->user->destroy($request->uid);
    }
}
