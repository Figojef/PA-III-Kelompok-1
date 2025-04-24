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
    .jadwal-header {
        background-color: #343a40;
        color: #fff;
        padding: 8px 12px;
    }
    .jadwal-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
    }


    
    .lapangan-container {
    margin-bottom: 2rem;
}

.slot-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 1rem;
}

.jadwal-slot {
    padding: 25px;
    text-align: center;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-weight: bold;
    background-color: white;
    cursor: default;
    transition: all 0.2s ease;
}

.jadwal-slot.available {
    background-color: #ffffff;
    color: #000000;
    cursor: pointer;
}

.jadwal-slot.unavailable {
    background-color: #F93232;
    color: #ffffff;
    cursor: not-allowed;
}
.jadwal-slot.available .harga {
    color: #000000; 
}

.jadwal-slot.unavailable .harga {
    color: #ffffff; 
}

.jadwal-slot.available:hover {
    background-color: #c8f0c8;
}

.jadwal-slot.dipilih {
    background-color: #085F06;
    color: #ffffff;
}
.jadwal-slot.dipilih .harga{
    color: #ffffff;
}

    .jadwal-item {
        color: red;
    }
    .slot.dipilih {
    background-color: #4CAF50; /* hijau */
    color: white;
    border: 2px solid #388E3C;
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
    .white { background-color: white; }
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

    .lanjutkan {
        margin-top: 50px;
        padding: 15px 180px;
        background-color: #222F37;
        color: #ffffff;
        border-radius: 7px;
        font-weight: bold;
        font-size: 20px;

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
            <div class="legend-item"><div class="circle white"></div> Jadwal tersedia</div>
            <div class="legend-item"><div class="circle red"></div> Jadwal sudah di-booking</div>
            <div class="legend-item"><div class="circle green"></div> Jadwal Dipilih</div>
            <div id="base-url" style="display:none">{{env('API_BASE_URL')}}</div>
        </div>
        <form id="pemesananForm" method="POST" action="{{ route('pemesanan.store') }}">
    @csrf
    <input type="hidden" name="jadwal_dipesan" id="jadwal_dipesan">
    <input type="hidden" name="total_harga" id="total_harga">
    <input type="hidden" name="status_pemesanan" id="status_pemesanan" value="Sedang Dipesan">
    <input type="submit" class="lanjutkan" value="Lanjutkan" id="lanjutkanBtn">
</form>

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

    // Ambil data dari sessionStorage (selectedSlots)
    let selected = JSON.parse(sessionStorage.getItem('selectedSlots')) || [];

    if (!jadwalData || jadwalData.length === 0) {
        container.innerHTML = "<p>Tidak ada jadwal tersedia.</p>";
        return;
    }

    // Kelompokkan jadwal berdasarkan lapangan
    const groupedByLapangan = jadwalData.reduce((acc, item) => {
        const lapanganName = item.lapangan?.name || "Tanpa Nama";
        if (!acc[lapanganName]) {
            acc[lapanganName] = [];
        }
        acc[lapanganName].push(item);
        return acc;
    }, {});

    // Tampilkan jadwal per lapangan
    Object.keys(groupedByLapangan).forEach(lapangan => {
        const lapanganDiv = document.createElement("div");
        lapanganDiv.classList.add("lapangan-container");

        const title = document.createElement("h3");
        title.textContent = lapangan;
        lapanganDiv.appendChild(title);

        const slotGrid = document.createElement("div");
        slotGrid.classList.add("slot-grid");

        groupedByLapangan[lapangan].sort((a, b) => a.jam - b.jam).forEach(item => {
            const slot = document.createElement("div");
            slot.classList.add("jadwal-slot");

            // Tambahkan class warna berdasar status
            if (item.status === "Tersedia") {
                slot.classList.add("available");
                    
                const isSelected = selected.find(s => s._id === item._id);
                if (isSelected) {
                    slot.classList.add("dipilih");
                }

                slot.addEventListener('click', () => {
                    if (!window.jwt) {
                        alert("Silakan login terlebih dahulu untuk memilih jadwal.");
                        window.location.href = window.loginUrl;
                        return;
                    }

                    const dataToSave = {
                        _id: item._id,
                        lapangan: item.lapangan,
                        jam: item.jam,
                        tanggal: document.getElementById("tanggal").value,
                        harga: item.harga
                    };

                    const index = selected.findIndex(s => s._id === dataToSave._id);

                    if (index > -1) {
                        selected.splice(index, 1);
                        slot.classList.remove("dipilih");
                        alert("Slot dibatalkan:\n" + JSON.stringify(dataToSave, null, 2));
                        console.log("Slot dibatalkan:", dataToSave);
                    } else {
                        selected.push(dataToSave);
                        slot.classList.add("dipilih");
                        alert("Slot dipilih:\n" + JSON.stringify(dataToSave, null, 2));
                        console.log("Slot dipilih:", dataToSave);
                    }

                    // Update sessionStorage
                    sessionStorage.setItem('selectedSlots', JSON.stringify(selected));
                });
            }

            else if (item.status === "Tidak Tersedia") {
                    slot.classList.add("unavailable");
            }
            const jamInt = parseInt(item.jam, 10);
            const jamAwal = jamInt.toString().padStart(2, '0') + ":00";
            const jamAkhir = (jamInt + 1).toString().padStart(2, '0') + ":00";

            slot.innerHTML = `
                <div style="margin-bottom: 6px;">${jamAwal} - ${jamAkhir}</div>
                <div class="harga">Rp ${item.harga?.toLocaleString('id-ID') ?? '-'}</div>
            `;

            slotGrid.appendChild(slot);
        });

        lapanganDiv.appendChild(slotGrid);
        container.appendChild(lapanganDiv);
    });
}




async function fetchJadwalByTanggal(tanggal) {
    // Cek apakah tanggal kosong
    if (!tanggal) {
        alert('Tanggal belum dipilih.');
        return;
    }

    try {
        const apiBaseUrl = document.getElementById('base-url').textContent;

                    // Memastikan nilai API_BASE_URL berhasil diambil
                    if (!apiBaseUrl) {
                throw new Error('API Base URL tidak ditemukan');
            }

            const response = await fetch(`${apiBaseUrl}jadwal/tanggal/${tanggal}`);

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

document.addEventListener('DOMContentLoaded', function () {
    const selectedCookie = document.cookie.split('; ').find(row => row.startsWith('selectedSlots='));
    let selected = [];
    if (selectedCookie) {
        try {
            selected = JSON.parse(decodeURIComponent(selectedCookie.split('=')[1]));
        } catch (e) {
            console.error("Gagal parsing cookie:", e);
        }
    }

    // Restore tampilan slot yang sudah dipilih
    selected.forEach(slot => {
        const element = document.querySelector(`.slot[data-id="${slot._id}"]`);
        if (element) {
            element.classList.add("dipilih");
        }
    });
});

// Handler untuk tombol lanjutkan
document.getElementById("lanjutkanBtn").addEventListener("click", function(event) {
    event.preventDefault();  // Mencegah submit default

    const selectedCookie = document.cookie.split('; ').find(row => row.startsWith('selectedSlots='));

    if (!selectedCookie) {
        alert("Silakan pilih jadwal terlebih dahulu sebelum melanjutkan.");
        return;
    }

    let selected = [];
    try {
        selected = JSON.parse(decodeURIComponent(selectedCookie.split('=')[1]));
    } catch (e) {
        alert("Terjadi kesalahan membaca data jadwal.");
        return;
    }

    if (selected.length === 0) {
        alert("Silakan pilih jadwal terlebih dahulu.");
        return;
    }

    const jadwalIds = selected.map(slot => slot._id);
    const totalHarga = selected.reduce((total, slot) => total + (slot.harga || 0), 0);

    document.getElementById('jadwal_dipesan').value = JSON.stringify(jadwalIds);
    document.getElementById('total_harga').value = totalHarga;

    // Validasi akhir sebelum submit
    if (!jadwalIds.length || !totalHarga) {
        alert("Data form tidak lengkap!");
        return;
    }

    document.getElementById("pemesananForm").submit();
});

// Event listener untuk memilih tanggal
document.getElementById('tanggal').addEventListener('change', function () {
    fetchJadwalByTanggal(this.value);
});

if (window.location.search.includes("logout=true")) {
        sessionStorage.removeItem('selectedSlots');
        console.log("selectedSlots dihapus karena logout");
    }

    </script>

@endsection