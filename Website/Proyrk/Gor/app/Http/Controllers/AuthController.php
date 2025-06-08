<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Endpoint backend autentikasi
    // protected $authUrl = 'http://localhost:3000/api/v1/auth';
    protected $authUrl;

    public function __construct(){
        $this->authUrl = env('API_BASE_URL') . 'auth';
    }


    // Fungsi Register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nomor_whatsapp' => 'required|string'
        ]);

        // Kirim data ke backend untuk register
        $response = Http::post($this->authUrl . "/register", [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'nomor_whatsapp' => $request->nomor_whatsapp,
        ]);


        // Cek jika response sukses
        if ($response->successful()) {
            $data = $response->json();
            // dd($data['data']['role']);
            // Pastikan key 'jwt' ada di dalam data
            if (isset($data['jwt'])) {
                Session::put('jwt', $data['jwt']); // Token JWT yang dikirimkan
                Session::put('user_data', $data['data']);
                if($data['data']['role'] == 'admin'){
                    return redirect()->route('admin'); // Arahkan ke dashboard atau halaman setelah login
                }else{
                    return redirect()->route('dashboard'); // Arahkan ke dashboard atau halaman setelah login
                }
            } else {
                return back()->withErrors(['error' => 'Token JWT tidak ditemukan.']);
            }
        }

        // Jika ada error
        return back()->withErrors(['error' => 'Gagal melakukan registrasi.']);
    }


    public function index(){
        return view('auth.login');
    }


    // Fungsi Login
    public function login(Request $request)
    {
        // dd('ok');
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Kirim data ke backend untuk login
        $response = Http::post($this->authUrl . "/login", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Cek jika response sukses
        if ($response->successful()) {
            $data = $response->json();
            // dd($data['data']['role']);
            // Pastikan key 'jwt' ada di dalam data
            if (isset($data['jwt'])) {
                Session::put('jwt', $data['jwt']); // Token JWT yang dikirimkan
                Session::put('user_data', $data['data']);
                if($data['data']['role'] == 'admin'){
                    return Redirect::route(route: 'admin'); // Arahkan ke dashboard atau halaman setelah login
                }else{
                    return Redirect::route(route: 'dashboard'); // Arahkan ke dashboard atau halaman setelah login
                }
            } else {
                // return back()->withErrors(['error' => 'Token JWT tidak ditemukan.']);
                return  Redirect::route(route: 'login');
            }
        }

        return Redirect::route(route: 'login');

    }

  public function updateProfile(Request $request)
{
    // Ambil data user & token dari session
    $userData = Session::get('user_data');
    $jwtToken = Session::get('jwt');

    if (!$userData || !isset($userData['_id']) || !$jwtToken) {
        return back()->withErrors(['error' => 'User tidak ditemukan di sesi atau token tidak ada.']);
    }

    $user_id = $userData['_id'];

    // Data yang dikirim ke API
    $payload = array_filter([
        'user_id' => $user_id,
        'name' => $request->name,
        'email' => $request->email,
        'nomor_telepon' => $request->nomor_telepon,
        'url' => $request->url
    ]);

    // Kirim PATCH pakai Authorization header
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $jwtToken,
        'Content-Type'  => 'application/json',
    ])->patch($this->authUrl . '/updateProfile', $payload);

    // Tangani response
    if ($response->successful()) {
        $data = $response->json();

        if (isset($data['data'])) {
            Session::put('user_data', $data['data']);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui profil.';
    return back()->withErrors(['error' => $errorMessage]);
}




    // public function test1(){
    //     Session::put('oke', 111);
    //     return redirect('/tentang'); // Redirect ke halaman yang dilindungi middleware
    // }

    
    // public function test2(){
    //     Session::forget('oke');
    //     return redirect('tentang');
    // }

    // Fungsi Logout
    public function logout()
    {
        Session::forget('jwt');
        Session::forget('user_data');
        
        // Tambahkan ?logout=true ke redirect URL
        return redirect()->route('dashboard', ['logout' => 'true']);
    }
    
}
