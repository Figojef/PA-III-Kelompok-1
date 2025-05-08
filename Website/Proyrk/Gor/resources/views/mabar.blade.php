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
</ul>

    <hr style="border: 2px solid #000000; margin: 20px 0;">
    
    <input type="button" class="Tambah" value="+ Tambah" onclick="checkLoginStatus()">

    <div id="mabar-list" class="mabar-list-container">
        <!-- Data akan dimasukkan di sini -->
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function checkLoginStatus() {
    let jwtToken = "{{ Session::get('jwt') }}"; // or use JavaScript to fetch it if it's in a cookie or localStorage
    
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

document.addEventListener('DOMContentLoaded', function () {
  fetchMabarList();

  document.getElementById('tab-main-bareng').addEventListener('click', function () {
    setActiveTab(this);
    displayMabarList(allMabarData); // tanpa filter
  });

  document.getElementById('tab-mabar-anda').addEventListener('click', function () {
  setActiveTab(this);
  const filtered = allMabarData.filter(m => {
    console.log("Filter check: ", m.user_pembuat_mabar?._id, jwtUserId);
    return m.user_pembuat_mabar?._id === jwtUserId;
  });
  displayMabarList(filtered);
});


  document.getElementById('tab-mabar-diikuti').addEventListener('click', function () {
    setActiveTab(this);
    const filtered = allMabarData.filter(m => 
      m.user_pembuat_mabar?._id !== jwtUserId && m.user_yang_join?.includes(jwtUserId)
    );
    displayMabarList(filtered);
  });
});

function setActiveTab(clickedTab) {
  document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
  clickedTab.classList.add('active');
}

function fetchMabarList() {
  fetch("http://localhost:3000/api/v1/mabar")
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


function displayMabarList(data) {
    const container = document.getElementById("mabar-list");
    container.innerHTML = "";

    if (data.length === 0) {
        container.innerHTML = "<p>Tidak ada mabar yang tersedia.</p>";
        return;
    }

    data.forEach(mabar => {
        const pembuat = mabar.user_pembuat_mabar?.nama || 'Tidak diketahui';
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

        const mabarHTML = `
            <div class="card-wrapper">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                            <strong>${mabar.user_pembuat_mabar.name}</strong>
                        </div>
                        <h5 class="card-title">${mabar.nama_mabar}</h5>

                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i> ${tanggalFormatted} * ${jamMulai} - ${jamSelesai}
                        </p>

                        <p class="mb-1">Lapangan ${jadwal[0]?.lapangan || '-'}</p>
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
