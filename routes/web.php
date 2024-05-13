<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
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


Route::middleware(['auth'])->group(function(){
    Route::get('/', function () {
        $categories = Category::all();
        $products = Product::all();
        return view('dashboard', compact('categories', 'products'));
    })->name('dashboard');
    
    Route::controller(CartController::class)->group(function(){
        Route::get('cart', [CartController::class, 'index'])->name('cart');
        Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
        Route::patch('update-cart/{id}', [CartController::class, 'update'])->name('update_cart');
        Route::delete('remove-cart/{id}', [CartController::class, 'remove'])->name('remove_from_cart');
    });

    Route::controller(InvoiceController::class)->group(function(){
        Route::get('/invoice', 'index')->name('invoice');
        Route::get('/print-invoice/{id}', 'print')->name('print.invoice');
        Route::post('/add-invoice', 'create')->name('add.invoice');
    });

    Route::prefix('admin')->middleware(['isAdmin'])->group(function(){
        
        Route::controller(CategoryController::class)->group(function (){
            Route::get('/category',  'index')->name('category');
            Route::post('/add-category', 'create')->name('add.category');
        });
    
        Route::controller(ProductController::class)->group(function (){
            Route::get('/product', 'index')->name('product');
            Route::get('/edit-product/{id}', 'edit')->name('edit.product');
            Route::post('/add-product', 'create')->name('add.product');
            Route::patch('/update-product/{id}', 'update')->name('update.product');
            Route::delete('/delete-product/{id}', 'delete')->name('delete.product');
        });   
    });
});

require __DIR__.'/auth.php';
