<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PemesananController extends Controller
{
    protected $apiUrl = 'http://localhost:3000/api/v1/pemesanan';

    // Ambil semua pemesanan (GET)
    public function index()
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->post('pemesanan');

        return response()->json($response->json(), $response->status());
    }

    // Buat pemesanan baru (POST)
    public function store(Request $request)
{
    // Ambil token JWT dari session
    $token = Session::get('jwt');

    // Validasi data request
    $request->validate([
        'jadwal_dipesan' => 'required|array',
        'total_harga' => 'required|numeric',
    ]);

    logger("Payload untuk API:", $request->all());

    // Kirim data ke API eksternal
    $response = Http::withCookies([
        'jwt' => $token
    ], env('DOMAIN'))
    ->post($this->apiUrl, [
        'user_id' => auth()->id(), // ID user yang sedang login
        'jadwal_dipesan' => $request->jadwal_dipesan, // Jadwal yang dipilih
        'total_harga' => $request->total_harga,       // Total harga
        'status_pemesanan' => $request->status_pemesanan, // Status pemesanan
    ]);

    // Jika request berhasil
    if ($response->successful()) {
        return response()->json($response->json(), $response->status());
    } else {
        // Jika gagal
        return response()->json([
            'message' => 'Gagal membuat pemesanan',
            'error' => $response->json()
        ], $response->status());
    }
}

    
    

    // Ambil detail satu pemesanan (GET by ID)
    public function show($id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->get("$this->apiUrl/$id");

        return response()->json($response->json(), $response->status());
    }

    // Update pemesanan (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->put("$this->apiUrl/$id", $request->all());

        return response()->json($response->json(), $response->status());
    }

    // Hapus pemesanan (DELETE)
    public function destroy($id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->delete("$this->apiUrl/$id");

        return response()->json($response->json(), $response->status());
    }
}
