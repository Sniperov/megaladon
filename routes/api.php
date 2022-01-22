<?php

use App\Http\Controllers\Api\v1\OrderOfferController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
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

Route::group(['guard' => 'api'], function () {
    Route::get('/cities', [CityController::class, 'getAll']);
    Route::post('/product-categories', [ProductCategoryController::class, 'index']);
    
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/confirm-code', [AuthController::class, 'confirmCode']);
        
        Route::group(['guard' => 'api', 'middleware' => 'auth'], function () {
            Route::post('/send-code', [AuthController::class, 'sendCode']);
            Route::post('/register-executor', [AuthController::class, 'registerExecutor']);
            Route::post('/register-store', [AuthController::class, 'registerStore']);
            Route::delete('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index']);

        Route::group(['guard' => 'api', 'middleware' => 'auth'], function () {
            Route::post('/create', [OrderController::class, 'store']);
            Route::get('/{id}', [OrderController::class, 'info']);
            Route::put('/{id}/update', [OrderController::class, 'update']);
            Route::post('/{id}/comment', [OrderController::class, 'commentOrder']);
            Route::post('/{id}/offer', [OrderOfferController::class, 'create']);
            Route::get('/{id}/offer', [OrderOfferController::class, 'getOffers']);
            Route::get('/{id}/offer/{offerId}', [OrderOfferController::class, 'info']);
        });
    });

    Route::group(['prefix' => 'chat', 'guard' => 'api', 'middleware' => 'auth'], function () {
        Route::post('/send-message', [ChatController::class, 'sendMessage']);
        Route::put('/edit-message', [ChatController::class, 'editMessage']);
        Route::delete('/delete-message', [ChatController::class, 'deleteMessage']);
    });
});