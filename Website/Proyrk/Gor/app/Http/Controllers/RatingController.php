<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RatingController extends Controller
{
public function showInformasiPemain($userId)
{
    $baseUrl = rtrim(env('API_BASE_URL'), '/');
    $apiUrl = $baseUrl . "/rating/user/{$userId}/mabar-ratings";

    $response = Http::get($apiUrl);

    if ($response->failed()) {
        abort(500, 'Gagal mengambil data pemain');
    }

    $data = $response->json();
    $ratings = $data['data'] ?? [];
    $user = $ratings[0]['user'] ?? null; // Ambil data user dari response pertama

    // Pastikan user ada
    if (!$user) {
        abort(404, 'Data pengguna tidak ditemukan');
    }

    return view('informasi_pemain', compact('ratings', 'user'));
}



public function showRatingDetail($mabarId, Request $request)
{
    // Ambil ID user yang dinilai dari query parameter
    $userId = $request->query('user'); // Misalnya ?user=68201efc0992965882d48537

    if (!$userId) {
        abort(400, 'Parameter user wajib diisi.');
    }

    // URL endpoint backend kamu
    $baseUrl = rtrim(env('API_BASE_URL'), '/'); // Contoh: http://localhost:3000/api/v1
    $apiUrl = "{$baseUrl}/mabar/{$mabarId}/detail-with-rating?untuk_user={$userId}";

    // Panggil endpoint backend
    $response = Http::get($apiUrl);

    // Jika gagal ambil data, tampilkan error
    if ($response->failed()) {
        abort(500, 'Gagal mengambil data detail mabar dari API');
    }

    // Ambil data dari response JSON
    $data = $response->json();
    $mabarDetail = $data['data'] ?? [];

    // Kirim data ke view
    return view('informasi_ratingpemain', compact('mabarDetail'));
}

}

