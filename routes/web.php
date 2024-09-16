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

 Route::controller(AuthController::class) 
    ->name('account.recovery.') 
    ->group(function () {
        Route::get('/admin/account-recovery', 'adminAccountRecoveryGet')->name(name: 'admin.get');
        Route::post('/admin/account-recovery', 'adminAccountRecoveryPost')->name('admin.post');

        Route::get('/user/account-recovery', 'userAccountRecoveryGet')->name(name: 'user.get');
        Route::post('/user-d/account-recovery', 'userAccountRecoveryPost')->name('user.post');
    });

Route::controller(UsersDashboardController::class)
    ->middleware([UserAuthMiddleware::class])
    ->name('users.dashboard.')
    ->prefix('users/dashboard')
    ->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile/update', 'update')->name('profile.update');
    });

Route::controller(ActivityController::class)
    ->middleware([UserAuthMiddleware::class])
    ->name('users.dashboard.activity.')
    ->prefix('users/dashboard/activity')
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/update-status', 'updateActivityStatus')->name('update.status');
    });

Route::controller(ActivityController::class)
    ->middleware([UserAuthMiddleware::class])
    ->name('users.dashboard.activity.')
    ->prefix('users/activity')
    ->group(function () {
        Route::post('/update-status', 'updateActivityStatus')->name('update.status');
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
        Route::post('/create-user', 'createUser')->name('create.user');
        Route::get('/delete-user/{user}', action: 'deleteUser')->name('delete.user');
        Route::get('/export-users', 'exportUsers')->name('export.users');
        Route::get('/export-admins', 'exportAdmins')->name('export.admins');
    });

Route::controller(AdminActivityController::class)
    ->middleware([AdminAuthMiddleware::class])
    ->name('admin.activity.dashboard.')
    ->prefix('admin/activity/dashboard')
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('show/{id}', 'show')->name('show');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('destroy');
        Route::post('/store', 'store')->name('store');
    });


Route::controller(AdminActivityController::class)
    ->name('admin.activity.dashboard.')
    ->prefix('admin/activity')
    ->group(function () {
        Route::get('/report-filter', 'filter')->name('filter');
        Route::get('/download/{id}', 'download')->name('download');
    });


Route::controller( AdminProfileController::class)
    ->middleware([AdminAuthMiddleware::class])
    ->name('admin.dashboard.profile.')
    ->prefix('admin/dashboard')
    ->group(function () {
        Route::get('/profile', 'index')->name('index');
        Route::post('/profile/update', 'update')->name('update');
    });
