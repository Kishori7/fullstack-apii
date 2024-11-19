<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;


Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::get('/product/cheapest', [ProductController::class, 'getCheapestProduct']);
Route::get('/product/most-expensive', [ProductController::class, 'getMostExpensiveProduct']);
Route::post('/products/cheapest', [ProductController::class, 'getCheapestProduct']);
Route::post('/products/most-expensive', [ProductController::class, 'getMostExpensiveProduct']);
Route::post('/product/{id}/restore', [ProductController::class, 'restore']);

Route::get('/categories/{id}/products', [CategoryController::class, 'getProductsByCategory']);
Route::put('/product/update-prices', [ProductController::class, 'bulkUpdatePrices']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/resource', [ResourceController::class, 'getResource']);
Route::post('/resource', [ResourceController::class, 'getResource']);
Route::get('/resource', [ResourceController::class, 'index']);
Route::delete('/resource', [ResourceController::class, 'getResource']);



Route::middleware('role')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('api/product/{id}', [ProductController::class, 'show']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);
    Route::delete('api/products/{id}', [ProductController::class, 'destroy']);
    Route::put('/products/update-prices', [ProductController::class, 'bulkUpdatePrices']);
    Route::post('/products/{id}/restore', [ProductController::class, 'restore']);
});

