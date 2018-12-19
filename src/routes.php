<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('easyuc.route.prefix')], function () {

    Route::group(['middleware' => 'web'], function () {
        Route::get('uc/obtain-token', 'Abel\EasyUC\Controllers\OAuthController@obtainToken');
    });

});
