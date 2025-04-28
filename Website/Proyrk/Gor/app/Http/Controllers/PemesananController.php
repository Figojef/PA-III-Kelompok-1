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
        // Ambil user dan token dari session
        $user = Session::get('user_data');
        $jwt = Session::get('jwt');
    
        if (!$user || !$jwt) {
            return redirect()->route('login')->withErrors(['Silakan login terlebih dahulu.']);
        }
    
        // Validasi data dari form
        $validated = $request->validate([
            'jadwal_dipesan' => 'required|json',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            'status_pemesanan' => 'required|string',
        ]);
    
        // Decode jadwal_dipesan dari JSON
        $jadwal = json_decode($validated['jadwal_dipesan'], true);
    
        // Ambil hanya _id dari setiap slot
        $jadwal_ids = array_map(function ($item) {
            return $item['_id'];
        }, $jadwal);
    
        // Base URL backend Node.js
        $baseUrl = rtrim(env('API_BASE_URL'), '/');
    
        // Kirim request ke API Node.js
        $response = Http::withToken($jwt)->post($baseUrl . '/pemesanan', [
            'user_id' => $user['_id'],
            'jadwal_dipesan' => $jadwal_ids, // ⬅️ Ini sekarang array of string ID
            'total_harga' => $validated['total_harga'],
            'status_pemesanan' => $validated['status_pemesanan'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);
    
        // Cek respon
        if ($response->successful()) {
            return redirect()->route('dashboard')->with('success', 'Pemesanan dan transaksi berhasil dibuat!');
        } else {
            return back()->withErrors(['Gagal membuat pemesanan dan transaksi.']);
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
