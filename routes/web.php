<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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
    return view('index');
});

// Route::get('/', 'ProductsController@index')->name('products.index');

Route::get('/', [ProductsController::class, 'index'])->name('index.show');

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductsController::class, 'viewCreate'])->name('products.create');
    Route::get('/update/{id}', [ProductsController::class, 'edit'])->name('products.edit');
    Route::delete('/delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
    //
    Route::post('/create', [ProductsController::class, 'store'])->name('products.store.post');
});
