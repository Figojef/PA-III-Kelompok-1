<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LapanganController extends Controller
{
    public function index()
    {
        // Ambil data lapangan dari API
        $response = Http::get(env('API_URL') . '/api/v1/lapangan');

        // Cek apakah API berhasil mengembalikan data
        if ($response->failed()) {
            return response()->view('errors.api_error', [], 500); // Misal buat halaman error API
        }

        $lapangan = json_decode($response->body(), true);

        // Pastikan data yang diterima valid dan sesuai
        if (!isset($lapangan['data']) || !is_array($lapangan['data'])) {
            return response()->view('errors.invalid_data', [], 400); // Halaman error jika data tidak valid
        }

        // Kirim data lapangan ke view 'jadwal'
        return view('jadwal', ['lapangan' => $lapangan['data']]);
    }
}
