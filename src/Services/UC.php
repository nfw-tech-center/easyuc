<?php

namespace SouthCN\EasyUC\Services;

use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Repositories\Signal;
use SouthCN\EasyUC\Repositories\TokenManager;

/**
 * Class UC
 *
 * @package SouthCN\EasyUC\Services
 * @deprecated
 */
class UC
{
    public static function signal(?string $token = null)
    {
        return new Signal(
            $token ?: static::token()->getLogout()
        );
    }
}
