<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WEB\CategoryController;
use App\Http\Controllers\Web\FrontEndController;
use App\Http\Controllers\WEB\MyTransactionController;
use App\Http\Controllers\WEB\ProductController;
use App\Http\Controllers\WEB\ProductGalleryController;
use App\Http\Controllers\WEB\TransactionController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontEndController::class, 'index']);

Auth::routes();

Route::middleware(['auth', 'verified'])->group(function(){
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::post('/cart/{id}', [FrontEndController::class, 'cartStore'])->name('cartStore');
Route::delete('/cartDelete/{id}', [FrontEndController::class, 'cartDelete'])->name('cartDelete');
Route::post('/checkout', [FrontEndController::class, 'checkout'])->name('checkout');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [FrontEndController::class, 'detailProduct'])->name('detailProduct');
Route::get('/detail-category/{slug}', [FrontEndController::class, 'detailCategory'])->name('detailCategory');

Route::middleware(['auth'])->name('dashboard.')
    ->prefix('dashboard')->group(function () {
        // 127.0.0.1:8000/dashboard/category => setelah ada prefix('dashboard')
        // 127.0.0.1:8000/category => sebelum ada prefix('dashboard')
        // category.index => sebelum ada name route('dashboard.')
        // dashboard.category.index => setelah ada name route('dashboard.')

        Route::resource('/my-transaction', MyTransactionController::class);

        Route::middleware(['admin'])->group(function () {
            //Route yang ada didalam middleware admin maka 
            // yang bisa mengakses hanya admin
            Route::resource('/category', CategoryController::class);
            Route::resource('/product', ProductController::class);
            Route::resource('/product.gallery', ProductGalleryController::class)->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('/transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            Route::resource('/user', UserController::class)->only([
                'index', 'destroy', 'update', 'edit',
            ]);
        });
    });
