<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;



class AdminJadwalController extends Controller
{
    //
 public function index(Request $request)
    {
        $token = Session::get('jwt');

        // Ambil semua lapangan
        $lapanganResponse = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get('lapangan');

        $lapanganList = $lapanganResponse->json()['data'] ?? [];

        $selectedLapangan = $request->lapangan_id ?? ($lapanganList[0]['_id'] ?? null);
        $selectedTanggal = $request->tanggal ?? now()->format('Y-m-d');

        // dd($selectedLapangan);
        // dd($selectedTanggal);
        $jadwalList = [];

        if ($selectedLapangan && $selectedTanggal) {
        $jadwalResponse = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post('jadwal/admin/jadwal-by-lapangan-dan-tanggal', [
            'lapangan' => $selectedLapangan,
            'tanggal' => $selectedTanggal,
        ]);


            if ($jadwalResponse->ok()) {
                $jadwalList = $jadwalResponse->json();
            }
        }

        return view('admin.jadwal.index', compact(
            'lapanganList',
            'selectedLapangan',
            'selectedTanggal',
            'jadwalList'
        ));
    }


public function editHarga(Request $request)
{
    $request->validate([
        'jadwal_id' => 'required|string',
        'harga' => 'required|numeric|min:0',
    ]);

    try {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->patch('jadwal/admin/edit-harga-jadwal', [
            'jadwal_id' => $request->jadwal_id,
            'harga' => $request->harga
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Harga jadwal berhasil diperbarui.'
            ]);
        } else {
            $errorMsg = $response->json('message') ?? 'Terjadi kesalahan saat mengedit harga.';
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => $errorMsg
            ]);
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'title' => 'Error!',
            'message' => $e->getMessage()
        ]);
    }
}

}