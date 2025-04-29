<?php

use App\Http\Controllers\API\V1\{
    AuthController,
    CommoditiesController,
    OrdersController,
    UsersController
};
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as'     => 'api.v1.',
], function () {
    // Authentication
    Route::group([
        'controller' => AuthController::class,
        'prefix'     => 'auth',
        'as'         => 'auth.',
    ], function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('refresh', 'refresh')->name('refresh');
            Route::post('logout', 'logout')->name('logout');
        });
    });

    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        // Users
        Route::group([
            'prefix'     => 'users',
            'as'         => 'users.',
            'controller' => UsersController::class,
        ], function () {
            Route::get('{user}', 'show')->name('show');
            Route::get('{page?}/{perPage?}', 'index')->name('index');
        });

        // Commodities
        Route::group([
            'controller' => CommoditiesController::class,
            'prefix'     => 'commodities',
            'as'         => 'commodities.',
        ], function () {
            Route::group([
                'middleware' => 'prevent.duplicates',
            ], function () {
                Route::get('{page?}/{perPage?}', 'index')
                    ->middleware('prevent.duplicates')
                    ->name('index');
                Route::get('{commodity}', 'show')->name('show');
            });
            Route::post('', 'create')->name('create');
            Route::put('{commodity}', 'update')->name('update');
            Route::delete('{commodity}', 'delete')->name('delete');
        });

        // Orders
        Route::group([
            'controller' => OrdersController::class,
            'prefix'     => 'orders',
            'as'         => 'orders.',
        ], function () {
            Route::group([
                'middleware' => 'prevent.duplicates',
            ], function () {
                Route::get('{page?}/{perPage?}', 'index')
                    ->middleware('prevent.duplicates')
                    ->name('index');
                Route::get('{order}', 'show')->name('show');
            });
            Route::post('', 'create')->name('create');
            Route::put('{order}', 'update')->name('update');
            Route::delete('{order}', 'delete')->name('delete');
        });
    });
});
