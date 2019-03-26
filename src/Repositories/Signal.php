<?php

namespace SouthCN\EasyUC\Repositories;

use Illuminate\Support\Facades\Cache;

class Signal
{
    protected $key;

    public function __construct(string $token)
    {
        $this->key = "uc:$token:logout";
    }

    public function setLogout(): void
    {
        Cache::forever($this->key, true);
    }

    public function checkLogout(): bool
    {
        return Cache::get($this->key, false);
    }

    public function unsetLogout(): void
    {
        Cache::forget($this->key);
    }
}
