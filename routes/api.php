<?php

Route::post('login', 'Api\LoginController@login');
Route::post('register', 'Api\RegisterController@register');
Route::post('roles', 'Api\RegisterController@roles');
Route::post('verifyphone','Api\RegisterController@verifyphone');
Route::post('resendotp','Api\RegisterController@resendotp');
Route::post('send-sms','Api\RegisterController@sendSms');
Route::post('verify-user','Api\SmsController@verifyContact');
Route::get('testfcm','Api\LoginController@testfcm');
Route::post('forgotpassword','Api\LoginController@forgotpassword');
Route::post('verifycode','Api\LoginController@verifycode');
Route::post('resetpassword','Api\LoginController@resetpassword');

Route::group(['middleware' => 'auth.jwt', 'namespace' => 'Api'], function () {
    //Route::get('logout', 'ApiController@logout');
    //Route::get('user', 'ApiController@getAuthUser');

    Route::get('refresh', 'RegisterController@refresh');
    Route::post('change-password','LoginController@changepassword');
    Route::post('logout', 'LoginController@logout');
    Route::apiResource('notifications', 'NotificationController');
    Route::post('readallnotification', 'NotificationController@updateall');
    Route::apiResource('stripeaccount', 'StripeController');
    
});

Route::group(['prefix' => 'v1', 'as' => 'admin.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::apiResource('permissions', 'PermissionsApiController');
    Route::apiResource('roles', 'RolesApiController');
    Route::apiResource('users', 'UsersApiController');
    Route::apiResource('products', 'ProductsApiController');
});
