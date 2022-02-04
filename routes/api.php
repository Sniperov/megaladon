<?php

use App\Http\Controllers\Api\v1\{
    ExecutorController,
    OrderOfferController,
    UserController, 
    AuthController,
    CatalogController,
    ChatController,
    CityController,
    OrderController,
    ProductCategoryController,
    StoreController,
};
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
    Route::get('/cities', [CatalogController::class, 'cities']);
    Route::get('/order-categories', [CatalogController::class, 'orderCategories']);
    Route::get('/product-categories', [ProductCategoryController::class, 'index']);
    
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/confirm-code', [AuthController::class, 'confirmCode']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        
        Route::group(['middleware' => 'api'], function () {
            // Route::post('/send-code', [AuthController::class, 'sendCode']);
            Route::post('/register-executor', [AuthController::class, 'registerExecutor']);
            Route::post('/register-store', [AuthController::class, 'registerStore']);
            Route::delete('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::group(['prefix' => 'user', 'middleware' => 'api'], function () {
        Route::post('/change-password', [UserController::class,'changePassword']);
        Route::put('/store', [StoreController::class, 'updateProfile']);
        Route::put('/executor', [ExecutorController::class, 'update']);
        Route::post('/update-photo', [UserController::class, 'updatePhoto']);
        Route::post('/change-phone/start', [UserController::class, 'startChangePhone']);
        Route::post('/change-phone/end', [UserController::class, 'endChangePhone']);
        Route::post('/change-token', [UserController::class, 'updateToken']);
        Route::delete('/disable-notifications', [UserController::class, 'disableNotifications']);
        Route::get('/{id}', [UserController::class, 'profile']);
    });

    Route::group(['prefix' => 'order', 'middleware' => 'api'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/create', [OrderController::class, 'store']);
        Route::get('/{id}', [OrderController::class, 'info']);
        Route::post('/{id}/update', [OrderController::class, 'update']);
        Route::post('/{id}/offer', [OrderOfferController::class, 'create']);
        Route::get('/{id}/offer', [OrderOfferController::class, 'orderOffers']);
        Route::get('/{id}/offer/{offerId}', [OrderOfferController::class, 'info']);
    });

    Route::group(['prefix' => 'store', 'middleware' => 'api'], function() {
        Route::get('/', [StoreController::class, 'index']);
    });

    Route::group(['prefix' => 'chat', 'middleware' => 'api'], function () {
        Route::post('/send-message', [ChatController::class, 'sendMessage']);
        Route::put('/edit-message', [ChatController::class, 'editMessage']);
        Route::delete('/delete-message', [ChatController::class, 'deleteMessage']);
    });
});