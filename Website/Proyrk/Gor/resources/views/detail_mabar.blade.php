@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Styling untuk container utama */
    .mabar-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 40px;
        padding: 0 10%;
    }

    /* Bagian untuk detail mabar (80%) */
    .mabar-details {
        width: 80%;
        padding-right: 20px; /* Spasi antara detail dan tombol */
    }

    /* Styling untuk card */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        background-color: #fff;
    }

    /* Card body */
    .card-body {
        width: 750px;
        height: 35  0px;
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
    }

    /* Judul mabar */
    .card-title {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    /* Info Pembuat Mabar */
    .d-flex {
        display: flex;
        align-items: center;
        font-size: 18px;
        color: #34495e;
    }

    .d-flex i {
        color: #2980b9;
    }

    .d-flex strong {
        margin-left: 8px;
    }

    /* Styling untuk setiap item informasi */
    .card-body p {
        font-size: 16px;
        margin: 10px 0;
        color: #34495e;
    }

    /* Styling untuk icon bi */
    .card-body i {
        color: #3498db;
        margin-right: 10px;
    }

    /* Styling untuk tanggal dan jam */
    .card-body p:first-child {
        font-size: 18px;
        font-weight: bold;
        color: #2ecc71;
    }

    /* Styling untuk biaya */
    .card-body p:nth-child(4) {
        font-size: 16px;
        font-weight: bold;
        color: #e67e22;
    }

    /* Styling untuk kategori */
    .card-body p:nth-child(5) {
        font-size: 16px;
        color: #8e44ad;
    }

    /* Styling untuk peserta */
    .card-body p:nth-child(6) {
        font-size: 16px;
        font-weight: bold;
        color: red;
    }

    /* Styling untuk garis pemisah (hr) */
    hr {
        border: 1px solid #000000;
        margin: 10px 0;
    }

    /* Styling untuk tombol gabung */
    .join-button {
        width: 100%;
        background-color: #3498db;
        color: white;
        padding: 15px;
        font-size: 18px;
        text-align: center;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    /* Hover effect pada tombol gabung */
    .join-button:hover {
        background-color: #2980b9;
    }

    /* Responsive style untuk layar kecil */
    @media (max-width: 767px) {
        .mabar-container {
            padding: 0 5%;
            flex-direction: column; /* Layout kolom pada perangkat kecil */
        }

        .mabar-details {
            width: 100%; /* Full width untuk detail mabar */
            margin-bottom: 20px;
        }

        .join-button {
            width: 100%; /* Full width untuk tombol gabung */
        }
    }
</style>

<div class="container mt-4">
    <!-- Kontainer untuk menampilkan detail Mabar -->
    <div id="mabar-detail-container">
        
        <!-- Data detail mabar akan dimasukkan di sini -->
    </div>
</div>

<script>
    const currentUserId = @json(Session::get('user_data')['_id'] ?? null);
</script>

<script>

    const flashSuccess = @json(session('success'));
    const flashError = @json(session('error'));

    if (flashSuccess) {
        alert(flashSuccess);
    }

    if (flashError) {
        alert(flashError);
    }
    
const loadTime = Date.now();

document.addEventListener('DOMContentLoaded', function () {
    // Cek apakah data dipulihkan dari localStorage setelah refresh
    const restoredMabar = localStorage.getItem('restoreMabar');
    if (restoredMabar) {
        sessionStorage.setItem('selectedMabar', restoredMabar);
        localStorage.removeItem('restoreMabar'); // Hapus setelah dikembalikan
    }


    // Ambil data dari sessionStorage
    const selectedMabar = JSON.parse(sessionStorage.getItem('selectedMabar'));

    if (selectedMabar) {
        displayMabarDetail(selectedMabar);
    } else {
        document.getElementById('mabar-detail-container').innerHTML = "<p>Data mabar tidak tersedia.</p>";
    }

    // Simpan data ke localStorage saat refresh
    window.addEventListener('beforeunload', function () {
    const navType = performance.getEntriesByType("navigation")[0]?.type;

    if (navType === "reload" && sessionStorage.getItem('selectedMabar')) {
        localStorage.setItem('restoreMabar', sessionStorage.getItem('selectedMabar'));
    } else {
        sessionStorage.removeItem('selectedMabar');
    }
});

});


function displayMabarDetail(mabar) {
    const container = document.getElementById('mabar-detail-container');
    const jadwal = mabar.jadwal || [];

    // Format tanggal
    const tanggalUtama = jadwal[0]?.tanggal;
    let tanggalFormatted = 'Tidak tersedia';

    if (tanggalUtama) {
        const dateObj = new Date(tanggalUtama);
        const optionsHari = { weekday: 'long' };
        const optionsTanggal = { year: 'numeric', month: 'long', day: 'numeric' };

        const hari = dateObj.toLocaleDateString("id-ID", optionsHari); // Senin
        const tanggal = dateObj.toLocaleDateString("id-ID", optionsTanggal); // 3 Maret 2025
        tanggalFormatted = `${hari}, ${tanggal}`;
    }

    // Hitung jam mulai dan selesai jika berurutan
    const jamList = jadwal.map(j => parseInt(j.jam)).sort((a, b) => a - b);
    const isConsecutive = jamList.every((val, idx) => {
        return idx === 0 || val === jamList[idx - 1] + 1;
    });

    let jamMulai = "-";
    let jamSelesai = "-";

    if (jamList.length && isConsecutive) {
        jamMulai = jamList[0] + ":00";
        jamSelesai = (jamList[jamList.length - 1] + 1) + ":00";
    }

    let tombolGabungHTML = `
<form method="POST" action="/mabar/join">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="mabar_id" value="${mabar._id}">
    <button type="submit" class="join-button">Gabung Mabar</button>
</form>`;

// Cek apakah user sudah join
if (mabar.user_yang_join?.some(u => String(u._id) === String(currentUserId))) {
    tombolGabungHTML = `
    <form method="POST" action="{{ route('mabar.keluar') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="mabar_id" value="${mabar._id}">
        <button type="submit" class="join-button" style="background-color: #e74c3c;">Keluar Mabar</button>
    </form>`;
}


    // HTML untuk menampilkan detail mabar
    const mabarHTML = `
<div class="container mt-4">
    <div class="mabar-container" style="display: flex; flex-direction: column;">
        <!-- Judul dan HR di atas -->
        <div style="display: flex; justify-content: space-between;">
            <h5 class="card-title">${mabar.nama_mabar}</h5>
        </div>
        <hr style="margin: 0.5rem 0; width: 100%; border-top: 1px solid #dee2e6;">
        <div style="margin: 20px; font-size:20px;">
        <Strong style="font-size: 30px;">GOR Ramos Badminton</Strong><br>
       Jl. Sitoluama 2, Sigumpar, Laguboti<br>
        <p style="color: red;">Peserta: ${mabar.totalJoined}/${mabar.slot_peserta}</p>
        </div>
        <!-- Isi konten: kiri dan kanan -->
        
        <div style="display: flex; gap: 20px;">
            <!-- Kolom kiri (80%) -->
            <div style="width: 80%;">
                <div class="card mb-3">
                    <div class="card-body" style="margin: 25px;">

                        <p><i class="bi bi-calendar-event"></i> ${tanggalFormatted} * ${jamMulai} - ${jamSelesai}</p>
                        <p>Lapangan ${jadwal[0]?.lapangan || '-'}</p>
                        <p><i class="bi bi-cash-coin"></i> Rp ${mabar.biaya}/orang</p>
                        <p><i class="bi bi-people"></i> ${mabar.kategori}</p>
                        
                    </div>
                </div>
            </div>
                <!-- Kolom kanan (20%) -->
                <div style="width: 20%; display: flex;">
                    ${tombolGabungHTML}
            </div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        </div>
    </div>
</div>`;

    
    // Masukkan HTML ke container
    container.innerHTML = mabarHTML;
}


</script>

@endsection
