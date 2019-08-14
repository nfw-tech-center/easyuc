<?php

namespace SouthCN\EasyUC;

use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Repositories\LogoutSignal;
use SouthCN\EasyUC\Repositories\Sync;
use SouthCN\EasyUC\Repositories\TokenManager;

class Service
{
    public static function logoutSignal(?string $logoutToken = null)
    {
        if (is_null($logoutToken)) {
            $logoutToken = static::token()->logout;
        }

        return new LogoutSignal($logoutToken);
    }

    public static function token()
    {
        return new TokenManager(Auth::user()->uuid);
    }

    public static function sync()
    {
        return new Sync;
    }
}
