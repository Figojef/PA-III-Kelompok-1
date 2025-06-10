<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class EventController extends Controller
{
    public function showEvents()
    {
        // Ambil base URL API dari .env dan hapus trailing slash jika ada
        $baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');

        // Gabungkan endpoint event dengan base URL
        $url = $baseUrl . '/event';

        // Request data ke API
        $response = Http::get($url);

        if ($response->successful()) {
            $events = $response->json();
        } else {
            $events = []; // Jika error, kirim array kosong
        }

        return view('event', ['events' => $events]); // Kirim data ke view
    }

    public function index()
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get('event');

        if ($response->successful()) {
            $data = $response->json();
            $events = $data['events'] ?? [];
        } else {
            $events = [];
            session()->flash('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Tidak dapat mengambil data event dari server.'
            ]);
        }

        return view('admin.events.index', compact('events'));
    }


    public function create(){
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $token = Session::get('jwt');

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date_format:Y-m-d|after_or_equal:tanggal_mulai',
            'gambar' => 'nullable|image|max:2048'
        ]);

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
                return back()->with('error', 'Upload gambar gagal')->withInput();
            }
        }

        // Kirim data ke API event
        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post('event', [
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'gambar' => $gambarUrl
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.events')->with('success', 'Event berhasil ditambahkan.');
        } else {
            $message = $response->json('message') ?? 'Terjadi kesalahan saat menambahkan event.';
            return back()->with('error', $message)->withInput();
        }
    }

    public function edit($id)
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get("event");

        if (!$response->successful()) {
            return redirect()->route('admin.events')->with('error', 'Gagal mengambil data event.');
        }

        $events = $response->json()['events'] ?? [];
        $event = collect($events)->firstWhere('_id', $id);

        if (!$event) {
            return redirect()->route('admin.events')->with('error', 'Event tidak ditemukan.');
        }

        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $token = Session::get('jwt');

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date_format:Y-m-d|after_or_equal:tanggal_mulai',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $gambarUrl = $request->input('old_gambar'); // default ke gambar lama

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
                return back()->with('error', 'Upload gambar gagal')->withInput();
            }
        }

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->patch('event', [
            'event_id' => $id,
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'gambar' => $gambarUrl
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui.');
        } else {
            $message = $response->json('message') ?? 'Terjadi kesalahan saat memperbarui event.';
            return back()->with('error', $message)->withInput();
        }
    }
}
