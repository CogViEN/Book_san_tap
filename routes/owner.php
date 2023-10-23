<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\PitchController;
use App\Http\Controllers\Owner\PitchAreaController;
use App\Http\Controllers\Owner\AppointmentController;

Route::get('/', function () {
    return view('layout_owner.master');
})->name('welcome');

Route::group([
    'as' => 'pitchareas.',
    'prefix' => 'pitchareas',
], function () {
    Route::get('/', [PitchAreaController::class, 'index'])->name('index');
    Route::get('/create', [PitchAreaController::class, 'create'])->name('create');
    Route::post('/store', [PitchAreaController::class, 'store'])->name('store');
    Route::get('/show/pitch/{pitcharea}', [PitchAreaController::class, 'showPitch'])->name('show.pitch');
    Route::get('/edit/info/{pitchArea}', [PitchAreaController::class, 'editInfo'])->name('edit.info');
    Route::post('/import-csv/pitches/{pitcharea}', [PitchAreaController::class, 'importCSVPitch'])->name('import_csv.pitches');
    Route::post('/import-csv/times/{pitcharea}', [PitchAreaController::class, 'importCSVTime'])->name('import_csv.times');
    Route::get('/api/get/', [PitchAreaController::class, 'getPitchArea'])->name('api.get');
});

Route::group([
    'as' => 'pitches.',
    'prefix' => 'pitches',
], function () {
    Route::get('/{pitcharea}', [PitchController::class, 'index'])->name('index');
    Route::get('/destroy/{pitcharea}', [PitchController::class, 'destroy'])->name('destroy');
    Route::post('/store/{pitcharea}', [PitchController::class, 'store'])->name('store');
    Route::get('/edit/price/{pitcharea}', [PitchController::class, 'editPrice'])->name('edit.price');
    Route::get('/api/timeslot/cost/{pitcharea}', [PitchController::class, 'apiGetTimeSlotAndCost'])->name('api.timeslot.cost');
    Route::put('/update/timeslot/cost/{pitcharea}', [PitchController::class, 'updateTimeSlotAndCost'])->name('update.timeslot.cost');
    Route::get('/api/get/{pitchArea}', [PitchController::class, 'getPitch'])->name('api.get');
});

Route::group([
    'as' => 'appointments.',
    'prefix' => 'appointments',
],function (){
    Route::get('/index', [AppointmentController::class, 'index'])->name('index');
    Route::get('/abort/{id}', [AppointmentController::class, 'abort'])->name('abort');
    Route::get('/accept/{id}', [AppointmentController::class, 'accept'])->name('accept');
    Route::get('/create', [AppointmentController::class, 'create'])->name('create');
    Route::get('/api/timeslot/free', [AppointmentController::class, 'getTimeslotFree'])->name('api.get.timeslot.free');
    Route::post('/store', [AppointmentController::class, 'store'])->name('store');
});
