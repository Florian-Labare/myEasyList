<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/category/{categoryId}/delete-products', [CategoryController::class, 'deleteAllCategoryProducts'])->name('delete-all-category-products');
Route::delete('/category/{categoryId}/hello', [CategoryController::class, 'hello'])->name('hello');
Route::get('/category/{categoryId}/product/{productId}/progress-bar', [ProductController::class, 'getProgressBarPercent'])->name('category-product-progress');
Route::post('/category/{categoryId}/product/{productId}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

Route::prefix('product')->group(function() {

    Route::prefix('{productId}')->group(function() {

        Route::post('/add-references-validity-days', [ProductController::class, 'addReferenceValidityDays'])->name('add-references-days');

    });

});

Route::prefix('list')->group(function() {

    Route::prefix('{listId}')->group(function() {

        Route::post('/add-product', [ListController::class, 'addProductsTolist'])->name('add-product-list');
        Route::post('/merge-product', [ListController::class, 'mergeProductsToList'])->name('merge-product-list');

    });

});
