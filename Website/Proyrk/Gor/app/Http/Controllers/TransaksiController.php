<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $user = Session::get('user_data');
        $jwt = Session::get('jwt');

        if (!$user || !$jwt) {
            return redirect()->route('login')->withErrors(['Silakan login terlebih dahulu.']);
        }

        $validated = $request->validate([
            'pemesanan_id' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        $baseUrl = rtrim(env('API_BASE_URL'), '/');

        $response = Http::withToken($jwt)->post($baseUrl . '/transaksi', [
            'pemesanan_id' => $validated['pemesanan_id'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);

        if ($response->successful()) {
            return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dibuat!');
        } else {
            return back()->withErrors(['Gagal menyimpan transaksi ke API.']);
        }
    }
}
