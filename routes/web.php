<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;


//user
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name(name: 'userLogin');
Route::get('/logout', [UserController::class, 'userLogout'])->name(name: 'userLogout');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name(name: 'sendOTPCode');
Route::post('/verify-otp', [UserController::class, 'verifyOTPCode'])->name(name: 'verifyOTPCode');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerificationMiddleware::class])->name(name: 'resetPassword');
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationMiddleware::class])->name(name: 'resetPassword');
Route::post('/update-profile', [UserController::class, 'userUpdateProfile'])->middleware([TokenVerificationMiddleware::class])->name(name: 'resetPassword');



//category

Route::post('/create-category', [CategoryController::class, 'categoryCreate'])->middleware([TokenVerificationMiddleware::class])->name(name: 'createCategory');
Route::post('/update-category', [CategoryController::class, 'categoryUpdate'])->middleware([TokenVerificationMiddleware::class])->name(name: 'updateCategory');
Route::post('/delete-category', [CategoryController::class, 'categoryDelete'])->middleware([TokenVerificationMiddleware::class])->name(name: 'deleteCategory');
Route::get('/list-category', [CategoryController::class, 'categoryList'])->middleware([TokenVerificationMiddleware::class])->name(name: 'listCategory');
Route::post('/category-by-id', [CategoryController::class, 'categoryByID'])->middleware([TokenVerificationMiddleware::class])->name(name: 'categoryByID');


//customer

Route::post('/create-customer', [CustomerController::class, 'customerCreate'])->middleware([TokenVerificationMiddleware::class])->name(name: 'createCustomer');
Route::post('/update-customer', [CustomerController::class, 'customerUpdate'])->middleware([TokenVerificationMiddleware::class])->name(name: 'updateCustomer');
Route::post('/delete-customer', [CustomerController::class, 'customerDelete'])->middleware([TokenVerificationMiddleware::class])->name(name: 'deleteCustomer');
Route::get('/list-customer', [CustomerController::class, 'customerList'])->middleware([TokenVerificationMiddleware::class])->name(name: 'listCustomer');
Route::post('/customer-by-id', [CustomerController::class, 'customerByID'])->middleware([TokenVerificationMiddleware::class])->name(name: 'customerByID');
