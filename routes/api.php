<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    //route login
    Route::post('/login', [
        App\Http\Controllers\Api\Admin\LoginController::class,
        'index'
    ]);
    //group route with middleware "auth"
    Route::group(['middleware' => 'auth:api'], function () {
        //data user
        Route::get(
            '/user',
            [App\Http\Controllers\Api\Admin\LoginController::class, 'getUser']
        );
        //refresh token JWT
        Route::get(
            '/refresh',
            [App\Http\Controllers\Api\Admin\LoginController::class, 'refreshToken']
        );
        //logout
        Route::post(
            '/logout',
            [App\Http\Controllers\Api\Admin\LoginController::class, 'logout']
        );
    });
    //Category
    Route::apiResource(
        '/pendaftarans',
        App\Http\Controllers\Api\Admin\PendaftaranController::class
    );
});
