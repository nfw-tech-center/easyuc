<?php

namespace SouthCN\EasyUC\Repositories;

use Illuminate\Support\Facades\Cache;

class TokenManager
{
    protected $key;

    /**
     * TokenManager constructor.
     *
     * @param string $uid 用户中心UID
     */
    public function __construct(string $uid)
    {
        $this->key = "uc:$uid:token";
    }

    public function setLogout(string $token): void
    {
        Cache::forever($this->key, $token);
    }

    public function getLogout(): ?string
    {
        return Cache::get($this->key);
    }
}
