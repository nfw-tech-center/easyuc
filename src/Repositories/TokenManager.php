<?php

namespace SouthCN\EasyUC\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TokenManager
{
    public function setLogout(string $token): void
    {
        $uuid = optional(Auth::user())->uuid;

        Cache::forever("uc:$uuid:token", $token);
    }

    public function getLogout(): ?string
    {
        $uuid = optional(Auth::user())->uuid;

        return Cache::get("uc:{$uuid}:token");
    }
}
