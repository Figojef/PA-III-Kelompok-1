<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LapanganController extends Controller
{
    public function index()
    {
        // Ambil data dari API
        $response = Http::get(env('API_URL') . '/api/v1/lapangan');

        // Decode JSON ke array
        $lapangan = json_decode($response->body(), true);

        // Pastikan response berisi data
        if (!is_array($lapangan) || !isset($lapangan['data'])) {
            dd("Error: API tidak mengembalikan data yang sesuai", $response->body());
        }

        // Kirim hanya bagian "data" ke Blade
        return view('jadwal', ['lapangan' => $lapangan['data']]);
    }
}
