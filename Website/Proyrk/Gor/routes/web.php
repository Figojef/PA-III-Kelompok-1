<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MabarController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\KelolaPemesanan;
use App\Http\Controllers\InfoKontakController;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\JadwalRutinHarianController;


// Autentikasi


Route::middleware(['inout'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Register routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});




Route::middleware(['auth'])->group(function () {
    //Update Profil
Route::post('/profil/update', [AuthController::class, 'updateProfile'])->name('profil.update');

    // Routes for authenticated users
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Rute logout setelah update profil
Route::get('/logout-update', [AuthController::class, 'logoutAfterUpdate'])->name('logout.update');

});

Route::get('/profil', [PemesananController::class, 'showProfil'])->name('profil')->middleware('auth');




// Admin
Route::middleware(['admin'])->group(function () {
   Route::get(uri: '/admin', action: [AdminController::class, 'index'])->name('admin');
   Route::get('/admin/daftar-pelanggan', [AdminController::class, 'daftar_pelanggan'])->name('admin.daftar-pelanggan');
   Route::get('/admin/catatan-transaksi/{user_id}', [AdminController::class, 'catatan_transaksi'])->name('admin.catatan-transaksi');
    // Route::get('/admin/lapangan', [AdminController::class, 'lapangan'])->name('admin.lapangan');
    
    // Lapangan
    Route::get('/admin/lapangan', [LapanganController::class, 'index'])->name('admin.lapangan.index');
    Route::get('/admin/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/admin/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/admin/lapangan/{id}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/admin/lapangan/{id}', [LapanganController::class, 'update'])->name('lapangan.update');
    
    // Kelola Pemesanan
    Route::get('/admin/kelola/pemesanan/index', [KelolaPemesanan::class, 'index'])->name('admin.kelola.pemesanan.index');
    Route::get('/admin/kelola/pemesanan/konfirmasi-pemesanan', [KelolaPemesanan::class, 'konfirmasi_pemesanan'])->name('admin.kelola.pemesanan.konfirmasi-pemesanan');
    Route::post('admin/kelola/pemesanan/tolak/{id}', [KelolaPemesanan::class, 'tolak_pemesanan'])->name('admin.kelola.pemesanan.tolak-pemesanan');

    // Jadwal Rutin Harian
    Route::get('/admin/jadwal-rutin-harian', [JadwalRutinHarianController::class, 'index'])->name('admin.jadwal-rutin-harian.index');
    Route::post('/admin/jadwal-rutin-harian/store', [JadwalRutinHarianController::class, 'store'])->name('admin.jadwal-rutin-harian.store');
    Route::patch('/admin/jadwal-rutin-harian/{id}', [JadwalRutinHarianController::class, 'update'])->name('admin.jadwal-rutin-harian.update');
    Route::delete('/admin/jadwal-rutin-harian/{id}', [JadwalRutinHarianController::class, 'destroy'])->name('admin.jadwal-rutin-harian.delete');
    Route::post('/admin/jadwal-rutin-harian/terapkan', [JadwalRutinHarianController::class, 'terapkan'])->name('admin.jadwal-rutin-harian.terapkan');

    // Kelola Jadwal
    Route::get('/admin/jadwal', [AdminJadwalController::class, 'index'])->name('admin.jadwal');
    Route::patch('/admin/jadwal/edit-harga', [AdminJadwalController::class, 'editHarga'])->name('admin.jadwal.editHarga');

    // Kelola Event Admin
    Route::get('/admin/events', action: [EventController::class, 'index'])->name('admin.events');
    Route::get('/admin/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::patch('/admin/events/{id}', [EventController::class, 'update'])->name('admin.events.update');

    // Kelola Tentang Admin
    Route::get('/admin/tentang', action: [TentangController::class, 'index'])->name('admin.tentang.index');
    Route::post('admin/tentang', [TentangController::class, 'store'])->name('admin.tentang.store');
    Route::patch('admin/tentang/{id}', [TentangController::class, 'update'])->name('admin.tentang.update');
    Route::delete('admin/tentang/{id}', [TentangController::class, 'destroy'])->name('admin.tentang.destroy');

    // Kelola Info Kontak Admin
        Route::get('/admin/info-kontak', action: [InfoKontakController::class, 'index'])->name('admin.info-kontak.index');
    Route::post('admin/info-kontak', [InfoKontakController::class, 'update'])->name('admin.info-kontak.update');
    // Route::patch('admin/tentang/{id}', [TentangController::class, 'update'])->name('admin.tentang.update');
    // Route::delete('admin/tentang/{id}', [TentangController::class, 'destroy'])->name('admin.tentang.destroy');


    Route::get('/admin/pemesanan', action: [AdminController::class, 'pemesanan'])->name('admin.pemesanan');
});


// Membuat Pemesanan
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
// Mabar
//Menampilkan Mabar

Route::get('/mabar', [MabarController::class, 'getMabar']);


//Membuat Mabar
Route::post('/buat-mabar', [MabarController::class, 'buatMabar'])->name('mabar.buat-mabar');

// Detail Mabar
Route::get('/mabar/detail/{id}', function ($id) {
    return view('detail_mabar', ['mabarId' => $id]);
})->name('mabar.detail');

// mabar yang sudah lewat
Route::get('/api/v1/mabar/history/{userId}', [MabarController::class, 'getHistoryMabar']);

// web.php
Route::get('/mabar/pemain', [MabarController::class, 'showPemainFromRequest'])->name('mabar.pemainFromRequest');

Route::get('/pemain_mabar', [MabarController::class, 'showPeserta'])->name('mabar.pemain.list'); // ubah nama route


// Join Mabar
Route::post('/mabar/join', [MabarController::class, 'joinMabar'])->name('mabar.join');

//Keluar Mabar
Route::post('/mabar/keluar', [MabarController::class, 'keluarMabar'])->name('mabar.keluar');

// Menampilkan Pemain permabar
Route::get('/mabar/pemain/{mabarId}', [MabarController::class, 'showPemain'])->name('mabar.pemain');

// Menampilkan Rating User
Route::get('/informasi-pemain/{id}', [RatingController::class, 'show'])->name('informasi.pemain');


// Halaman detail rating untuk satu mabar tertentu
Route::get('/rating/mabar/{mabarId}', [RatingController::class, 'showRatingDetail'])->name('informasi.rating.detail');

// GET: Menampilkan form
Route::get('/memberi-rating', [RatingController::class, 'showPenilaianForm'])->name('rating.form');

// POST: Mengirim rating ke API
Route::post('/kirim-rating', [RatingController::class, 'kirim'])->name('rating.kirim');



//Menampilkan Event
Route::get('/event', [EventController::class, 'showEvents']);

// Halaman pengunjung
Route::get('/', function () {
    return view('beranda'); 
})->name('dashboard');


Route::get('/tentang', function () {
    return view('tentang');
});



Route::get('/reservasi', function () {
    return view('reservasi');
})->name('reservasi');

Route::get('/jadwal', function () {
    return view('jadwal');
});

Route::get('/informasi_pemain', function () {
    return view('informasi_pemain');
});

Route::get('/informasi_ratingpemain', function () {
    return view('informasi_ratingpemain');
});


Route::get('/register', function () {
    return view('auth/register');
});



// Route::get('/event', function () {
//     return view('event');
// });

Route::get('/detail_pesanan', function () {
    return view('detail_pesanan');
});

// Route::get('/memberi-rating', function () {
//     return view('memberi_rating');
// });

Route::get('/mabar', function () {
    return view('mabar');
})->name('mabar');

Route::get('/detail_status', function () {
    return view('detail_status');
})->name('detail_status');


Route::get('/detail_mabar', function () {
    return view('detail_mabar');
})->name('detail_mabar');

Route::get('/tambahMabar', function () {
    return view('tambahMabar');
})->name('tambahMabar');

Route::get('/upload-bukti/{id}', [TransaksiController::class, 'showUploadForm']);

Route::get('/detail_pembayaran', [TransaksiController::class, 'detailPembayaran'])->name('detail.pembayaran');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::patch('/pemesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])
    ->middleware('auth')
    ->name('pemesanan.batalkan');



















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


Route::get('/detail-status', [PemesananController::class, 'showDetailStatus'])->name('profil.detailStatus');
