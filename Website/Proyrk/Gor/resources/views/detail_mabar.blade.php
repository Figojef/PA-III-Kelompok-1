@extends('layouts.app')

@section('content')
<script>
    const routeLihatPesertaTemplate = @json(route('mabar.pemainFromRequest') . '?mabarId=__ID__');
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.mabar-container {
    display: flex;
    flex-wrap: wrap; /* Penting untuk responsif */
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
}

/* Kolom kiri */
.mabar-details {
    flex: 1 1 60%; /* Bisa menyusut di layar kecil */
    min-width: 280px;
}

/* Kolom kanan */
.penyelenggara {
    flex: 1 1 35%;
    min-width: 250px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.card, .card-penyelenggara {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    padding: 20px;
}

/* Header dan teks dalam card */
.card-title {
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 15px;
}

.card-body p {
    font-size: 16px;
    margin: 10px 0;
    color: #34495e;
}

/* Biaya */
.card-body p:nth-child(4) {
    font-size: 16px;
    font-weight: bold;
    color: #e67e22;
}

/* Tombol */
.join-button {
    background-color: #3498db;
    color: white;
    padding: 12px 16px;
    font-size: 16px;
    text-align: center;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

.join-button:hover {
    background-color: #2980b9;
}

/* Responsif untuk tablet dan HP */
@media (max-width: 992px) {
    .mabar-container {
        flex-direction: column;
    }

    .mabar-details, .penyelenggara {
        width: 100%;
    }

    .join-button {
        font-size: 14px;
        padding: 10px 12px;
    }

    .card-title {
        font-size: 20px;
    }

    .card-body p {
        font-size: 14px;
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

document.addEventListener('DOMContentLoaded', function() {
    const link = document.getElementById('linkLihatPeserta');
        if (!link) return; // elemen tidak ada jika mabar sudah selesai

        const selectedMabar = sessionStorage.getItem('selectedMabar');

            
    if (!selectedMabar) {
        link.style.pointerEvents = 'none'; // disable klik
        link.textContent = 'Data Mabar tidak tersedia';
        return;
    }
    
    try {
        const mabarObj = JSON.parse(selectedMabar);
        const mabarId = mabarObj._id;

        // Buat URL menuju route pemain_mabar dengan query param mabarId
        const url = "{{ route('mabar.pemainFromRequest') }}" + "?mabarId=" + encodeURIComponent(mabarId);
        
        // Set href link
        link.href = url;

    } catch(e) {
        console.error('Gagal parsing selectedMabar dari sessionStorage', e);
        link.style.pointerEvents = 'none';
        link.textContent = 'Data Mabar tidak valid';
    }
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

    // Periksa apakah mabar sudah selesai (history)
    const currentTime = new Date();
    const mabarEndTime = new Date(`${jadwal[jadwal.length - 1]?.tanggal}T${String(jamSelesai).padStart(2, '0')}:00`);
    const isMabarEnded = currentTime > mabarEndTime;

        let tombolGabungHTML = ``;

        const userJoined = mabar.user_yang_join || [];
        const isUserJoined = userJoined.some(u => String(u._id) === String(currentUserId));

       if (isMabarEnded) {
    const lihatPesertaUrl = routeLihatPesertaTemplate.replace('__ID__', mabar._id) + '&mode=penilaian';
    tombolGabungHTML = `<a href="${lihatPesertaUrl}" class="join-button">Penilaian</a>`;
}
 else {
            if (isUserJoined) {
                // User sudah join → tombol Keluar
                tombolGabungHTML = `
                <form method="POST" action="/mabar/keluar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="mabar_id" value="${mabar._id}">
                    <button type="submit" class="join-button" style="background-color: #e74c3c;">Keluar Mabar</button>
                </form>`;
            } else {
                // Belum join → tombol Gabung
                tombolGabungHTML = `
                <form method="POST" action="/mabar/join">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="mabar_id" value="${mabar._id}">
                    <button type="submit" class="join-button">Gabung Mabar</button>
                </form>`;
            }
        }


    // HTML untuk menampilkan detail mabar
    const mabarHTML = `
    <div class="container mt-4">
        <div class="mabar-container">
            <!-- Kolom kiri (detail mabar) -->
            <div class="mabar-details">
                <h4 class="card-title">${mabar.nama_mabar}</h4>
                <hr>
                <p><strong>GOR Ramos Badminton</strong><br>Jl. Sitoluama 2, Sigumpar, Laguboti</p>
                <p style="color: red;">Peserta: ${mabar.totalJoined}/${mabar.slot_peserta}</p>
${!isMabarEnded ? `<a href="#" id="linkLihatPeserta">Lihat Peserta</a>` : ``}

                <div class="card">
                    <div class="card-body">
                    <h5>Lapangan dan Waktu</h5>
                    <p>${mabar.jadwal && mabar.jadwal[0]?.lapangan?.name ? mabar.jadwal[0].lapangan.name : '-'} * ${jamMulai} - ${jamSelesai}</p>
                    <p><i class="bi bi-cash-coin"></i> Rp ${mabar.biaya}/orang</p>
                    <p><i class="bi bi-people"></i> ${mabar.kategori}</p>
                    <p><strong>Range Umur:</strong> ${mabar.range_umur || 'Tidak Diketahui'}</p>
                    <p><strong>Level:</strong> ${mabar.level || 'Tidak Diketahui'}</p>
                    <hr>
                    <p>${mabar.deskripsi || 'Deskripsi mabar tidak tersedia'}</p>
                </div>
                </div>
                
            </div>

            <!-- Kolom kanan (Penyelenggara dan tombol) -->
            <div class="penyelenggara">
                <div class="penyelenggara-info card">
                    <h5> <i class="bi bi-person-circle fs-5 me-2"></i>${mabar.user_pembuat_mabar.name}</h5>
                    <p>Penyelenggara</p>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    ${tombolGabungHTML} <!-- Tombol Gabung atau Penilaian -->
                </div>
            </div>
        </div>
    </div>
    `;

    container.innerHTML = mabarHTML;
}


</script>

@endsection
