<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('easyuc.route.prefix')], function () {
    Route::post('uc/users/list', 'AbelHalo\EasyUC\Controller@listUser');
    Route::post('uc/users/add', 'AbelHalo\EasyUC\Controller@addUser');
    Route::post('uc/users/delete', 'AbelHalo\EasyUC\Controller@destoryUser');
});
