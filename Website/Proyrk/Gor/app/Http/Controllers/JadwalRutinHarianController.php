<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JadwalRutinHarianController extends Controller
{
    //
public function index()
{
    $token = Session::get('jwt');

    // Ambil jadwal rutin harian
    $jadwalResponse = Http::withOptions([
        'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
    ])->withCookies([
        'jwt' => $token
    ], env('DOMAIN'))->get('jadwalRutinHarian');

    // Ambil semua lapangan
    $lapanganResponse = Http::withOptions([
        'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
    ])->withCookies([
        'jwt' => $token
    ], env('DOMAIN'))->get('lapangan');

    if ($jadwalResponse->failed() || $lapanganResponse->failed()) {
        return redirect()->back()->with('error', 'Gagal mengambil data.');
    }

    $jadwalRutinHarian = $jadwalResponse->json()['data'] ?? [];
    $lapangan = $lapanganResponse->json()['data'] ?? [];

    return view('admin.jadwal_rutin_harian.index', compact('jadwalRutinHarian', 'lapangan'));
}




    public function store(Request $request)
    {
        $request->validate([
            'jam' => 'required|integer|min:1|max:24',
            'harga' => 'required|numeric|min:0',
        ]);

        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post('jadwalRutinHarian', [
            'jam' => $request->jam,
            'harga' => $request->harga,
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('error', $response->json()['message'] ?? 'Gagal menambahkan jadwal.');
        }

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'jam' => 'required|integer|min:1|max:24',
            'harga' => 'required|numeric|min:0',
        ]);

        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->patch("jadwalRutinHarian/{$id}", [
            'jam' => $request->jam,
            'harga' => $request->harga,
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('error', $response->json()['message'] ?? 'Gagal memperbarui jadwal.');
        }

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->delete("jadwalRutinHarian/{$id}");

        if ($response->failed()) {
            return redirect()->back()->with('error', $response->json()['message'] ?? 'Gagal menghapus jadwal.');
        }

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }


    public function terapkan(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post('jadwalRutinHarian/terapkan-jadwal-rutin-harian', [
            'lapangan_id' => $request->lapangan_id,
            'tanggal' => $request->tanggal,
        ]);

        if ($response->failed()) {
            $message = $response->json()['message'] ?? 'Gagal menerapkan jadwal.';
            return redirect()->back()->with('error', $message);
        }

        return redirect()->back()->with('success', $response->json()['message']);
    }



}