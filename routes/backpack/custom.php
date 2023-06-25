<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Models\DossierJustice;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group(['middleware' => [config('backpack.base.web_middleware', 'web')]], function () {
    //routes here
    Route::get('admin/register', 'App\Http\Controllers\Admin\Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
    Route::post('admin/register', 'App\Http\Controllers\Admin\Auth\RegisterController@register');
    Route::get('admin/dashboard/chart', 'App\Http\Controllers\Admin\AdminDashboardController@getChartData')->name('chart');
    Route::get('admin/dashboard', 'App\Http\Controllers\Admin\AdminDashboardController@dashboard')->name('dashboard');
    Route::get('/', 'App\Http\Controllers\Admin\AdminDashboardController@redirect')->name('backpack');
    Route::get('admin/notification/unreadcount', [
        'uses' => 'App\Http\Controllers\Admin\CustomNotificationCrudController@unreadCount',
        'as' => 'crud.notification.unreadcount',
    ]);
    Route::get('admin/notification/dismissall', [
        'uses' => 'App\Http\Controllers\Admin\CustomNotificationCrudController@dismissAll',
        'as' => 'crud.notification.dismissall',
    ]);
    Route::get('admin/notification/{notification_id}/dismiss', [
        'uses' => 'App\Http\Controllers\Admin\CustomNotificationCrudController@dismiss',
        'as' => 'crud.notification.dismiss',
    ]);
    if (config('backpack.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'App\Http\Controllers\Admin\Auth\MyCustomAccountController@getAccountInfoForm')->name('backpack.account.info');
        Route::post('edit-account-info', 'App\Http\Controllers\Admin\Auth\MyCustomAccountController@postAccountInfoForm')->name('backpack.account.info.store');
        Route::post('change-password', 'App\Http\Controllers\Admin\Auth\MyCustomAccountController@postChangePasswordForm')->name('backpack.account.password');
    }
   
});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('notification', 'CustomNotificationCrudController');
    Route::crud('dossier-justice', 'DossierJusticeCrudController');
    Route::crud('avocat', 'AvocatCrudController');
    Route::crud('partie-adverse', 'PartieAdverseCrudController');
    Route::crud('audience', 'AudienceCrudController');
    Route::crud('court', 'CourtCrudController');
}); // this should be the absolute last line of this file