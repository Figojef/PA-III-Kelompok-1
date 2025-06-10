<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class KelolaPemesanan extends Controller
{
    //
    public function index()
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])
        ->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))
        ->get('pemesanan/admin/kelola/pemesanan/index');

        if ($response->failed()) {
            $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan.';
            dd($errorMessage);
        }

        $pemesananData = $response->json()['data'];

        return view('admin.pemesanan.index', compact('pemesananData'));
    }

    public function konfirmasi_pemesanan(Request $request)
    {

        // dd($request->query('id'));
        // Ambil ID pemesanan dari query parameter
        $id = $request->query('id');

        // Ambil token JWT dari session
        $token = Session::get('jwt');

        // Kirim request ke backend dengan base URL yang sesuai
        try {
            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/', // API base URL
            ])
            ->withCookies([
                'jwt' => $token, // Mengirimkan token JWT
            ], env('DOMAIN')) // Nama domain untuk cookies (sesuaikan jika diperlukan)
            ->patch('pemesanan/admin/kelola/pemesanan/konfirmasi-pemesanan/' . $id); // Endpoint API backend

            // Cek apakah request berhasil
            if ($response->successful()) {
                session()->flash('alert', [
                    'type' => 'success',
                    'title' => 'Cek',
                    'message' => 'Berhasil konfirmasi pemesanan',
                ]);
            } else {
                // Jika backend merespon gagal, tampilkan error
                session()->flash('alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => $response->json()['message'] ?? 'Terjadi kesalahan saat konfirmasi pemesanan',
                ]);
            }
        } catch (\Exception $e) {
            // Tangani error jika ada masalah saat request ke backend
            session()->flash('alert', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat menghubungi server: ' . $e->getMessage(),
            ]);
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }
    
    // public function tolak_pemesanan(Request $request)
    // {

    //     // dd($request->query('id'));
    //     // Ambil ID pemesanan dari query parameter
    //     $id = $request->query('id');

    //     // // Ambil token JWT dari session
    //     $token = Session::get('jwt');

    //     // Kirim request ke backend dengan base URL yang sesuai
    //     try {
    //         $response = Http::withOptions([
    //             'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/', // API base URL
    //         ])
    //         ->withCookies([
    //             'jwt' => $token, // Mengirimkan token JWT
    //         ], env('DOMAIN')) // Nama domain untuk cookies (sesuaikan jika diperlukan)
    //         ->patch('pemesanan/admin/kelola/pemesanan/tolak-pemesanan/' . $id); // Endpoint API backend

    //         // Cek apakah request berhasil
    //         if ($response->successful()) {
    //             session()->flash('alert', [
    //                 'type' => 'success',
    //                 'title' => 'Cek',
    //                 'message' => 'Berhasil Menolak pemesanan',
    //             ]);
    //         } else {
    //             // Jika backend merespon gagal, tampilkan error
    //             session()->flash('alert', [
    //                 'type' => 'error',
    //                 'title' => 'Error',
    //                 'message' => $response->json()['message'] ?? 'Terjadi kesalahan saat menolak pemesanan',
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         // Tangani error jika ada masalah saat request ke backend
    //         session()->flash('alert', [
    //             'type' => 'error',
    //             'title' => 'Error',
    //             'message' => 'Terjadi kesalahan saat menghubungi server: ' . $e->getMessage(),
    //         ]);
    //     }

    //     // Kembali ke halaman sebelumnya
    //     return redirect()->back();
    // }

    
    public function tolak_pemesanan(Request $request) 
    {
        $id = $request->route('id'); // dari route parameter
        $token = Session::get('jwt');

        try {
            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
            ])
            ->withCookies(['jwt' => $token], env('DOMAIN'))
            ->patch('pemesanan/admin/kelola/pemesanan/tolak-pemesanan/' . $id, [
                'alasan_penolakan' => $request->input('alasan_penolakan'),
            ]);

            if ($response->successful()) {
                session()->flash('alert', [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Pemesanan berhasil ditolak.',
                ]);
            } else {
                session()->flash('alert', [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => $response->json()['message'] ?? 'Terjadi kesalahan saat menolak pemesanan',
                ]);
            }
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Gagal terhubung ke server: ' . $e->getMessage(),
            ]);
        }

        return redirect()->back();
    }


}