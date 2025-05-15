@extends('layouts.app')

@section('content')

<title>Jadwal Bermain</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    .jadwal-header {
        background-color: #343a40;
        color: #fff;
        padding: 8px 12px;
    }


    .jadwal-table th,
    .jadwal-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    }

    .jadwal-table th {
    background-color: #222F37;
    font-weight: bold;
    }



    .jadwal-item {
        color: red;
    }

    .time-slot {
        display: flex;
        align-items: center;
        padding: 5px 10px;
        border-bottom: 1px solid #dee2e6;
    }
    .jam-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    }

    .jam-box {
    padding: 20px 20px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-weight: 500;
    text-align: center;
    min-width: 100px;
    transition: background-color 0.2s ease;
        }

        .jam-box:not(.red-bg):hover {
    background-color: #e2e6ea;
    cursor: pointer;
}


.green-bg { background-color: #FFFFFF; color: #000000; }
.red-bg { background-color: #F93232; color: #FFFFFF; }
.grey-bg { background-color: #e2e3e5; color: #383d41; }
.blue-bg { background-color: #d1ecf1; color: #0c5460; }
.orange-bg { background-color: #fff3cd; color: #856404; }

    .square {
        width: 10px;
        height: 10px;
        margin-right: 8px;
    }
    .green { background-color: green; }
    .red { background-color: red; }
    .grey { background-color: grey; }
    .legend {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 15px;
    }
    .legend-item {
        display: flex;
        align-items: center;
    }
</style>

    <div class="container mt-4">
        <h4>Jadwal bermain</h4>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Pilih Tanggal</label>
            <input type="date" id="tanggal" class="form-control">
        </div>

        <div class="row" id="jadwalContainer">
            <!-- Konten Jadwal Akan Dimanipulasi Lewat JavaScript -->
        </div>

        <div class="legend">
            <div class="legend-item"><div class="square grey"></div> Jadwal tersedia</div>
            <div class="legend-item"><div class="square green"></div> Jadwal sudah di-booking</div>
            <div class="legend-item"><div class="square red"></div> Tidak Tersedia</div>
        </div>
    </div>

<div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>

    <script>


function renderjadwal(jadwalData) {
    console.log("Data diterima di renderjadwal:", jadwalData);

    const container = document.getElementById("jadwalContainer");
    if (!container) {
        console.error("Element jadwalContainer tidak ditemukan di HTML.");
        return;
    }

    container.innerHTML = ""; // Hapus konten lama

    if (!jadwalData || jadwalData.length === 0) {
        container.innerHTML = "<p>Tidak ada jadwal tersedia.</p>";
        return;
    }

    // Kelompokkan jadwal berdasarkan lapangan
    const groupedByLapangan = jadwalData.reduce((acc, item) => {
        const lapanganName = item.lapangan?.name; 
        if (!acc[lapanganName]) {
            acc[lapanganName] = [];
        }
        acc[lapanganName].push(item);
        return acc;
    }, {});

    // Urutkan dan tampilkan setiap grup lapangan
    Object.keys(groupedByLapangan).forEach(lapangan => {
        
        const lapanganDiv = document.createElement("div");
        lapanganDiv.classList.add("lapangan-container");
        lapanganDiv.innerHTML = `<h3>${lapangan}</h3>`;  // Tampilkan nama lapangan

        // Buat tabel untuk menampilkan jadwal
        const table = document.createElement("table");
        table.classList.add("jadwal-table");

        // Buat header tabel
        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Buat badan tabel (tbody)
        const tbody = document.createElement("tbody");

        // Urutkan jadwal berdasarkan jam
        groupedByLapangan[lapangan].sort((a, b) => {
            return a.jam - b.jam; // Urutkan berdasarkan jam
        });

// Container kotak-kotak jam
const kotakWrapper = document.createElement("div");
kotakWrapper.classList.add("jam-wrapper");

groupedByLapangan[lapangan].forEach(item => {
    const jamBox = document.createElement("div");
    jamBox.classList.add("jam-box");

    let startHour = "??", endHour = "??";
    if (item.jam != null) {
        const jamAwal = parseInt(item.jam);
        startHour = String(jamAwal).padStart(2, "0");
        endHour = String(jamAwal + 1).padStart(2, "0");
    }

    const statusText = item.status ? item.status : "Status tidak diketahui";

    // Tambahkan class background berdasarkan status
    if (item.status === "Tersedia") {
        jamBox.classList.add("green-bg");
    } else if (item.status === "Tidak Tersedia") {
        jamBox.classList.add("red-bg");
    } else if (item.status === "Pending") {
        jamBox.classList.add("grey-bg");
    } else if (item.status === "Dipesan") {
        jamBox.classList.add("blue-bg");
    } else if (item.status === "Dibatalkan") {
        jamBox.classList.add("orange-bg");
    }

    // Tampilkan jam dan status di dalam kotak
    jamBox.innerHTML = `
        <div>${startHour}:00 - ${endHour}:00</div>
        <div style="font-size: 14px; margin-top: 4px;">${statusText}</div>
    `;

    kotakWrapper.appendChild(jamBox);
});


lapanganDiv.appendChild(kotakWrapper);



        // Tambahkan tbody ke dalam tabel
        table.appendChild(tbody);

        // Tambahkan tabel ke dalam lapanganDiv
        lapanganDiv.appendChild(table);

        // Tambahkan lapanganDiv ke dalam container utama
        container.appendChild(lapanganDiv);
    });
}

async function fetchJadwalByTanggal(tanggal) {
  try {
    const baseUrl = document.getElementById('base-url').textContent.trim().replace(/\/+$/, '');
    const response = await fetch(`${baseUrl}/jadwal/tanggal/${tanggal}`);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    console.log(data); // Cek data di console

    if (!data || data.length === 0) {
      alert('Jadwal tidak ditemukan');
      return;
    }

    renderjadwal(data);
  } catch (error) {
    console.error("Error fetching jadwal:", error);
    alert('Terjadi kesalahan saat mengambil data jadwal.');
  }
}

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('tanggal').value = today; // Set nilai input tanggal dengan hari ini

    // Fetch jadwal untuk hari ini secara otomatis saat halaman dimuat
    fetchJadwalByTanggal(today);
});

// Event listener untuk memilih tanggal
document.getElementById('tanggal').addEventListener('change', function () {
    fetchJadwalByTanggal(this.value);
});
    </script>

@endsection
