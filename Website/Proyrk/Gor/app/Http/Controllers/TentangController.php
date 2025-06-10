<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TentangController extends Controller
{
    public function index()
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->get('tentang');

        if ($response->successful()) {
            $data = $response->json()['data'];
        } else {
            $data = [];
            session()->flash('error', 'Gagal mengambil data tentang.');
        }

        return view('admin.tentang.index', compact('data'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->post('tentang', [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang GOR berhasil ditambahkan.');
        } else {
            $error = $response->json('message') ?? 'Terjadi kesalahan saat menambahkan data.';
            return redirect()->back()->with('error', $error)->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('edit_id', $id); // supaya tahu modal mana yang dibuka lagi
        }

        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->patch("tentang/{$id}", [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang GOR berhasil diperbarui.');
        } else {
            $error = $response->json('message') ?? 'Terjadi kesalahan saat memperbarui data.';
            return redirect()->back()->with('error', $error)->withInput()->with('edit_id', $id);
        }
    }

    public function destroy($id)
    {
        $token = Session::get('jwt');

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])->withCookies([
            'jwt' => $token
        ], env('DOMAIN'))->delete("tentang/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.tentang.index')->with('success', 'Tentang GOR berhasil dihapus.');
        } else {
            $error = $response->json('message') ?? 'Gagal menghapus data.';
            return redirect()->route('admin.tentang.index')->with('error', $error);
        }
    }



}