<?php

use App\Http\Controllers\EndUser\HomepageController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomepageController::class, 'index'])->name('index');

Route::get('/detail/{id}', [HomepageController::class, 'detail'])->name('detail');