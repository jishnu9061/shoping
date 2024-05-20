<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::post('/store', [ProductController::class, 'store'])->name('store');
Route::get('/product-list', [ProductController::class, 'productList'])->name('products.list');
Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('add-to-cart');
Route::post('/filter-products',[ProductController::class, 'filterProducts'])->name('filter-products');


