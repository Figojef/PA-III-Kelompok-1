<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});

Route::get('/Login', function () {
    return view('login');
});


// Route untuk menampilkan halaman jadwal dengan data dari database
Route::get('/jadwal', [LapanganController::class, 'index']);

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/reservasi', function () {
    return view('reservasi');
});


Route::get('/tentang', function () {
    return view('tentang');
});