<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController2 extends Controller
{

    public function index() {
        $client = new Client();
        $url = "http://localhost:3000/api/v1/auth"; 
        $response = $client->request('POST',$url);
        dd($response);
    }


    public function register(Request $request) 
    {
        $url = "http://localhost:3000/api/v1/auth/register"; // URL API Node.js
    
        $response = Http::post($url, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
    
        return response()->json($response->json(), $response->status());
    }

    public function login(Request $request) 
{
    try {
        $url = "http://localhost:3000/api/v1/auth/login"; // URL API Node.js

        $response = Http::post($url, [
            'name' => $request->name,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['jwt'])) { 
                session()->put('jwt', $data['jwt']); 

                return response()->json([
                    'message' => 'Login berhasil',
                    'token' => $data['jwt']
                ], 200);
            } else {
                return response()->json(['error' => 'Token tidak ditemukan.'], 400);
            }
        }

        return response()->json(['error' => 'Login gagal. Periksa kembali kredensial Anda.'], 400);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Terjadi kesalahan',
            'message' => $e->getMessage()
        ], 500);
    }
}   
    

}
