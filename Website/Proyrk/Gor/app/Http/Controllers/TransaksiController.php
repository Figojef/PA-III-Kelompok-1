<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
  // Function untuk upload bukti pembayaran
  public function updateGambar(Request $request)
  {
      // Validasi request agar ada file gambar yang dikirim
      $request->validate([
          'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar dengan ukuran maksimal 2MB
      ]);

      // Ambil file gambar yang dikirim melalui request
      $image = $request->file('gambar');

      // Generate nama file dan simpan gambar di direktori 'public/uploads'
      $filename = time() . '.' . $image->getClientOriginalExtension();
      $path = $image->storeAs('uploads', $filename, 'public');

      // Kembalikan response sukses jika gambar berhasil diupload
      return response()->json([
          'success' => true,
          'message' => 'Gambar berhasil diupload!',
          'image_name' => $filename,  // Bisa dikembalikan nama file atau informasi lainnya
      ], 200);
  }
  
  public function showUploadForm($id)
  {
      return view('upload', ['transactionId' => $id]);
  }

}


