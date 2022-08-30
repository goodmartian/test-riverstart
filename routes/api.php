<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
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

Route::group([
    'as' => 'products.',
    'prefix' => 'products'
], function () {
    Route::get('/', [ProductController::class, 'getAllProducts']);
    Route::post('/', [ProductController::class, 'create']);
    Route::put('{product}', [ProductController::class, 'update']);
    Route::delete('{product}', [ProductController::class, 'delete']);
});

Route::group([
    'as' => 'categories.',
    'prefix' => 'categories'
], function () {
    Route::post('/', [CategoryController::class, 'create']);
    Route::put('{category}', [CategoryController::class, 'update']);
    Route::delete('{category}', [CategoryController::class, 'delete']);
});
