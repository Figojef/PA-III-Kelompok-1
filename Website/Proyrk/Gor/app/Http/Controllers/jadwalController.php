<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class JadwalController extends Controller
{
    public function getJadwalByTanggal($tanggal) 
    {
        try {
            $client = new Client([
                'base_uri' => 'http://127.0.0.1:3000/', // Pakai 127.0.0.1
                'timeout'  => 5.0, // Biar nggak lama
            ]);

            // URL lengkap
            $url = "api/v1/jadwal/tanggal/{$tanggal}";

            // Kirim request GET
            $response = $client->request('GET', $url);

            // Ambil respons JSON
            $data = json_decode($response->getBody(), true);

            return response()->json($data, $response->getStatusCode());

        } catch (RequestException $e) {
            // Tangani jika API error
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                $message = json_decode($e->getResponse()->getBody(), true);
                return response()->json(['error' => $message], $statusCode);
            }

            return response()->json(['error' => 'Terjadi kesalahan saat mengakses API'], 500);
        }
    }
}
