<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
