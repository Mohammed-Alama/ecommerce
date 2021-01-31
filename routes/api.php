<?php

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

Route::namespace('General')->group(function () {
    Route::get('cities', 'CityController');
    Route::get('regions', 'RegionController');
    Route::get('products', 'ProductController');
});

Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('/login', 'LoginController@login');
});

Route::middleware('auth:api')
    ->prefix('users')
    ->namespace('Users')
    ->group(function () {
        Route::get('profile', function () {
            return auth_factory('user');
        });
        Route::apiResource('addresses', 'AddressController');
        Route::apiResource('orders', 'OrderProductController');
        Route::post('orders/{order}/status', 'OrderUpdateStatusController');
    });


Route::middleware('auth:api-admins')
    ->prefix('admins')
    ->namespace('Admins')
    ->group(function () {

        Route::get('profile', function () {
            return auth_factory('user');
        });

        Route::post('drivers/{driver}/activetion', 'DriverActivationController');
        Route::post('merchants/{merchant}/activetion', 'MerchantActivationController');
    });


Route::middleware('auth:api-merchants')
    ->prefix('merchants')
    ->namespace('Merchants')
    ->group(function () {
        Route::get('profile', function () {
            return auth_factory('user');
        });

        Route::apiResource('products', 'ProductController');
    });


Route::middleware('auth:api-drivers')
    ->prefix('drivers')
    ->namespace('Drivers')
    ->group(function () {
        Route::get('orders/all', 'OrderController@index');
        Route::get('orders/mine', 'OrderController@listOrders');
        Route::post('orders/{order}/assign', 'OrderController@assignOrder');
        Route::post('orders/{order}/status', 'OrderUpdateStatusController');
    });
