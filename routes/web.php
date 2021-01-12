<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\PaymentController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\CategoryController;

Route::group(['prefix' => 'admin','namespace' => 'backend'], function () {
    Route::redirect('/', '/admin/login');
    Route::match(['get','post'], '/login', ['App\Http\Controllers\backend\UserController', 'index'])->name('admin.login');
    Route::get('/logout', ['App\Http\Controllers\backend\UserController','logout'])->name('admin.logout');
    Route::group(['middleware' => 'admin'], function () {        
        Route::get('/home', ['App\Http\Controllers\backend\HomeController','index'])->name('admin.home');

        Route::group(['prefix' => 'user'], function () {            
            Route::get('/', ['App\Http\Controllers\backend\UserController','list'])->name('admin.user.list');
            Route::get('/create', ['App\Http\Controllers\backend\UserController','create'])->name('admin.user.create');
            Route::get('/update/{request?}/{id}', ['App\Http\Controllers\backend\UserController','update'])->name('admin.user.update');
            Route::post('/save/{id?}', ['App\Http\Controllers\backend\UserController','save'])->name('admin.user.save');
            Route::get('/delete/{id}', ['App\Http\Controllers\backend\UserController','delete'])->name('admin.user.delete');
        });

        Route::group(['prefix' => 'category'], function () {            
            Route::get('/', ['App\Http\Controllers\backend\CategoryController','list'])->name('admin.category.list');
            Route::get('/update/{request?}/{id?}', ['App\Http\Controllers\backend\CategoryController','update'])->name('admin.category.update');
            Route::post('/save/{id?}', ['App\Http\Controllers\backend\CategoryController','save'])->name('admin.category.save');
            Route::get('/delete/{id}', ['App\Http\Controllers\backend\CategoryController','delete'])->name('admin.category.delete');
        });

        Route::group(['prefix' => 'product'], function () {            
            Route::match(['get', 'post'], '/', ['App\Http\Controllers\backend\ProductController','list'])->name('admin.product.list');
            Route::get('/create', ['App\Http\Controllers\backend\ProductController','create'])->name('admin.product.create');
            Route::get('/update/{request?}/{id?}', ['App\Http\Controllers\backend\ProductController','update'])->name('admin.product.update');
            Route::post('/save/{id?}', ['App\Http\Controllers\backend\ProductController','save'])->name('admin.product.save');
            Route::get('/delete/{id}', ['App\Http\Controllers\backend\ProductController','delete'])->name('admin.product.delete');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('/', ['App\Http\Controllers\backend\OrderController', 'list'])->name('admin.order.list');
            Route::get('/update/{request?}/{id?}', ['App\Http\Controllers\backend\OrderController','update'])->name('admin.order.update');
            Route::post('/save/{id?}', ['App\Http\Controllers\backend\OrderController','save'])->name('admin.order.save');
            Route::get('/delete/{id}', ['App\Http\Controllers\backend\OrderController','delete'])->name('admin.order.delete');
        });
    });
});

Route::group(['namespace' => 'frontend'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/category/{slug_categoryname}',[CategoryController::class, 'index'])->name('category');
    Route::get('product/{slug_product_name}',[ProductController::class, 'index'])->name('product');
    Route::get('/product_search',[ProductController::class,'search'])->name('product_search');
    Route::post('/product_search',[ProductController::class,'search'])->name('product_search');

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/',[CartController::class,'index'])->name('shopping_cart');
        Route::post('/add',[CartController::class, 'add'])->name('shopping_add');
        Route::delete('/remove/{rowid}',[CartController::class, 'remove'])->name('shopping_remove');
        Route::delete('/destroy',[CartController::class, 'destroy'])->name('shopping_destroy');
        Route::patch('/update/{rowid}',[CartController::class, 'update'])->name('shopping_update');
    });

    Route::get('/payment',[PaymentController::class,'index'])->name('payment');
    Route::post('pay',[PaymentController::class,'pay'])->name('pay');

    Route::group(['middleware'=>'auth'], function(){
        Route::get('/orders',[OrderController::class,'index'])->name('orders');
        Route::get('/orders/{id}',[OrderController::class,'detail'])->name('order');
        Route::post('/comment-save', [ProductController::class,'commentSave'])->name('commentSave');
    });

    Route::group(['prefix'=>'user'], function(){
        Route::get('/sign-in',[UserController::class, 'signin_form'])->name('login');
        Route::post('/sign-in',[UserController::class, 'login']);
        Route::get('/sign-up',[UserController::class, 'signup_form'])->name('sign_up');
        Route::post('/sign-up',[UserController::class, 'sign_up']);
        Route::post('/checkout',[UserController::class, 'checkout'])->name('checkout');
        Route::get('/activate/{key}',[UserController::class, 'activate'])->name('activate');
    });
});

Route::get('send-mail', function () {
    $user = \App\Models\User::find(1);
    return new App\Mail\SendMail($user);
});
