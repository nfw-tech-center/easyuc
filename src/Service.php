<?php

namespace SouthCN\EasyUC;

use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Repositories\TokenManager;

class Service
{
    public static function token()
    {
        return new TokenManager(Auth::user()->uuid);
    }
}
