<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminActivityController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\UsersDashboardController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\UserAuthMiddleware;

Route::controller(AuthController::class)
    ->name('auth.')
    ->group(function () {
        // User login routes
        Route::get('/', 'usersLoginGet')->name('user.login');
        Route::post('/user/login', 'usersLoginPost')->name('user.login.post');

        // Admin login routes
        Route::get('/admin', 'adminsLoginGet')->name('admin.login');
        Route::post('/admin/login', 'adminsLoginPost')->name('admin.login.post');


        // Logout route
        Route::get('/user/logout', 'userLogout')->name('userLogout');
        Route::get('/admin/logout', 'adminLogout')->name('adminLogout');
    });


Route::controller(UsersDashboardController::class)
    ->middleware([UserAuthMiddleware::class])
    ->name('users.dashboard.')
    ->prefix('users/dashboard')
    ->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/profile', 'profile')->name('profile');
    });

Route::controller(ActivityController::class)
    ->middleware([UserAuthMiddleware::class])
    ->name('users.dashboard.activity.')
    ->prefix('users/dashboard/activity')
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/store', 'store')->name('store');
    });


//
Route::controller(AdminDashboardController::class)
    ->name('admin.dashboard.')
    ->prefix('admin/dashboard')
    ->middleware([AdminAuthMiddleware::class])
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/users', 'users')->name('users');
    });

Route::controller(AdminActivityController::class)
    ->middleware([AdminAuthMiddleware::class])
    ->name('admin.activity.dashboard.')
    ->prefix('admin/activity/dashboard')
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/download', 'download')->name('download');
        Route::get('/report', 'report')->name('report');
        Route::post('/store', 'store')->name('store');
    });

Route::controller(AdminProfileController::class)
    ->middleware([AdminAuthMiddleware::class])
    ->name('admin.dashboard.profile.')
    ->prefix('admin/dashboard/profile')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
    });
