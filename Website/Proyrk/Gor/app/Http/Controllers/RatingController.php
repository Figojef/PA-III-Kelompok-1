<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


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

public function show($id)
{
    // URL endpoint backend kamu
    $baseUrl = rtrim(env('API_BASE_URL'), '/'); // Contoh: http://localhost:3000/api/v1
    $apiUrl = "{$baseUrl}/rating/profil-rating/{$id}";

    // Panggil endpoint backend
    $response = Http::get($apiUrl);

    // Jika gagal ambil data, tampilkan error
    if ($response->failed()) {
        abort(404, 'Data tidak ditemukan');
    }

    // Ambil data dari response JSON
    $data = $response->json();
    $profilData = $data['data'] ?? [];

    // Kirim data ke view
    return view('informasi_pemain', [
        'user' => [
            'name' => $profilData['nama'],
            'email' => $profilData['email'],
            'nomor_telepon' => $profilData['nomor_telepon'],
        ],
        'ratings' => collect($profilData['penilaian_history_mabar'] ?? []),
        'rataRataKeseluruhan' => $profilData['rata_rata_keseluruhan_rating'] ?? null,
    ]);
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

public function showPenilaianForm(Request $request)
{
    $userId = $request->get('userId');
    $mabarId = $request->get('mabarId');
    $jwt = session('jwt');

    if (!$jwt) {
        return redirect()->route('login')->with('error', 'Anda harus login untuk memberikan rating.');
    }

    // Decode JWT payload dengan aman (tanpa library eksternal, cukup cek dasar)
    try {
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $jwt)[1])), true);
        $currentUserId = $payload['id'] ?? null;
    } catch (\Exception $e) {
        return response('User login tidak valid.', 400);
    }

    if (!$currentUserId) {
        return response('User login tidak valid.', 400);
    }

    $baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');
    $url = "$baseUrl/rating/penilaian/$userId/$mabarId";

    try {
        $response = Http::withToken($jwt)->get($url);

        if (!$response->successful()) {
            return response('Gagal mengambil data dari API.', $response->status());
        }

        $data = $response->json();

        $sudahMemberiRating = collect($data['penilaian'] ?? [])->contains(function ($rating) use ($currentUserId) {
            return isset($rating['dari_userId']) && $rating['dari_userId'] === $currentUserId;
        });

        return view('memberi_rating', [
            'data' => $data,
            'userId' => $userId,
            'mabarId' => $mabarId,
            'sudahMemberiRating' => $sudahMemberiRating,
        ]);

    } catch (\Exception $e) {
        return response('Gagal mengambil data dari API: ' . $e->getMessage(), 500);
    }
}


public function kirim(Request $request)
{
    $validated = $request->validate([
        'untuk_user' => 'required|string',
        'mabar_id' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string',
    ]);

    $token = $request->cookie('jwt') ?? session('jwt');

    if (!$token) {
        return redirect()->back()->with('error', 'Token tidak ditemukan.');
    }

$baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');

$response = Http::withToken($token)
    ->post("{$baseUrl}/api/v1/rating/", [
        'untuk_user' => $validated['untuk_user'],
        'mabar_id' => $validated['mabar_id'],
        'rating' => $validated['rating'],
        'komentar' => $validated['komentar'] ?? '',
    ]);

    if ($response->successful()) {
        // ✅ Redirect ke route yang menampilkan peserta berdasarkan mabarId
        return redirect()->route('mabar.pemainFromRequest', [
    'mabarId' => $validated['mabar_id'],
    'mode' => 'penilaian' // ⬅ Tambahkan ini
])->with('success', 'Rating berhasil dikirim.');

    } else {
        return redirect()->back()->with('error', $response->json()['message'] ?? 'Gagal mengirim rating.');
    }
}




}

