@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.jwt = "{{ session('jwt') ?? '' }}";
    window.loginUrl = "{{ route('login') }}";
    console.log("JWT dari session:", window.jwt); // cek apakah isi atau kosong
</script>

<title>Jadwal Bermain</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
#judul {
    display: flex; 
    justify-content: center; 
    align-items: center;
}


.user {
    margin-bottom:10px;
    font-weight: 700;

}

.user.data {

    margin-bottom: 15px;
    font-weight: 400;
}

.option-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      cursor: pointer;
    }
  
    .option-wrapper input[type="radio"] {
      margin-right: 10px;
      cursor: pointer;
    }

    .text-box {
      padding: 10px 50px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: white;
      transition: background-color 0.3s;
      margin-bottom: 10px;
    }

    .text-box:hover{
      padding: 10px 50px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color:rgb(117, 135, 146);
      transition: background-color 0.3s;
      margin-bottom: 10px;
    }

    .text-box.selected {
      background-color: #222F37;
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    td {
      padding: 20px;
      border: 2px solid #000;
      border-radius: 15px;
      vertical-align: top;
    }

    .slot-item {
      position: relative;
      padding: 20px;
      margin-bottom: 20px;
      font-weight: 600;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .harga {
      position: absolute;
      top: 10px;
      right: 15px;
      padding: 25px 10px;
      border-radius: 6px;
      font-weight: bold;
      font-size: 14px;
    }

    .slot-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .slot-detail {
      font-size: 14px;
      color: #555;
    }

    .konfirmasi {
      align-items: center;
      justify-content: center;
      display: flex; 
      margin-top: 50px;
    }
    
    .tombol {
    color: black;
    font-weight: 700;
    background-color: white;
    width: 100%;       
    height: 40px;      
    border-radius: 10px;      
    font-size: 16px;   
    }

    .tombol:hover {
    color: white;
    font-weight: 700;
    background-color: #1D4ED8 ;
    width: 100%;       
    height: 40px;     
    transition: 0.5s; 
    border-radius: 10px;      
    font-size: 16px;   
    }

</style>

    <div class="container mt-4">
                <h2 id="judul">Detail Pembayaran</h2>
                    <label style="font-size: 25px; text-decoration: underline; font-weight: bold; margin-bottom: 25px;">Informasi Pelanggan</label>

                    <div>
                        <label class="user">Nama Pelanggan</label><br>
                        <label class="user data">          
                            @php
                            if(isset(Session::get('user_data')['role'])){
                                echo Session::get('user_data')['name'];
                            } else {
                                echo ".";
                            }
                            @endphp
                        </label><br>

                        <label class="user">No.Telepon</label><br>
<label class="user data">
    @php
        // Ambil nomor WhatsApp
        $nomorWhatsApp = Session::get('user_data')['nomor_whatsapp'] ?? "";

        // Ganti kode negara 62 atau +62 dengan 0
        $nomorWhatsApp = preg_replace('/^\+?62/', '0', $nomorWhatsApp);

        // Pisahkan setiap 4 angka
        $nomorWhatsApp = preg_replace('/(\d{4})(?=\d)/', '$1 ', $nomorWhatsApp);
    @endphp

    {{ $nomorWhatsApp }}
</label>


                    </div>
                        
                    <hr style="border: 2px solid #000000; margin: 20px 0;">

                    <div>
                        <h4 style="margin-bottom: 25px;">Pilih Jenis Pembayaran</h4>
                        <label class="option-wrapper">
                        <input type="radio" name="payment" value="transfer_bank">
                        <div class="text-box">Transfer Bank</div>
                            </label>

                        <label class="option-wrapper">
                        <input type="radio" name="payment" value="bayar_langsung">
                        <div class="text-box">Bayar Ditempat</div>
                        </label>
                    </div>

                            
                    <hr style="border: 2px solid #000000; margin: 20px 0;">

                    <table>
  <tr>
    <td id="slotContainer">
      <!-- Slot akan tampil di sini -->
    </td>
  </tr>
  <!-- Baris untuk total harga -->
  <tr>
    <td id="totalBayarContainer" colspan="2" style="text-align: right; font-weight: bold; padding-top: 20px;">
      Total Bayar: <span id="totalHarga">Rp 0</span>
    </td>
  </tr>
</table>

<div class="konfirmasi">   
    <form id="formKonfirmasi" method="POST" action="{{ route('pemesanan.store') }}">
        @csrf
        <input type="hidden" name="jadwal_dipesan" id="jadwalDipesanInput">
        <input type="hidden" name="total_harga" id="totalHargaInput">
        <input type="hidden" name="metode_pembayaran" id="metodePembayaranInput">
        <input type="hidden" name="status_pemesanan" value="pending">
        <input type="submit" class="tombol" value="Konfirmasi pemesanan">
    </form>
</div>


    </div>

    <script>
    
  </script>
@endsection