<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'patient', 'namespace' => 'Api\v1\Patient'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/signup', 'AuthController@signup');
        Route::post('/login', 'AuthController@login');
        Route::post('/forgot_password', 'AuthController@forgotPassword');
        Route::post('/update_password', 'AuthController@updatePassword');
        Route::post('/resend_email_verification', 'AuthController@resendEmailVerification');
        Route::post('/signup_social', 'AuthController@signupSocial');
        Route::post('/logout', 'AuthController@logout');
    });
    Route::post('/profile', 'PatientsController@profile');
    Route::post('/update-profile', 'PatientsController@updateProfile');
    Route::post('/change-language', 'PatientsController@changeLanguage');

    Route::group(['prefix' => 'branch'], function () {
        Route::post('/list', 'BranchesController@branchesList');
        Route::post('/get', 'BranchesController@get');
    });

    Route::post('/termsAndPrivacy', 'CommonController@termsAndPrivacy');

    Route::group(['prefix' => 'notification'], function () {
        Route::post('/list', 'NotificationsController@list');
        Route::post('/mark-read', 'NotificationsController@markRead');
        Route::post('/check-new-notifications', 'NotificationsController@checkNewNotifications');
    });
});
