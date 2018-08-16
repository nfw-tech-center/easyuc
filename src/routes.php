<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('easyuc.route.prefix')], function () {
    Route::post('uc/users/list', 'AbelHalo\EasyUC\Controllers\UserController@listUser');
    Route::post('uc/users/add', 'AbelHalo\EasyUC\Controllers\UserController@addUser');
    Route::post('uc/users/delete', 'AbelHalo\EasyUC\Controllers\UserController@destoryUser');
});
