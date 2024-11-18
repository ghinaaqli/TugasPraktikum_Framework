<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Doctrine\DBAL\Schema\Index;
use GuzzleHttp\Promise\Create;

Route::get('/products', [ProductController::class, 'index'])->name(name: 'products-index');
Route::get('/products/create', [ProductController::class, 'create'])->name("product-create");
Route::post('/products', [ProductController::class, 'store'])->name("product-store");
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name("product-edit");
Route::put('/products/{id}', [ProductController::class, 'update'])->name("product-update");
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/supplier/create', [SupplierController::class, 'create'])->name("supplier-create");

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
});

require __DIR__ . '/auth.php';
