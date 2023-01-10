<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Checkout\LinkCheckoutController;
use App\Http\Controllers\Checkout\OrderCheckoutController;
use App\Http\Controllers\Common\LinkController;
use App\Http\Controllers\Common\ProductCommonController;
use Illuminate\Http\Request;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::get('user', [UserController::class, 'user']);
    Route::put('user/update/info', [UserController::class, 'updateInfo']);
    Route::put('user/update/password', [UserController::class, 'updatePassword']);
});

Route::group([
    'middleware' => ['auth:api', 'scope:admin'],
    'prefix' => 'admin',
], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('chart', [DashboardController::class, 'chart']);

    Route::post('products/image/upload', [ImageController::class, 'upload']);

    Route::get('orders/export', [OrderController::class, 'export']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('products', ProductAdminController::class);
    Route::apiResource('orders', OrderController::class)->only('index', 'show');
    Route::apiResource('permissions', PermissionController::class)->only('index');
});

Route::group([
    'prefix' => 'common',
], function() {
    Route::apiResource('products', ProductCommonController::class);

    Route::group([
        'middleware' => ['auth:api', 'scope:common']
    ], function () {
        Route::post('links', [LinkController::class, 'store']);
    });
});

Route::group([
    'prefix' => 'checkout',
], function() {
    Route::get('links/{code}', [LinkCheckoutController::class, 'show']);
    Route::post('orders', [OrderCheckoutController::class, 'store']);
    Route::post('orders/confirm', [OrderCheckoutController::class, 'confirm']);
});

