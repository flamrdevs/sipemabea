<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Guest Route
Route::group(
    [
        // 'middleware' => 'guest'
    ],
    function() {
        Route::view('/', 'welcome')->name('welcome');

        Route::get('/register', 'AuthController@showRegisterForm')->name('register');
        Route::post('/register', 'AuthController@register');

        Route::group(
            ['prefix' => config('global.prefix-admin')],
            function () {
                Route::get('/login', 'AuthController@showLoginForm')->name('login');
                Route::post('/login', 'AuthController@login')->name('login.action');

                Route::get('/forpass', 'AuthController@showForgotPasswordForm')->name('forgot_password');
                Route::post('/forpass', 'AuthController@forgotPassword')->name('forgot_password.action');
                
                Route::get('/respass', 'AuthController@showResetPasswordForm')->name('reset_password');
                Route::post('/respass', 'AuthController@resetPassword')->name('reset_password.action');
            });

        Route::group(
            ['prefix' => 'submission'],
            function () {
                Route::name('submission')->group(function() {
                    Route::get('/', 'SubmissionController@guest_create');
                    Route::post('/', 'SubmissionController@guest_store')->name('.store');
                });
            });
    });

// Admin Route
Route::group(
    [
        'prefix' => config('global.prefix-admin'),
        'middleware' => 'auth',
    ],
    function() {
        Route::post('logout', 'AuthController@logout')->name('logout');

        Route::name('admin')->group(function() {

            Route::get('/', 'AdminController@index');

            Route::get('/site', 'SiteController@siteSettings')->name('.site');
            Route::post('/site', 'SiteController@siteUpdateSettings')->name('.site-update');

            Route::get('/schedules', 'AdminController@schedules')->name('.schedules');
            
            Route::get('/settings', 'AdminController@settings')->name('.settings');

            Route::group(
                ['prefix' => 'profile'],
                function () {
                    Route::get('/', 'AdminController@profile')->name('.profile');

                    Route::get('/edit', 'AdminController@showProfileUpdateForm')->name('.profile_update');
                    Route::put('/edit', 'AdminController@profileUpdate')->name('.profile_update.action');

                    Route::get('/edit-password', 'AdminController@showProfileUpdatePasswordForm')->name('.profile_update_password');
                    Route::put('/edit-password', 'AdminController@profileUpdatePassword')->name('.profile_update_password.action');
                });
            
            Route::group(
                ['prefix' => 'approvements'],
                function () {
                    Route::name('.approvements')->group(function() {
                        Route::get('/', 'ApprovementController@admin_index');
                        Route::get('/{id}', 'ApprovementController@admin_show')->name('.show');
                        Route::get('/preview-mail/{id}', 'ApprovementController@admin_previewApprovalMail')->name('.mail-preview');
                        Route::put('/send-mail/{id}', 'ApprovementController@admin_sendApprovalMail')->name('.mail_send');
                    });
                });
            
            Route::group(
                ['prefix' => 'submissions'],
                function () {
                    Route::name('.submissions')->group(function() {
                        Route::get('/', 'SubmissionController@admin_index');
                        Route::get('/{id}', 'SubmissionController@admin_show')->name('.show');
                        Route::get('/{id}', 'SubmissionController@admin_show')->name('.show');
                        Route::put('/{id}', 'SubmissionController@admin_update')->name('.update');
                    });
                });

        });
    });

// Download File
Route::get('/download/{location}', 'SiteController@download')->name('download');

// Localization
Route::get('/localize/{locale}', 'SiteController@setLocale')->name('localize');

// Fallback Route
Route::fallback('SiteController@pageNotFound');