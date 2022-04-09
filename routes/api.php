<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ProductDetailMasterController;
use App\Http\Controllers\API\V1\SegmentController;
use App\Http\Controllers\API\V1\StoreController;
use App\Http\Controllers\API\V1\SubCategoryController;

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

Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');

        Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::apiResource('product', ProductController::class);
        Route::get('segment/{id}/categories', [SegmentController::class, 'showCategoriesBySegmentId'])->name('segment.showCategoriesBySegmentId');
        Route::apiResource('segment', SegmentController::class);
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('sub-category', SubCategoryController::class);
        Route::apiResource('product-detail-master', ProductDetailMasterController::class);
        Route::apiResource('brand', BrandController::class);
        Route::apiResource('store', StoreController::class);
    });
});
