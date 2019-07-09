<?php

return [

    'app' => env('UC_APP'),
    'ticket' => env('UC_TICKET'),

    // 对应用户中心 site_app 表的 id 字段值
    'site_app_id' => env('UC_SITE_APP_ID'),

    // 调试模式下不会校验 Private API 签名
    'debug' => env('UC_DEBUG', false),

    'route' => [
        // 暴露给用户中心的接口url前缀
        'prefix' => env('UC_PREFIX'),

        // 业务系统的登出路径
        'logout' => env('UC_LOGOUT_ROUTE'),
    ],

    'oauth' => [
        // 只保留开启了本应用的站点的列表
        'filter_site_app' => env('UC_OAUTH_FILTER_SITE_APP', true),

        // 用户中心服务器IP
        'ip' => env('UC_OAUTH_TRUSTED_IP'),

        // OAuth登入回调过程中的「获取用户详细信息」接口地址
        'auth_url' => env('UC_BASE_URL') . '/api/oauth/user/detail',

        // OAuth登出过程中的「子系统登出」接口地址
        'logout_url' => env('UC_BASE_URL') . '/usercenter/logout',

        // 登录成功后的跳转地址
        'redirect_url' => env('UC_OAUTH_REDIRECT', '/'),
    ],

];
