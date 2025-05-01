<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Models\Lapangan;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TransaksiController;

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
    Route::get('/admin/lapangan', [LapanganController::class, 'index'])->name('admin.lapangan');
    Route::get('/admin/jadwal', [AdminController::class, 'jadwal'])->name('admin.jadwal');
    Route::get('/admin/pemesanan', [AdminController::class, 'pemesanan'])->name('admin.pemesanan');
});

// Membuat Pemesanan
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/pembayaran/{id}', [PembayaranController::class, 'showPaymentDetail'])->name('pembayaran.detail');




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

Route::get('/jadwal', function () {
    return view('jadwal');
});

Route::get('/register', function () {
    return view('auth/register');
});

Route::get('/detail_pesanan', function () {
    return view('detail_pesanan');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/detail_pembayaran', function () {
    return view('detail_pembayaran');
})->name('detail_pembayaran');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');




















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



// Admin
Route::middleware(['pelanggan'])->group(function () {
    Route::get('/pelanggan/test', action: [LapanganController::class, 'test'])->name('pelanggan.test');
});


