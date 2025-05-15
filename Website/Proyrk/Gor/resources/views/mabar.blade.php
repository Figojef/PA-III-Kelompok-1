@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<style>
    .Tambah {
        padding: 10px 15px;
        background-color: black;
        color: #ffffff;
        border-radius: 4px;
        font-size: 18px;
        margin-left: auto;
        display: block;
    }

    .nama {
      font-weight: 700;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 10px;
        margin-bottom: 20px;
    }

    .card-body {
        padding: 10px; /* Reduced padding */
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .card-footer .join-info {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .lihat-detail {
        font-size: 0.85rem;
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
    }

    .lihat-detail:hover {
        text-decoration: underline;
    }

    .mabar-list-container {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;  /* Gap between cards */
}

.card-wrapper {
    flex: 0 0 calc(33.333% - 20px);
    max-width: calc(33.333% - 20px);
    box-sizing: border-box;
    margin-bottom: 20px;
}


.card-wrapper:last-child {
    margin-right: 0;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.card .card-body p {
    margin-bottom: 5px;
    font-size: 0.95rem;
}

</style>

<title>Jadwal Bermain</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container mt-4">
    <h3>Main Bareng</h3><br>
    <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" id="tab-main-bareng" href="#">Main Bareng</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="tab-mabar-anda" href="#">Mabar Anda</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="tab-mabar-diikuti" href="#">Mabar yang Diikuti</a>
  </li>
<li class="nav-item">
    <a class="nav-link" id="tab-riwayat-main-bareng" href="#">Riwayat Main Bareng</a>
</li>

</ul>

    <hr style="border: 2px solid #000000; margin: 20px 0;">
    
    <input type="button" class="Tambah" value="+ Tambah" onclick="checkLoginStatus()">

    <div id="mabar-list" class="mabar-list-container">
        <!-- Data akan dimasukkan di sini -->
    </div>
</div>

<div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function checkLoginStatus() {
    let jwtToken = "{{ Session::get('jwt') }}"; 
    
    if (!jwtToken) {
      Swal.fire({
        title: 'Anda belum login!',
        text: 'Untuk menambah, Anda perlu login. Apakah Anda ingin login sekarang?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, login',
        cancelButtonText: 'Tidak',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '{{ route('login') }}';
        }
      });
    } else {
      window.location.href = '{{ route('tambahMabar') }}';
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    fetchMabarList();
});



let jwtUserId = "{{ Session::get('user_data')['_id'] ?? '' }}";
let allMabarData = [];
const jwtToken = "{{ Session::get('jwt') }}"; // Fetch token from Laravel session


document.addEventListener('DOMContentLoaded', function () {
  fetchMabarList(); // Panggil data untuk tab utama (Main Bareng)

  // Event listener untuk tab "Main Bareng"
  document.getElementById('tab-main-bareng').addEventListener('click', function () {
    setActiveTab(this);
    displayMabarList(allMabarData); 
  });

  // Event listener untuk tab "Mabar Anda"
  document.getElementById('tab-mabar-anda').addEventListener('click', function () {
    setActiveTab(this);
    const filtered = allMabarData.filter(m => m.user_pembuat_mabar?._id === jwtUserId);
    displayMabarList(filtered);
  });

  // Event listener untuk tab "Mabar yang Diikuti"
  document.getElementById('tab-mabar-diikuti').addEventListener('click', function () {
    setActiveTab(this);
    const filtered = allMabarData.filter(m => m.user_pembuat_mabar?._id !== jwtUserId &&
    m.user_yang_join?.some(u => u._id === jwtUserId));
    displayMabarList(filtered);
  });

  // Event listener untuk tab "Riwayat Main Bareng"
  document.getElementById('tab-riwayat-main-bareng').addEventListener('click', function () {
    setActiveTab(this);
    fetchRiwayatMabar(); // Ambil data riwayat
  });
});


document.getElementById('tab-riwayat-main-bareng').addEventListener('click', function () {
  setActiveTab(this);
  fetchRiwayatMabar(); // Panggil fungsi untuk menampilkan riwayat main bareng
});


function setActiveTab(clickedTab) {
  document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
  clickedTab.classList.add('active');
}

function fetchMabarList() {
  const baseUrl = document.getElementById('base-url').textContent.trim().replace(/\/+$/, '');
  const apiUrl = `${baseUrl}/mabar/sebelum`;

  fetch(apiUrl)
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        allMabarData = result.data;
        displayMabarList(allMabarData);
      } else {
        document.getElementById("mabar-list").innerHTML = "<p>Gagal memuat data mabar.</p>";
      }
    })
    .catch(error => {
      console.error("Error fetching data:", error);
      document.getElementById("mabar-list").innerHTML = "<p>Terjadi kesalahan saat mengambil data.</p>";
    });
}

