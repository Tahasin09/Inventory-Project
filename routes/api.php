<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationAPIMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name(name: 'userLogin');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name(name: 'sendOTPCode');
Route::get('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerificationAPIMiddleware::class])->name(name: 'resetPassword');
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationAPIMiddleware::class])->name(name: 'resetPassword');
Route::post('/update-profile', [UserController::class, 'userUpdateProfile'])->middleware([TokenVerificationAPIMiddleware::class])->name(name: 'resetPassword');
