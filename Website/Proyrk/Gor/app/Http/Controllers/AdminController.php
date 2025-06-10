<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $token = Session::get('jwt');
            // dd($token);
            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
            ])->withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->get('dashboardAdmin');
            // dd($response);
            if ($response->successful()) {
                $data = $response->json();

                return view('admin.index', [
                    'totalLapangan' => $data['totalLapangan'],
                    'totalPelanggan' => $data['totalPelanggan'],
                    'totalPemesanan' => $data['totalPemesanan'],
                    'totalPemesananBerhasil' => $data['totalPemesananBerhasil'],
                    'pendapatanPerBulan' => $data['pendapatanPerBulan'],
                ]);
            } else {
                // Jika status bukan 2xx
                return back()->with('error', 'Gagal mengambil data dari API. Kode: ' . $response->status());
            }

        } catch (\Exception $e) {
            // Tangani error seperti timeout, server error, dsb.
            Log::error('Gagal mengambil data dashboard admin: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat mengambil data. Silakan coba lagi nanti.');
        }
    }


    public function daftar_pelanggan()
    {
        try {
            $token = Session::get('jwt');

            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
            ])->withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->get('dashboardAdmin/get-all-pelanggan');

            if ($response->successful()) {
                $pelanggan = $response->json();

                return view('admin.daftar-pelanggan', compact('pelanggan'));
            } else {
                return back()->with('error', 'Gagal mengambil data pelanggan. Kode: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengambil daftar pelanggan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data pelanggan.');
        }
    }

    public function catatan_transaksi($user_id)
    {
        
        try {
            $token = Session::get('jwt');

            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
            ])->withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->get("dashboardAdmin/catatan-transaksi/$user_id");

            if ($response->successful()) {
                $catatan = $response->json();
                
                return view('admin.catatan-transaksi', compact('catatan'));
            } else {
                return back()->with('error', 'Gagal mengambil catatan transaksi. Kode: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengambil catatan transaksi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data transaksi.');
        }
    }
}