<?php

return [

    'app'    => env('UC_APP'),
    'ticket' => env('UC_TICKET'),

    // 调试模式下不会校验 Private API 签名
    'debug'  => env('UC_DEBUG', false),

    'route' => [
        // 暴露给用户中心的接口url前缀
        'prefix' => env('UC_PREFIX'),
    ],

    'oauth' => [
        // 使用用户中心（抽离后）的 detailinfo 接口
        'switch_to_detail_info' => env('UC_OAUTH_SWITCH_TO_DETAIL_INFO', false),

        // OAuth登入回调过程中的“获取用户信息”接口地址
        'auth_url'              => env('UC_OAUTH_URL'),

        // 登录成功后的跳转地址
        'redirect_url'          => env('UC_OAUTH_REDIRECT', '/'),
    ],

];
