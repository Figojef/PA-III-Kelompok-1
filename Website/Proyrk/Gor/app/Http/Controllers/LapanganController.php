<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LapanganController extends Controller
{
    public function index()
    {
        $token = Session::get('jwt');
        
        $response = Http::withOptions([
            'base_uri' => env('API_URL')
        ])->withCookies([
            'jwt' => $token
        ], 'localhost')->get('/api/v1/lapangan');
        

        // Cek apakah API berhasil mengembalikan data
        if ($response->failed()) {
            $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan.';
            dd($errorMessage);
        }

        $lapangan = json_decode($response->body(), true);
        dd($lapangan);

    }

}
