<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/auth/login', 'Auth\\LoginAction');
    Route::post('/accounts/stylists/invite', 'Accounts\\Stylists\\InviteAction')->middleware('auth:api');
    Route::post('/accounts/stylists', 'Accounts\\Stylists\\CreateAction')->middleware('auth:api');
});
