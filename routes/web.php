<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/magazines/active', [MagazineController::class, 'homeMagazines'])->name('home.magazines.all');

    Route::get('/detail/{magazines_id}', [MagazineController::class, 'magazineList'])->name('magazines.detail');

Route::middleware('isUser')->group(function () {

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/payment', [OrderController::class, 'paymentPage'])->name('orders.paymentPage');
    Route::get('/orders/payment-proof/{id}', [OrderController::class, 'paymentProof'])->name('orders.paymentProof');
    Route::post('/orders/upload-proof/{id}', [OrderController::class, 'uploadPaymentProof'])->name('orders.uploadProof');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
     // Di web.php
    Route::get('/my-magazines', [MagazineController::class, 'purchased'])->name('magazines.purchased');
});


Route::middleware('isGuest')->group(function(){
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/SignUp', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/SignUp', [UserController::class, 'register'])//akan di simpan table user
->name('signup.send_data');//sifatnya unik

Route::post('/auth', [UserController::class, 'authentication'])
->name('auth');
});

//Logout
Route::get('/logout', [UserController::class, 'logout'])
->name('logout');

Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function(){
    Route::get('/dashboard', function () {
     return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('/magazines')->name('magazines.')->group(function(){
    Route::get('/index', [MagazineController::class, 'index'])->name('index');
    Route::get('/create', [MagazineController::class, 'create'])->name('create');
    Route::post('/store', [MagazineController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [MagazineController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [MagazineController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [MagazineController::class, 'destroy'])->name('delete');
    Route::patch('/patch/{id}', [MagazineController::class, 'patch'])->name('patch');
    Route::get('trash', [MagazineController::class, 'trash'])->name('trash');
    Route::patch('/restore/{id}', [MagazineController::class, 'restore'])->name('restore');
    Route::delete('/delete-permanent/{id}', [MagazineController::class, 'deletePermanent'])->name('delete_permanent');
    Route::get('/export', [MagazineController::class, 'export'])->name('export');
    Route::get('/datatables', [MagazineController::class, 'datatables'])->name('datatables');
    });

    Route::prefix('/users')->name('users.')->group(function(){
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    Route::get('trash', [UserController::class, 'trash'])->name('trash');
    Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
    Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    Route::prefix('/promos')->name('promos.')->group(function() {
        Route::resource('promos', PromoController::class);
    Route::get('/',[PromoController::class, 'index'])->name('index');
    Route::get('/create', [PromoController::class, 'create'])->name('create');
    Route::post('/store', [PromoController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PromoController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PromoController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PromoController::class, 'destroy'])->name('delete');
    Route::get('trash', [PromoController::class, 'trash'])->name('trash');
    Route::patch('/restore/{id}', [PromoController::class, 'restore'])->name('restore');
    Route::delete('/delete-permanent/{id}', [PromoController::class, 'deletePermanent'])->name('delete_permanent');
    Route::get('/export', [PromoController::class, 'export'])->name('export');

    });
 });

Route::prefix('/staff')->name('staff.')->group(function() {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
  });
