<?php

use Illuminate\Support\Facades\Route;

Route::post('uc/users/list', 'Controller@listUser');
Route::post('uc/users/add', 'Controller@addUser');
Route::post('uc/users/delete', 'Controller@destoryUser');
