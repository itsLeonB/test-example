<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/inventory', [ProductController::class, 'index'])->name('inventory');
    Route::get('/new-product', function () {
        return view('new-product');
    })->name('new-product');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::patch('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/purchase', [ProductController::class, 'purchase'])->name('purchase');
    Route::post('/purchase', [ProductController::class, 'storePurchase'])->name('purchase.store');
    Route::get('/purchase-show', function () {
        return view('purchase-show');
    })->name('purchase.show');

    Route::get('/sales', [ProductController::class, 'sales'])->name('sales');
    Route::post('/sales', [ProductController::class, 'storeSales'])->name('sales.store');
    Route::get('/sales-show', function () {
        return view('sales-show');
    })->name('sales.show');
});

require __DIR__.'/auth.php';
