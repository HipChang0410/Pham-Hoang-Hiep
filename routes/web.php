<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\DemoController;
use App\Http\Middleware\AuthenticateAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo/index2', [DemoController::class, 'index2']);
Route::get('/demo/index3', [DemoController::class, 'index3']);
Route::get('/demo/{id}', [DemoController::class, 'index4']);
Route::get('/demo-opt/{id?}', [DemoController::class, 'index5']);
Route::get('/demo-dd/{id?}', [DemoController::class, 'index5WithDd']);
Route::get('/demo/{param1}/{param2}', [DemoController::class, 'index6']);

Route::prefix('admin')->group(function () {
    Route::get('/category', function () {
        return 'Category index';
    });

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('admin.forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('admin.forgotpass.post');

    Route::middleware([AuthenticateAdmin::class])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('admin.change-password');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('admin.change-password.submit');
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.home');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    });

    Route::middleware(['roles:1'])->group(function () {
        Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('admin.categories.trash');
        Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('admin.categories.restore');
        Route::delete('/categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('admin.categories.forceDelete');

        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('admin.brands.store');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    Route::resource('categories', CategoryController::class)->names('admin.categories')->only(['index', 'show']);
    Route::resource('brands', BrandController::class)->names('admin.brands')->only(['index', 'show']);
    Route::resource('products', AdminProductController::class)->names('admin.products')->only(['index', 'show']);
    Route::resource('user', UserController::class);
    Route::resource('post', PostController::class);
});

Route::get('/test1', [AdminProductController::class, 'test1']);
Route::get('/test2', [AdminProductController::class, 'test2']);
