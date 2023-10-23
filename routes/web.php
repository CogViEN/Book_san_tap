<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'processLogin'])->name('process_login');
Route::post('/register', [AuthController::class, 'processRegister'])->name('process_register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('test', [TestController::class,'test']);


Route::get('auth/facebook', [AuthController::class, 'facebookpage'])->name('auth.facebook');
Route::get('auth/google', [AuthController::class, 'googlepage'])->name('auth.google');

Route::get('auth/facebook/callback', [AuthController::class, 'facebookredirect']);

Route::get('auth/google/callback', [AuthController::class, 'googleredirect']);


