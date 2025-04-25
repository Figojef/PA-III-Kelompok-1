<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LapanganController extends Controller
{
    // public function index()
    // {
    //     $token = Session::get('jwt');
        
    //     $response = Http::withOptions([
    //         'base_uri' => env('API_URL')
    //     ])->withCookies([
    //         'jwt' => $token
    //     ], 'localhost')->get('/api/v1/lapangan');
        

    //     // Cek apakah API berhasil mengembalikan data
    //     if ($response->failed()) {
    //         $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan.';
    //         dd($errorMessage);
    //     }

    //     $lapangan = json_decode($response->body(), true);
    //     dd($lapangan);

    // }
    public function index()
    {
        $token = Session::get('jwt');
        
        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get('lapangan');
        
        
        // Cek apakah API berhasil mengembalikan data
        if ($response->failed()) {
            $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan.';
            dd($errorMessage);
        }

        $lapangans = json_decode($response->body(), true);

        // dd($lapangans);

        // dd($lapangans['data'][0]['name']);

        return view('admin.lapangan.index', compact('lapangans'));

    }

    public function create(){
        return view('admin.lapangan.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,png|max:2048'
        ]);
    
        $token = Session::get('jwt');
    
        // Upload gambar ke API
        $gambarUrl = null;
    
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');

            $response = Http::withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->attach(
                'image', file_get_contents($image), $image->getClientOriginalName()
            )->post(env('API_BASE_URL') . 'lapangan/file-upload');
    
            if ($response->successful()) {
                $gambarUrl = $response->json()['url'];
            } else {
                return back()->with('error', 'Upload gambar gagal');
            }
        }
    
        // Kirim data lapangan ke API
        $response = Http::withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post(env(key: 'API_BASE_URL') . 'lapangan', data: [
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarUrl
        ]);
    
        if ($response->successful()) {
            return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan');
        } else {
            return back()->with('error', 'Gagal menambahkan lapangan')->withInput();
        }
    }
    
    public function edit($id)
    {
        $token = Session::get('jwt');
    
        $response = Http::withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get(env('API_BASE_URL') . "lapangan");
    
        $lapangan = collect($response->json()['data'])->firstWhere('_id', $id);
    
        if (!$lapangan) {
            return redirect()->route('admin.lapangan.index')->with('error', 'Data lapangan tidak ditemukan');
        }
    
        return view('admin.lapangan.edit', compact('lapangan'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,png|max:2048'
        ]);
    
        $token = Session::get('jwt');
        $gambarUrl = $request->input('existing_gambar'); // Gambar lama default
    
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $uploadResponse = Http::withCookies([
                'jwt' => $token
            ], env('DOMAIN'))->attach(
                'image', file_get_contents($image), $image->getClientOriginalName()
            )->post(env('API_BASE_URL') . 'lapangan/file-upload');
    
            if ($uploadResponse->successful()) {
                $gambarUrl = $uploadResponse->json()['url'];
            } else {
                return back()->with('error', 'Gagal upload gambar baru')->withInput();
            }
        }
    
        $response = Http::withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->put(env('API_BASE_URL') . "lapangan/{$id}", [
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarUrl
        ]);
    
        if ($response->successful()) {
            return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diperbarui');
        } else {
            return back()->with('error', 'Gagal memperbarui lapangan')->withInput();
        }
    }


    public function test(){
        $test1 = 123;
        dd($test1);
    }

}
