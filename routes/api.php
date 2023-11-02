<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EndUser\HomepageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/cityAndDistrict', [HomepageController::class, 'getCityAndDistrict'])->name('cityAndDistrict');
Route::get('/apiPitchArea', [HomepageController::class, 'apiPitchArea'])->name('apiPitchArea');
Route::get('/getPitch/{id}', [HomepageController::class, 'getPitch'])->name('getPitch');
Route::get('/getTimeSLots/{pitch_area}', [HomepageController::class, 'getTimeSLots'])->name('timeslots');
