<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LapanganController;


// Route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/jadwal', [JadwalController::class, 'getJadwalByTanggal']);
Route::get('/jadwal', [LapanganController::class, 'index']);
