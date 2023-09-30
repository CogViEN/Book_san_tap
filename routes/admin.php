<?php

use App\Http\Controllers\Admin\PitchAreaController;
use App\Http\Controllers\Admin\PitchController;
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
    Route::post('/store/owner', [UserController::class, 'storeOwner'])->name('store.owner');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::get('/check/{user?}', [UserController::class, 'checkOwner'])->name('check');
    Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::group([
    'as' => 'pitchareas.',
    'prefix' => 'pitchareas',
], function () {
    Route::get('/', [PitchAreaController::class, 'index'])->name('index');
    Route::get('/create', [PitchAreaController::class, 'create'])->name('create');
    Route::post('/store', [PitchAreaController::class, 'store'])->name('store');
    Route::get('/show/pitch/{pitcharea}', [PitchAreaController::class, 'showPitch'])->name('show.pitch');
    Route::post('/import-csv/pitches/{pitcharea}', [PitchAreaController::class, 'importCSVPitch'])->name('import_csv.pitches');
    Route::post('/import-csv/times/{pitcharea}', [PitchAreaController::class, 'importCSVTime'])->name('import_csv.times');
});

Route::group([
    'as' => 'pitches.',
    'prefix' => 'pitches',
], function () {
    Route::get('/{pitcharea}', [PitchController::class, 'index'])->name('index');
    Route::get('/create/{pitcharea}', [PitchController::class, 'create'])->name('create');
    Route::get('/edit/price/{pitcharea}', [PitchController::class, 'editPrice'])->name('edit.price');
    Route::get('/api/timeslot/cost/{pitcharea}', [PitchController::class, 'apiGetTimeSlotAndCost'])->name('api.timeslot.cost');
    Route::put('/update/timeslot/cost/{pitcharea}', [PitchController::class, 'updateTimeSlotAndCost'])->name('update.timeslot.cost');
});
