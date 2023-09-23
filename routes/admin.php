<?php

use App\Http\Controllers\Admin\PitchAreaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


Route::get('/', function () {
    return view('layout_admin.master');
})->name('welcome');

Route::group([
    'as' => 'users.',
    'prefix' => 'users',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/api', [UserController::class, 'api'])->name('api');
    Route::get('/api/name', [UserController::class, 'apiName'])->name('api.name');
    Route::get('/api/owners', [UserController::class, 'getOwner'])->name('api.owners');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::group([
    'as' => 'pitchareas.',
    'prefix' => 'pitchareas',
], function () {
    Route::get('/', [PitchAreaController::class, 'index'])->name('index');
    Route::get('/create', [PitchAreaController::class, 'create'])->name('create');
    Route::post('/store', [PitchAreaController::class, 'store'])->name('store');
   
});