function fetchRiwayatMabar() {
  const baseUrl = document.getElementById('base-url').textContent.trim().replace(/\/+$/, '');
  const userId = jwtUserId;    // pastikan variabel ini sudah tersedia di scope
  const jwtToken = jwtToken;   // pastikan token juga tersedia

  fetch(`${baseUrl}/mabar/history/${userId}`, {
    headers: {
      'Authorization': `Bearer ${jwtToken}`,
    }
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      displayMabarList(result.data);
    } else {
      document.getElementById("mabar-list").innerHTML = "<p>Tidak ada riwayat mabar.</p>";
    }
  })
  .catch(error => {
    console.error("Error fetching data:", error);
    document.getElementById("mabar-list").innerHTML = "<p>Terjadi kesalahan saat mengambil data.</p>";
  });
}




function displayMabarList(data) {
    const container = document.getElementById("mabar-list");
    container.innerHTML = ""; // Mengosongkan container sebelum diisi dengan data baru

    if (data.length === 0) {
        container.innerHTML = "<p>Tidak ada riwayat mabar yang ditemukan.</p>";
        return;
    }

    data.forEach(mabar => {
        const pembuat = mabar.user_pembuat_mabar?.name || 'Tidak diketahui';
        const jadwal = mabar.jadwal || [];

        // Ambil tanggal dan format hari + tanggal
        const tanggalUtama = jadwal[0]?.tanggal;
        let tanggalFormatted = 'Tidak tersedia';

        if (tanggalUtama) {
            const dateObj = new Date(tanggalUtama);
            const optionsHari = { weekday: 'long' };
            const optionsTanggal = { year: 'numeric', month: 'long', day: 'numeric' };

            const hari = dateObj.toLocaleDateString("id-ID", optionsHari); // Contoh: Senin
            const tanggal = dateObj.toLocaleDateString("id-ID", optionsTanggal); // Contoh: 3 Maret 2025
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
        // Cek apakah user sudah bergabung dengan mabar ini
        const userJoined = mabar.user_yang_join || [];
        const isUserJoined = userJoined.some(user => user._id === jwtUserId); // Ganti dengan _id untuk pengecekan

        // Debugging
        console.log(`User ID (JWT): ${jwtUserId}, Mabar User Joined: ${userJoined}`);
        console.log(`Is user joined? ${isUserJoined}`);

        const mabarHTML = `
            <div class="card-wrapper">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2" style="position: relative;">
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                            <strong>${mabar.user_pembuat_mabar.name}</strong>

                            <!-- Tampilkan ikon orang jika user sudah bergabung -->
                            ${isUserJoined ? 
                                `<i class="bi bi-person-circle" style="position: absolute; top: 10px; right: 10px; font-size: 24px; color: green;"></i>` 
                                : ''}
                        </div>
                        <h5 class="card-title">${mabar.nama_mabar}</h5>

                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i> ${tanggalFormatted} * ${jamMulai} - ${jamSelesai}
                        </p>
                        <p class="mb-1"><i class="bi bi-cash-coin"></i> Rp ${mabar.biaya}/orang</p>
                        <p class="mb-1"><i class="bi bi-people"></i> <span style="color: green; font-weight: bold;">${mabar.kategori}</span></p>

                        <p style="color: red;">${mabar.totalJoined}/${mabar.slot_peserta} Peserta</p>

                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-outline-dark btn-sm" onclick='lihatDetailMabar(${JSON.stringify(mabar)})'>Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML += mabarHTML;
    });
}

function lihatDetailMabar(mabar) {
    sessionStorage.setItem('selectedMabar', JSON.stringify(mabar));
    window.location.href = 'detail_mabar';
}


</script>

<div style="margin-bottom: 25%;"></div>

@endsection
