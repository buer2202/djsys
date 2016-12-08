<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('admin.login');
});
Route::post('/checklogin', 'Admin\AdminController@checklogin');

Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('/admin/user', 'Admin\UserController@index');
    Route::post('/admin/user/recharge', 'Admin\UserController@recharge');
    Route::post('/admin/user/consume', 'Admin\UserController@consume');
    Route::post('/admin/user/info', 'Admin\UserController@info');

    Route::get('/admin/amountflow', 'Admin\AmountFlowController@index');

    Route::get('/admin/platform', 'Admin\PlatformController@index');

    Route::get('/admin/chpwd', function () {
        return view('admin.chpwd');
    });
    Route::post('/admin/changepassword', 'Admin\AdminController@changePassword');

    Route::get('/logout', function () {
        session()->flush();
        return redirect('/login');
    });
});

Route::group(['middleware' => 'auth.wechatweb'], function () {
    Route::get('/membercard', 'Home\WechatController@memberCard');
});