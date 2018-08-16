<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('easyuc.route.prefix')], function () {
    Route::post('uc/users/list', 'Abel\EasyUC\Controllers\UserController@listUser');
    Route::post('uc/users/add', 'Abel\EasyUC\Controllers\UserController@addUser');
    Route::post('uc/users/delete', 'Abel\EasyUC\Controllers\UserController@destoryUser');
});
