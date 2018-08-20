<?php

return [

    'route' => [
        // 暴露给用户中心的接口url前缀
        'prefix' => env('UC_PREFIX'),
    ],

    'oauth' => [
        // OAuth登录时的回调地址
        'auth_url'     => env('UC_OAUTH_URL'),

        // 登录成功后的跳转地址
        'redirect_url' => env('UC_OAUTH_REDIRECT', '/'),
    ],

];
