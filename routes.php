<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('easyuc.route.prefix'))->group(function () {

    Route::middleware('web')->group(function () {
        Route::get('uc/obtain-token', 'SouthCN\EasyUC\Controllers\PlatformOAuthController@login');
        Route::any('uc/logout', 'SouthCN\EasyUC\Controllers\PlatformOAuthController@logout');
    });

});
