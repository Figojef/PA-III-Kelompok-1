<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;

Route::get('/registrasi', function () {
    return view('registrasi');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('beranda');
});

// Route untuk menampilkan halaman jadwal dengan data dari database
Route::get('/jadwal', [LapanganController::class, 'index']);

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/reservasi', function () {
    return view('reservasi');
});

Route::get('/reservasi', function () {
    return view('reservasi');
});

Route::get('/tentang', function () {
    return view('tentang');
});