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

    .jadwal-item {
        color: red;
    }

    .time-slot {
        display: flex;
        align-items: center;
        padding: 5px 10px;
        border-bottom: 1px solid #dee2e6;
    }
    .circle {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }
    .green { background-color: green; }
    .red { background-color: red; }
    .grey { background-color: grey; }
    .blue { background-color: blue; }
    .orange { background-color: orange; }
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
            <div class="legend-item"><div class="circle green"></div> Jadwal tersedia</div>
            <div class="legend-item"><div class="circle red"></div> Jadwal sudah di-booking</div>
            <div class="legend-item"><div class="circle blue"></div> Jadwal Dipilih</div>
            <div class="legend-item"><div class="circle grey"></div> Jadwal Tetap</div>
            <div class="legend-item"><div class="circle orange"></div> Jadwal Member</div>
        </div>
    </div>

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
        const lapanganName = item.lapangan; // Asumsi 'lapangan' adalah nama lapangan
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
        lapanganDiv.innerHTML = `<h3>Lapangan: ${lapangan}</h3>`;  // Tampilkan nama lapangan

        // Buat tabel untuk menampilkan jadwal
        const table = document.createElement("table");
        table.classList.add("jadwal-table");

        // Buat header tabel
        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        headerRow.innerHTML = "<th>Jam</th>"; // Header untuk kolom Jam
        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Buat badan tabel (tbody)
        const tbody = document.createElement("tbody");

        // Urutkan jadwal berdasarkan jam
        groupedByLapangan[lapangan].sort((a, b) => {
            return a.jam - b.jam; // Urutkan berdasarkan jam
        });

        // Tambahkan baris untuk setiap jadwal
        groupedByLapangan[lapangan].forEach(item => {
            const row = document.createElement("tr");

            const jamCell = document.createElement("td");
            jamCell.textContent = item.jam ? item.jam : "Jam tidak tersedia";

            row.appendChild(jamCell);
            tbody.appendChild(row);
        });

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
        const response = await fetch(`http://localhost:3000/api/v1/jadwal/tanggal/${tanggal}`);

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
