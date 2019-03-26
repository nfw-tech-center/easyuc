<?php

namespace SouthCN\EasyUC\Repositories;

use Illuminate\Support\Facades\Cache;

class Signal
{
    public function setLogout(string $token): void
    {
        Cache::forever("uc:$token:logout", true);
    }

    public function checkLogout(string $token): bool
    {
        return Cache::get("uc:$token:logout", false);
    }

    public function unsetLogout(string $token): void
    {
        Cache::forget("uc:$token:logout");
    }
}
