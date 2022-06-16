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


Route::middleware('auth')->group(function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});

Route::namespace('Panel')->group(function ()
{
    Route::prefix('panel')->group(function ()
    {
        Auth::routes();
        Route::middleware('auth')->group(function ()
        {
            Route::get('/', 'DashboardController@index');
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
            Route::get('/doc', 'DashboardController@doc')->name('doc');

            Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
            Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');

            Route::prefix('pages')->group(function ()
            {
                Route::post('/store', 'PageController@store')->name('page-store');
                Route::post('/destroy', 'PageController@destroy')->name('page-destroy');
                Route::post('/{id}', 'PageController@update')->name('page-update');
                Route::get('/create', 'PageController@create')->name('page-create');
                Route::get('/{id}/edit', 'PageController@edit')->name('page-edit');
                Route::get('/{id}', 'PageController@show')->name('page-show');
                Route::get('/', 'PageController@index')->name('pages');
            });

            Route::prefix('navs')->group(function ()
            {
                Route::post('/store', 'NavController@store')->name('nav-store');
                Route::post('/destroy', 'NavController@destroy')->name('nav-destroy');
                Route::post('/{id}', 'NavController@update')->name('nav-update');
                Route::get('/create', 'NavController@create')->name('nav-create');
                Route::get('/{id}/edit', 'NavController@edit')->name('nav-edit');
                Route::get('/{id}', 'NavController@show')->name('nav-show');
                Route::get('/', 'NavController@index')->name('navs');
            });

            Route::prefix('slides')->group(function ()
            {
                Route::post('/store', 'SlideController@store')->name('slide-store');
                Route::post('/destroy', 'SlideController@destroy')->name('slide-destroy');
                Route::post('/{id}', 'SlideController@update')->name('slide-update');
                Route::get('/create', 'SlideController@create')->name('slide-create');
                Route::get('/{id}/edit', 'SlideController@edit')->name('slide-edit');
                Route::get('/{id}', 'SlideController@show')->name('slide-show');
                Route::get('/', 'SlideController@index')->name('slides');
            });

            Route::prefix('users')->group(function ()
            {
                Route::post('/store', 'UsersController@store')->name('user-store');
                Route::post('/destroy', 'UsersController@destroy')->name('user-destroy');
                Route::post('/{id}', 'UsersController@update')->name('user-update');
                Route::get('/create', 'UsersController@create')->name('user-create');
                Route::get('/{id}/edit', 'UsersController@edit')->name('user-edit');
                Route::get('/{id}', 'UsersController@show')->name('user-show');
                Route::get('/', 'UsersController@index')->name('users');
            });

            Route::prefix('roles')->group(function ()
            {
                Route::post('/store', 'RoleController@store')->name('role-store');
                Route::post('/destroy', 'RoleController@destroy')->name('role-destroy');
                Route::post('/{id}', 'RoleController@update')->name('role-update');
                Route::get('/create', 'RoleController@create')->name('role-create');
                Route::get('/{id}/edit', 'RoleController@edit')->name('role-edit');
                Route::get('/{id}', 'RoleController@show')->name('role-show');
                Route::get('/', 'RoleController@index')->name('roles');
            });

            Route::prefix('permissions')->group(function ()
            {
                Route::post('/store', 'PermissionController@store')->name('permission-store');
                Route::post('/destroy', 'PermissionController@destroy')->name('permission-destroy');
                Route::post('/{id}', 'PermissionController@update')->name('permission-update');
                Route::get('/create', 'PermissionController@create')->name('permission-create');
                Route::get('/{id}/edit', 'PermissionController@edit')->name('permission-edit');
                Route::get('/{id}', 'PermissionController@show')->name('permission-show');
                Route::get('/', 'PermissionController@index')->name('permissions');
            });

            Route::prefix('messages')->group(function ()
            {
                Route::get('/', 'MessagesController@index')->name('messages');
                Route::delete('/{id}', 'MessagesController@destroy')->name('message-destroy');
            });

            Route::prefix('store')->group(function ()
            {
                Route::prefix('categories')->group(function () {
                    Route::post('/store', 'CategoryController@store')->name('category-store');
                    Route::post('/destroy', 'CategoryController@destroy')->name('category-destroy');
                    Route::post('/{id}', 'CategoryController@update')->name('category-update');
                    Route::get('/create', 'CategoryController@create')->name('category-create');
                    Route::get('/{id}/edit', 'CategoryController@edit')->name('category-edit');
                    Route::get('/{id}', 'CategoryController@show')->name('category-show');
                    Route::get('/', 'CategoryController@index')->name('categories');
                });

                Route::prefix('products')->group(function () {
                    Route::post('/store', 'ProductController@store')->name('product-store');
                    Route::post('/destroy', 'ProductController@destroy')->name('product-destroy');
                    Route::post('/{id}', 'ProductController@update')->name('product-update');
                    Route::get('/create', 'ProductController@create')->name('product-create');
                    Route::get('/{id}/edit', 'ProductController@edit')->name('product-edit');
                    Route::get('/{id}', 'ProductController@show')->name('product-show');
                    Route::get('/', 'ProductController@index')->name('products');
                });

                Route::prefix('export')->group(function () {
                    Route::get('/', 'ProductController@export')->name('export');
                });
            });

            Route::prefix('orders')->group(function () {
                Route::get('/', 'OrderController@index')->name('orders');
                Route::get('/{id}', 'OrderController@show')->name('order-show');
//                Route::post('/store', 'OrderController@create')->name('order-store');
//                Route::get('/{id}/edit', 'OrderController@edit')->name('order-edit');
//                Route::post('/{id}', 'OrderController@update')->name('order-update');
                Route::post('/destroy', 'OrderController@destroy')->name('order-destroy');
            });

            Route::prefix('settings')->group(function () {
                Route::post('/store', 'SettingsController@store')->name('setting-store');
                Route::post('/destroy', 'SettingsController@destroy')->name('setting-destroy');
                Route::post('/{id}', 'SettingsController@update')->name('setting-update');
                Route::get('/create', 'SettingsController@create')->name('setting-create');
                Route::get('/{id}/edit', 'SettingsController@edit')->name('setting-edit');
                Route::get('/{id}', 'SettingsController@show')->name('setting-show');
                Route::get('/', 'SettingsController@index')->name('settings');
            });
        });
    });
});

Route::namespace('Site')->group(function ()
{
    Route::post('/pay', 'CartController@pay')->name('pay');

    Route::get('/menu/{categorySlug}', 'CategoryController@index')->name('category');
    Route::get('/tovar/{productSlug}', 'ProductController@index')->name('product');
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::get('/cart-finish/{hash}', 'CartController@finish')->name('cart-finish');
    Route::get('/cart-payment/{hash}', 'CartController@payment')->name('cart-payment');
    Route::get('/success', 'PaymentController@notify')->name('paySuccess');
    Route::get('/decline', 'PaymentController@decline')->name('payDecline');
    Route::get('/fail', 'PaymentController@fail')->name('payFail');
    Route::get('/cancel', 'PaymentController@cancel')->name('payCancel');
    Route::get('/notify', 'PaymentController@notify')->name('payNotify');
    
    Route::get('/sender', 'IndexController@senderTest')->name('sendertest');
    Route::get('/megasendercommandstart', 'IndexController@sendercommandstart')->name('sendercommandstart');

    Route::get('/{pageSlug}', 'PageController@index')->name('page');
    Route::get('/', 'IndexController@index')->name('home');
});
