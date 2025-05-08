@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h3>Detail Mabar</h3><br>

    <!-- Kontainer untuk menampilkan detail Mabar -->
    <div id="mabar-detail-container">
        <!-- Data detail mabar akan dimasukkan di sini -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil data mabar dari sessionStorage
    const selectedMabar = JSON.parse(sessionStorage.getItem('selectedMabar'));

    // Cek apakah sessionStorage memiliki data
    if (selectedMabar) {
        displayMabarDetail(selectedMabar); // Tampilkan detail mabar
    } else {
        // Jika data mabar tidak ditemukan
        document.getElementById('mabar-detail-container').innerHTML = "<p>Data mabar tidak tersedia.</p>";
    }

    // Cek apakah ini pertama kali halaman dimuat (bukan refresh)
    if (!sessionStorage.getItem('isFirstVisit')) {
        sessionStorage.setItem('isFirstVisit', 'true');
    }

    // Periksa apakah refresh atau bukan
    const isRefresh = performance.navigation.type === performance.navigation.TYPE_RELOAD;

    // Menghapus sessionStorage hanya ketika pengguna berpindah halaman (bukan refresh)
    window.addEventListener('beforeunload', function() {
        if (!isRefresh) {
            // Hapus sessionStorage ketika navigasi atau keluar dari halaman
            sessionStorage.removeItem('selectedMabar');
        }

        // Reset flag 'isFirstVisit' saat sebelum unload
        sessionStorage.removeItem('isFirstVisit');
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

    // HTML untuk menampilkan detail mabar
    const mabarHTML = `
        <div class="card mb-3">
            <div class="card-body">
                <!-- Info Pembuat Mabar -->
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle fs-5 me-2"></i>
                    <strong>${mabar.user_pembuat_mabar.name}</strong>
                </div>
                <!-- Nama Mabar -->
                <h5 class="card-title">${mabar.nama_mabar}</h5>
                
                <!-- Jadwal -->
                <p><i class="bi bi-calendar-event"></i> ${tanggalFormatted} * ${jamMulai} - ${jamSelesai}</p>
                
                <!-- Lapangan -->
                <p>Lapangan ${jadwal[0]?.lapangan || '-'}</p>
                
                <!-- Biaya -->
                <p><i class="bi bi-cash-coin"></i> Rp ${mabar.biaya}/orang</p>
                
                <!-- Kategori -->
                <p><i class="bi bi-people"></i> ${mabar.kategori}</p>
                
                <!-- Peserta -->
                <p style="color: red;">${mabar.totalJoined}/${mabar.slot_peserta} Peserta</p>
            </div>
        </div>
    `;
    
    // Masukkan HTML ke container
    container.innerHTML = mabarHTML;
}


</script>

@endsection
