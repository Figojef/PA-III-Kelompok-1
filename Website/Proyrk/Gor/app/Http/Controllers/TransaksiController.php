<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
  // Function untuk upload bukti pembayaran
  public function updateGambar(Request $request, $id)
  {
      $request->validate([
          'bukti_pembayaran' => 'required|image|max:2048',
      ]);
  
      $pembayaran = Pembayaran::findOrFail($id);
  
      // Simpan file
      $filename = time() . '.' . $request->file('bukti_pembayaran')->extension();
      $path = $request->file('bukti_pembayaran')->move(public_path('uploads'), $filename);
  
      // Update DB
      $pembayaran->bukti_pembayaran = 'uploads/' . $filename;
      $pembayaran->save();
  
      return redirect()->back()->with('success', 'Gambar berhasil diupload');
  }
  
    

}


