<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
    
        // Kirim request ke API Node.js untuk membuat pemesanan
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $jwt,
        ])->post($baseUrl . '/pemesanan', [
            'user_id' => $user['_id'],
            'jadwal_dipesan' => $jadwal_ids,
            'total_harga' => $validated['total_harga'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);
    
        // Cek respon dari API Node.js
        if ($response->successful()) {
            // Ambil ID transaksi dan deadline dari response API
            $transactionId = $response->json()['data']['transaksi']['_id'];  // Ambil _id dari transaksi
            $deadlineUTC = $response->json()['data']['transaksi']['deadline_pembayaran'];  // Ambil waktu deadline dalam UTC
    
            // Konversi waktu deadline dari UTC ke waktu lokal
            $deadline = Carbon::parse($deadlineUTC)->setTimezone(config('app.timezone'));  // Sesuaikan dengan timezone aplikasi
    
            // Simpan transaksi dan deadline ke session (hanya untuk frontend yang membutuhkan)
            session([
                'transaction_id' => $transactionId,
                'payment_deadline' => $deadline->format('Y-m-d H:i:s'),  // Format sesuai kebutuhan
            ]);
    
            return redirect()->route('detail_pembayaran')->with('success', 'Pemesanan dan transaksi berhasil dibuat!');
        } else {
            return back()->withErrors(['Gagal membuat pemesanan dan transaksi.']);
        }
    }
    
public function showProfil()
{
    $token = Session::get('jwt'); 

    if (!$token) {
        return back()->withErrors('Token tidak ditemukan. Pastikan kamu sudah login.');
    }
    
    $baseUri = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');
    $domain = env('DOMAIN', 'localhost');
    
    $response = Http::withOptions([
        'base_uri' => $baseUri,
    ])->withCookies([
        'jwt' => $token,
    ], $domain)->get('/api/v1/pemesanan/user/pesananBelumLewatDeadline');

    if ($response->successful()) {
        $data = $response->json()['data'];

        return view('profil', compact('data'));
    } else {
        return back()->withErrors('Gagal mengambil data pemesanan.');
    }
}

// public function showProfil()
// {
//     $token = Session::get('jwt'); 

//     if (!$token) {
//         return back()->withErrors('Token tidak ditemukan. Pastikan kamu sudah login.');
//     }
    
//     $response = Http::withOptions([
//         'base_uri' => 'http://localhost:3000',
//     ])->withCookies([
//         'jwt' => $token,
//     ], 'localhost')->get('/api/v1/pemesanan/user/pesananBelumLewatDeadline');

//     if ($response->successful()) {
//         $data = $response->json()['data'];

//         return view('profil', compact('data')); // ✅ Gunakan ini
//     } else {
//         return back()->withErrors('Gagal mengambil data pemesanan.');
//     }
// }



    
    // Fungsi untuk mengambil data pemesanan berdasarkan ID transaksi
    private function getPemesananData($transactionId)
    {
        // Ambil data transaksi dan pemesanan dari API atau database
        // Contoh mengambil dari API:
        $response = Http::get("url/api/transaksi/$transactionId");
        
        if ($response->successful()) {
            return $response->json()['data'];
        }
    
        return null;
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
