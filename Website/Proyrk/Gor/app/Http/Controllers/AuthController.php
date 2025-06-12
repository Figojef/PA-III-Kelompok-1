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
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:6',
            // 'password_confirmation' => 'required|same:password'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'name.max' => 'Nama maksimal 50 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'nomor_telepon.required' => 'Nomor telepon harus diisi',
            'nomor_telepon.min' => 'Nomor telepon minimal 10 digit',
            'nomor_telepon.max' => 'Nomor telepon maksimal 15 digit',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            // 'password_confirmation.required' => 'Konfirmasi password harus diisi',
            // 'password_confirmation.same' => 'Konfirmasi password tidak cocok'
        ]);

        try {
            // Kirim data ke backend untuk register
            $response = Http::post($this->authUrl . "/register", [
                'name' => $request->name,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'password' => $request->password,
            ]);

            // Cek jika response sukses
            if ($response->successful()) {
                $data = $response->json();
                
                // Pastikan key 'jwt' ada di dalam data
                if (isset($data['jwt'])) {
                    Session::put('jwt', $data['jwt']);
                    Session::put('user_data', $data['data']);
                    
                    // Set session flash untuk success message (auto login setelah register)
                    if($data['data']['role'] == 'admin'){
                        Session::flash('register_success', [
                            'type' => 'admin',
                            'name' => $data['data']['name']
                        ]);
                        return Redirect::route('admin');
                    } else {
                        Session::flash('register_success', [
                            'type' => 'pelanggan', 
                            'name' => $data['data']['name']
                        ]);
                        return Redirect::route('dashboard');
                    }
                } else {
                    return back()->withErrors(['register' => 'Token JWT tidak ditemukan dari server']);
                }
            } else {
                // Handle error response dari backend
                $errorData = $response->json();
                $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Pendaftaran gagal';
                
                return back()->withErrors(['register' => $errorMessage])->withInput($request->except('password', 'password_confirmation'));
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['register' => 'Tidak dapat terhubung ke server. Silakan coba lagi.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }


    public function index(){
        return view('auth.login');
    }


public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        try {
            // Kirim data ke backend untuk login
            $response = Http::post($this->authUrl . "/login", [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Cek jika response sukses
            if ($response->successful()) {
                $data = $response->json();
                
                // Pastikan key 'jwt' ada di dalam data
                if (isset($data['jwt'])) {
                    Session::put('jwt', $data['jwt']);
                    Session::put('user_data', $data['data']);
                    
                    // Set session flash untuk success message
                    if($data['data']['role'] == 'admin'){
                        Session::flash('login_success', [
                            'type' => 'admin',
                            'name' => $data['data']['name']
                        ]);
                        return Redirect::route('admin');
                    } else {
                        Session::flash('login_success', [
                            'type' => 'pelanggan', 
                            'name' => $data['data']['name']
                        ]);
                        return Redirect::route('dashboard');
                    }
                } else {
                    return back()->withErrors(['login' => 'Token JWT tidak ditemukan dari server']);
                }
            } else {
                // Handle error response dari backend
                $errorData = $response->json();
                $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Login gagal';
                
                return back()->withErrors(['login' => $errorMessage])->withInput($request->except('password'));
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Tidak dapat terhubung ke server. Silakan coba lagi.'])->withInput($request->except('password'));
        }
    }



    
    public function showRegister(){
        return view('auth.register');
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

    // Debugging data payload sebelum dikirim ke API
    // Menampilkan data yang akan dikirim ke API

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

        // Jika profil berhasil diperbarui, arahkan ke route logout
        return redirect()->route('logout.update')->with('success', 'Profil berhasil diperbarui.');
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
    
        public function logoutAfterUpdate()
    {
        // Hapus session jwt dan user data
        Session::forget('jwt');
        Session::forget('user_data');
        
        // Redirect ke halaman login dengan parameter logout.update
        return redirect()->route('login', ['logout.update' => 'true']);
    }
}

