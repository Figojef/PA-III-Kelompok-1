<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PemesananController;



// Route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/jadwal', [JadwalController::class, 'getJadwalByTanggal']);
Route::get('/jadwal', [LapanganController::class, 'index']);

