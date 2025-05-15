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

        return view('informasi_pemain', compact('ratings'));
    }
}