<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class InfoKontakController extends Controller
{
    public function index()
    {
        try {
            $token = Session::get('jwt');
            
            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
            ])->withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->get('infoKontakGor');

            if ($response->successful()) {
                $data = $response->json();
                $infoKontak = isset($data['data']) && count($data['data']) > 0 ? $data['data'][0] : null;
                
                return view('admin.info-kontak.index', compact('infoKontak'));
            } else {
                return view('admin.info-kontak.index')->with('error', 'Gagal mengambil data info kontak');
            }
        } catch (\Exception $e) {
            return view('admin.info-kontak.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'nomor_whatsapp' => 'required|string',
            'nomor_rekening' => 'required|numeric',
            'atas_nama' => 'required|string',
            'nama_bank' => 'required|string',
        ]);

        try {
            $token = Session::get('jwt');
            
            // Assuming you have an update endpoint, adjust the URL accordingly
            $response = Http::withOptions([
                'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
            ])->withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->patch('infoKontakGor/update/68347b0100a76b6acbbc39d8', [
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'nomor_rekening' => $request->nomor_rekening,
                'atas_nama' => $request->atas_nama,
                'nama_bank' => $request->nama_bank,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Info kontak berhasil diperbarui');
            } else {
                // dd($response);
                return redirect()->back()->with('error', 'Gagal memperbarui info kontak');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}