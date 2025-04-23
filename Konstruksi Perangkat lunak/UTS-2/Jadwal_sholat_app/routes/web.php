<?php

use App\Http\Controllers\JadwalSholatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('jadwal', [JadwalSholatController::class, 'showJadwalSholat'])->name('jadwal-sholat');
