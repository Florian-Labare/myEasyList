<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ListController;

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

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::prefix('category')->group(function () {

    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');

    Route::prefix('{categoryId}')->group(function () {

        Route::post('/update', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

        Route::prefix('product/')->group(function() {

            Route::get('/not-ok-statuses', [ProductController::class, 'productsWithNotOkStatusByCategory'])->name('category.product.not.ok');
            Route::get('/create', [ProductController::class, 'create'])->name('product.category.create');
            Route::post('/store', [ProductController::class, 'store'])->name('product.category.store');
            Route::get('products-list', [ProductController::class, 'productsByCategory'])->name('products.category');

            // productId
            Route::post('{productId}/update', [ProductController::class, 'update'])->name('product.update');
            Route::get('{productId}/edit', [ProductController::class, 'edit'])->name('product.edit');

            Route::post('{productId}/add_days', [ProductController::class, 'addValidityDaysCategoryProduct'])->name('product.category.add.days');

        });

    });

});

// create produt out of category
Route::prefix('product')->group(function() {

    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');

});

Route::prefix('list')->group(function () {

    Route::post('/store', [ListController::class, 'store'])->name('list.store');
    Route::get('/create', [ListController::class, 'create'])->name('list.create');

    Route::prefix('{listId}')->group(function () {
        Route::get('/show', [ListController::class, 'show'])->name('list.show');
        Route::get('/edit', [ListController::class, 'edit'])->name('list.edit');
        Route::post('/update', [ListController::class, 'update'])->name('list.update');
        Route::post('/destroy', [ListController::class, 'destroy'])->name('list.destroy');
    });

});

