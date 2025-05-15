<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;

class MabarController extends Controller
{
   public function getMabar()
{
    $baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');
    $url = $baseUrl . '/mabar';

    $client = new Client();

    try {
        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody()->getContents(), true);

        return response()->json($data);

    } catch (RequestException $e) {
        return response()->json(['error' => 'Unable to fetch data from the API'], 500);
    }
}
    
public function showPemainFromRequest(Request $request)
{
    $mabarId = $request->query('mabarId'); // ambil dari ?mabarId=...

    if (!$mabarId) {
        abort(400, 'mabarId tidak ditemukan');
    }

    $baseUri = rtrim(env('API_BASE_URL'), '/') . '/';

    try {
        // Jika kamu perlu kirim cookie jwt, bisa aktifkan ini
        // $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => $baseUri,
        ])
        // ->withCookies(['jwt' => $token], env('DOMAIN'))
        ->get("mabar/Userbymabar/{$mabarId}");

        if ($response->failed()) {
            abort(404, 'Mabar tidak ditemukan');
        }

        $data = $response->json();

        if (!isset($data['success']) || !$data['success']) {
            abort(404, $data['message'] ?? 'Data tidak valid');
        }

        $pemain = $data['data'] ?? null;
        if (!$pemain) {
            abort(404, 'Data pemain tidak ditemukan');
        }

        $pembuat = $pemain['pembuat'] ?? null;
        $peserta = $pemain['peserta'] ?? [];
        $kapasitas = $pemain['kapasitas'] ?? null;

        $jumlahPeserta = 1 + count($peserta);

        return view('pemain_mabar', compact('pembuat', 'peserta', 'jumlahPeserta', 'kapasitas'));

    } catch (\Exception $e) {
        // Log error untuk debugging
        \Log::error('Error saat fetch data mabar: ' . $e->getMessage());
        abort(500, 'Gagal mengambil data dari API');
    }
}




    public function buatMabar(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_mabar' => 'required|string|max:255',
            'biaya' => 'required|numeric',
            'umur_min' => 'required|integer|min:0',
            'umur_max' => 'required|integer|gte:umur_min',
            'level' => 'required|string|max:50',
            'kategori' => 'required|string|max:50',
            'slot' => 'required|integer|min:1',
            'deskripsi' => 'required|string|max:1000',
            'user_id' => 'required|string', 
            'jadwal_dipesan' => 'required|array|min:1',
            'jadwal_dipesan.*' => 'required|string',
        ]);
    
        $data = [
            'nama_mabar' => $validated['nama_mabar'],
            'biaya' => $validated['biaya'],
            'range_umur' => "{$validated['umur_min']}-{$validated['umur_max']}",
            'level' => $validated['level'],
            'kategori' => $validated['kategori'],
            'slot_peserta' => $validated['slot'],
            'deskripsi' => $validated['deskripsi'],
            'user_pembuat_mabar' => $validated['user_id'],
            'jadwal' => $validated['jadwal_dipesan'],
        ];
    
        // Ambil token dan domain dari session dan env
        $jwt = Session::get('jwt');
        $domain = env('DOMAIN'); // Misalnya: 'localhost'
    
        try {
            $client = new Client();
            $apiUrl = rtrim(env('API_BASE_URL'), '/') . '/mabar';
    
            // Buat CookieJar dari array
            $cookieJar = CookieJar::fromArray([
                'jwt' => $jwt,  // Cookie jwt yang dikirim
            ], $domain);  // Menggunakan domain untuk menentukan scope cookie
    
            // Mengirim permintaan POST dengan menggunakan Guzzle
            $response = $client->post($apiUrl, [
                'json' => $data,  // Data yang dikirim dalam format JSON
                'cookies' => $cookieJar,  // Kirim cookie menggunakan CookieJar
                'headers' => [
                    'Content-Type' => 'application/json',  // Mengatur header Content-Type
                ]
            ]);
    
            // Mendapatkan body response dan mengonversinya ke array
            $responseBody = json_decode($response->getBody()->getContents(), true);
    
            if ($response->getStatusCode() === 200 && ($responseBody['success'] ?? false)) {
                return redirect('/mabar')->with('success', 'Mabar berhasil dibuat!');
            } else {
                // Debugging jika gagal
                return redirect('/mabar')->with('error', 'Gagal membuat mabar. Coba lagi.');
            }
        } catch (\Exception $e) {
            // Menampilkan exception jika terjadi error
            return redirect('/mabar')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $mabar = Mabar::with(['jadwalDipesan', 'userPembuatMabar'])->findOrFail($id);
    
        return view('detail_mabar', compact('mabar'));
    }


   public function getHistoryMabar()
{
    $baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');
    $response = Http::get("{$baseUrl}/mabar/history"); // URL API dinamis dari .env

    if ($response->successful()) {
        return response()->json($response->json());
    } else {
        return response()->json(['success' => false, 'message' => 'Gagal mengambil data.'], 500);
    }
}


public function joinMabar(Request $request)
{
    $mabarId = $request->input('mabar_id');

    if (!$mabarId) {
        return response()->json(['message' => 'ID Mabar wajib diisi.'], 400);
    }

    $token = Session::get('jwt'); // Ambil token dari session

    if (!$token) {
        return response()->json(['message' => 'Token tidak ditemukan. Silakan login.'], 401);
    }

    try {
        // Ambil userId dari payload token
        $payload = json_decode(base64_decode(explode('.', $token)[1]), true);
        $userId = $payload['id'] ?? null;


        // ✅ Debug: pastikan semua data sudah lengkap
        // dd([
        //     'mabarId' => $mabarId,
        //     'token' => $token,
        //     'userId' => $userId,
        //     'payload' => $payload,
        // ]);

        // (Nanti aktifkan bagian ini setelah test)
        
        $apiUrl = env('API_BASE_URL') . 'mabar/join';

        $response = Http::withToken($token)
            ->post($apiUrl, [
                'mabarId' => $mabarId,
                'userId' => $userId
            ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Berhasil join mabar.');
        }

        return redirect()->back()->with('error', 'Gagal join mabar: ' . json_encode($response->json()));
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function keluarMabar(Request $request)
{
    $mabarId = $request->input('mabar_id');

    if (!$mabarId) {
        return response()->json(['message' => 'ID Mabar wajib diisi.'], 400);
    }

    $token = Session::get('jwt'); // Ambil token dari session

    if (!$token) {
        return response()->json(['message' => 'Token tidak ditemukan. Silakan login.'], 401);
    }

    try {
        // Ambil userId dari payload token
        $payload = json_decode(base64_decode(explode('.', $token)[1]), true);
        $userId = $payload['id'] ?? null;

        // Endpoint API keluar mabar
        $apiUrl = env('API_BASE_URL') . 'mabar/keluar';

        $response = Http::withToken($token)
            ->post($apiUrl, [
                'mabarId' => $mabarId,
                'userId' => $userId
            ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', $response->json()['message'] ?? 'Berhasil keluar dari mabar.');
        }

        
        return redirect()->back()->with('error', 'Gagal keluar dari mabar: ' . json_encode($response->json()));

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    
}