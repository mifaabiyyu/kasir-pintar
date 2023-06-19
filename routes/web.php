<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LogItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ViewController;
use App\Models\Category;
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

Route::get('/', [ViewController::class, 'home']);
Route::get('/items', [ViewController::class, 'items']);

Route::get('/get-item', [ItemsController::class, 'index'])->name('items.index');


Route::post('/items-data/update/{id}', [ItemsController::class, 'update'])->name('items.update');
Route::middleware('auth')->group(function () {
    Route::resource('/items-data', ItemsController::class);
    
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/item-data/log/{id}', [ItemsController::class, 'logItem'])->name('items.logItem');
        Route::resource('/category-data', CategoryController::class);
        Route::get('/categories', [ViewController::class, 'categories'])->name('category.index');
    
        Route::resource('/satuan-data', SatuanController::class);
        Route::get('/satuan', [ViewController::class, 'satuan'])->name('satuan.index');
    
        Route::resource('/log-data', LogItemController::class);
        Route::get('/transaction', [ViewController::class, 'logItem']);
    
        Route::resource('/vendor-data', VendorController::class);
        Route::get('/vendor', [ViewController::class, 'vendor']);
    });
});

require __DIR__.'/auth.php';
