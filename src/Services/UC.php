<?php

namespace SouthCN\EasyUC\Services;

use SouthCN\EasyUC\Repositories\Signal;
use SouthCN\EasyUC\Repositories\TokenManager;

class UC
{
    public static function signal()
    {
        return new Signal(
            static::token()->getLogout()
        );
    }

    public static function token()
    {
        return new TokenManager;
    }
}
