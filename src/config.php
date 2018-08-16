<?php

return [

    'route' => [
        'prefix' => 'api',
    ],

    'oauth' => [
        'auth_url'     => env('UC_OAUTH_URL'),
        'redirect_url' => env('UC_OAUTH_REDIRECT', '/'),
    ],

];
