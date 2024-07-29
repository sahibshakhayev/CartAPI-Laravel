<?php
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/item/{id}', [CartController::class, 'getOneItem'])->name('cart.getOneItem');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/multiple-add', [CartController::class, 'multipleAdd'])->name('cart.multipleAdd');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/item/{id}', [CartController::class, 'getOneItem'])->name('cart.getOneItem');
Route::delete('/cart/remove-item/{productId}', [CartController::class, 'deleteAItem'])->name('cart.deleteAItem');
Route::delete('/cart/remove-all', [CartController::class, 'deleteAllItems'])->name('cart.deleteAllItems');
Route::get('/cart/subtotal', [CartController::class, 'subtotal'])->name('cart.subtotal');
Route::get('/cart/total', [CartController::class, 'total'])->name('cart.total');
Route::get('/cart/tax', [CartController::class, 'tax'])->name('cart.tax');
Route::put('/cart/setTax',[CartController::class, 'setTax']) -> name('cart.setTax');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
