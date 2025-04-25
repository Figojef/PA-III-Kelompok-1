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
        $user = Session::get('user_data');
        $jwt = Session::get('jwt');
    
        if (!$user || !$jwt) {
            return redirect()->route('login')->withErrors(['Silakan login terlebih dahulu.']);
        }
    
        $validated = $request->validate([
            'jadwal_dipesan' => 'required|json',
            'total_harga' => 'required|numeric',
            'status_pemesanan' => 'required|string',
        ]);
    
        $jadwal = json_decode($validated['jadwal_dipesan'], true);

        $baseUrl = rtrim(env('API_BASE_URL'), '/');
        
        $response = Http::withToken($jwt)->post($baseUrl . '/pemesanan', [
            'user_id' => $user['_id'],
            'jadwal_dipesan' => $jadwal,
            'total_harga' => $validated['total_harga'],
            'status_pemesanan' => $validated['status_pemesanan'],
        ]);

    
    
        if ($response->successful()) {
            return redirect()->route('dashboard')->with('success', 'Pemesanan berhasil dibuat!');
        } else {
            return back()->withErrors(['Gagal menyimpan pemesanan ke API.']);
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
