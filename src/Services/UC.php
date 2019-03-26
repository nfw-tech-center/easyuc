<?php

namespace SouthCN\EasyUC\Services;

use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Repositories\Signal;
use SouthCN\EasyUC\Repositories\TokenManager;

class UC
{
    public static function signal(?string $token = null)
    {
        return new Signal(
            $token ?: static::token()->getLogout()
        );
    }

    public static function token()
    {
        return new TokenManager(
            Auth::user()->uuid
        );
    }
}
