<?php

namespace AbelHalo\EasyUC\Controllers;

use AbelHalo\EasyUC\User;
use Illuminate\Http\Request;

class UserController extends \Illuminate\Routing\Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function listUser()
    {
        return $this->user->all();
    }

    public function addUser(Request $request)
    {
        $this->user->create($request->uid);
    }

    public function destoryUser(Request $request)
    {
        $this->user->destory($request->uid);
    }
}
