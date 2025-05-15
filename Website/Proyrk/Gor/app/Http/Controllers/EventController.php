<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function showEvents()
    {
        $response = Http::get('http://localhost:3000/api/v1/event');

        if ($response->successful()) {
            $events = $response->json(); // Ambil data JSON dari API
        } else {
            $events = []; // Jika error, kirim array kosong
        }
        return view('event', ['events' => $events]); // <- WAJIB
    }
}