<?php

use Illuminate\Support\Facades\Route;
use SouthCN\EasyUC\Middleware\TrustUserCenterIP;

Route::prefix(config('easyuc.route.prefix'))->group(function () {

    Route::middleware('web')->group(function () {
        // 统一登入
        Route::get('uc/obtain-token', 'SouthCN\EasyUC\Controllers\PlatformOAuthController@login');

        // 统一登出
        Route::middleware(TrustUserCenterIP::class)
             ->any('uc/logout', 'SouthCN\EasyUC\Controllers\PlatformOAuthController@logout');

        // 被动同步
        Route::middleware(TrustUserCenterIP::class)
             ->post('uc/sync-user', 'SouthCN\EasyUC\Controllers\PlatformSyncController@syncUser');
    });

});
