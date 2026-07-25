<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo/index2', [DemoController::class, 'index2']);
Route::get('/demo/index3', [DemoController::class, 'index3']);
Route::get('/demo/{id}', [DemoController::class, 'index4']);
Route::get('/demo-opt/{id?}', [DemoController::class, 'index5']);
Route::get('/demo-dd/{id?}', [DemoController::class, 'index5WithDd']);
Route::get('/demo/{param1}/{param2}', [DemoController::class, 'index6']);

Route::prefix('admin')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('product', ProductController::class);
    Route::resource('user', UserController::class);
    Route::resource('post', PostController::class);
});
