<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Models\Lapangan;

// Autentikasi


Route::middleware(['inout'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});


Route::middleware(['auth'])->group(function () {
    // Routes for authenticated users
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


// Admin
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', action: [AdminController::class, 'index'])->name('admin');
    // Route::get('/admin/lapangan', [AdminController::class, 'lapangan'])->name('admin.lapangan');


    // Lapangan
    Route::get('/admin/lapangan', [LapanganController::class, 'index'])->name('admin.lapangan.index');
    Route::get('/admin/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/admin/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/admin/lapangan/{id}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/admin/lapangan/{id}', [LapanganController::class, 'update'])->name('lapangan.update');
    









    Route::get('/admin/jadwal', [AdminController::class, 'jadwal'])->name('admin.jadwal');
    Route::get('/admin/pemesanan', [AdminController::class, 'pemesanan'])->name('admin.pemesanan');
});





// Halaman pengunjung
Route::get('/', function () {
    return view('beranda'); // Ganti dengan view dashboard Anda
})->name('dashboard');

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/reservasi', function () {
    return view('reservasi');
});

Route::get('/jadwal', [LapanganController::class, 'index']);























// Test
Route::get('/tesLapangan', [LapanganController::class, 'index']);








// Route::get('/', function () {
//     return view('reservasi');
// });



// Route::get('/registrasi', function () {
//     return view('registrasi');
// });

// Route::get('/login', function () {
//     return view('login');
// });


// Route untuk menampilkan halaman jadwal dengan data dari database

// Route::get('/admin', function () {
//     return view('admin');
// });










// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::post('/login', [AuthController::class, 'login']);

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::post('/register', [AuthController::class, 'register']);

// Route::middleware('auth')->get('/dashboard', function () {
//     return view('beranda'); // Ganti dengan view dashboard Anda
// })->name('dashboard');

// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes for guests (users who are not authenticated)


//     Route::get('/test1', [AuthController::class, 'test1']);
//     Route::get('/test2', [AuthController::class, 'test2']);



//     Route::get('/register', function () {
//         return view('auth.register');
//     })->name('register');

//     Route::post('/register', [AuthController::class, 'register']);
    

// Route::middleware(['auth'])->group(function () {
//     // Routes for authenticated users
//     Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// });




