@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.jwt = "{{ session('jwt') ?? '' }}";
    window.loginUrl = "{{ route('login') }}";
</script>

<title>Jadwal Bermain</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    /* --- CSS sama seperti sebelumnya --- */
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

    .jadwal-slot.available:hover {
        background-color: #c8f0c8;
    }

    .jadwal-slot.dipilih {
        background-color: #085F06;
        color: #ffffff;
    }

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

    .circle {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .green { background-color: green; }
    .red { background-color: red; }
    .white { background-color: white; }

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

    <div class="row" id="jadwalContainer"></div>

    <div class="legend">
        <div class="legend-item"><div class="circle white"></div> Jadwal tersedia</div>
        <div class="legend-item"><div class="circle red"></div> Jadwal sudah di-booking</div>
        <div class="legend-item"><div class="circle green"></div> Jadwal dipilih</div>
        <div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>
    </div>

    <div class="d-flex gap-2 mt-3">
    <form action="/detail_pesanan" method="GET" onsubmit="return cekSebelumSubmit()">
        <input type="submit" class="lanjutkan btn btn-primary" value="Lanjutkan">
    </form>
    <button id="resetBtn" type="button" class="lanjutkan btn btn-secondary" onclick="resetPilihan()">Reset Pilihan</button>
</div>

</div>

<script>
function formatJam(jam) {
    const jamInt = parseInt(jam, 10); // konversi ke integer
    const jamAwal = jamInt.toString().padStart(2, '0') + ":00";
    const jamAkhir = (jamInt + 1).toString().padStart(2, '0') + ":00";
    return `${jamAwal} - ${jamAkhir}`;
}


function renderjadwal(jadwalData) {
    const container = document.getElementById("jadwalContainer");
    container.innerHTML = "";

    const selected = JSON.parse(sessionStorage.getItem('selectedSlots')) || [];

    if (!jadwalData || jadwalData.length === 0) {
        container.innerHTML = "<p>Tidak ada jadwal tersedia.</p>";
        return;
    }

    const grouped = jadwalData.reduce((acc, item) => {
        const lapangan = item.lapangan?.name || "Tanpa Nama";
        acc[lapangan] = acc[lapangan] || [];
        acc[lapangan].push(item);
        return acc;
    }, {});

    Object.keys(grouped).forEach(lapangan => {
        const lapanganDiv = document.createElement("div");
        lapanganDiv.classList.add("lapangan-container");

        const title = document.createElement("h3");
        title.textContent = lapangan;
        lapanganDiv.appendChild(title);

        const slotGrid = document.createElement("div");
        slotGrid.classList.add("slot-grid");

        grouped[lapangan].sort((a, b) => a.jam - b.jam).forEach(item => {
            const slot = document.createElement("div");
            slot.classList.add("jadwal-slot");
            slot.setAttribute("data-id", item._id);

            if (item.status_booking === "Tersedia") {
                slot.classList.add("available");

                const isSelected = selected.find(s => s._id === item._id);
                if (isSelected) slot.classList.add("dipilih");

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
                    } else {
                        selected.push(dataToSave);
                        slot.classList.add("dipilih");
                    }

                    sessionStorage.setItem('selectedSlots', JSON.stringify(selected));

                    updateResetButtonStatus();
                });
            } else {
                slot.classList.add("unavailable");
            }

            slot.innerHTML = `
                <div style="margin-bottom: 6px;">${formatJam(item.jam)}</div>
                <div class="harga">Rp ${item.harga?.toLocaleString('id-ID') ?? '-'}</div>
            `;
            slotGrid.appendChild(slot);
        });

        lapanganDiv.appendChild(slotGrid);
        container.appendChild(lapanganDiv);
    });

    updateResetButtonStatus(); // <== Pastikan ini ada di akhir!
}

async function fetchJadwalByTanggal(tanggal) {
    if (!tanggal) {
        alert('Tanggal belum dipilih.');
        return;
    }

    try {
        const baseUrl = document.getElementById('base-url').textContent;
        if (!baseUrl) throw new Error('API Base URL tidak ditemukan');

        const response = await fetch(`${baseUrl}jadwal/tanggal/${tanggal}`);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();
        renderjadwal(data);
    } catch (err) {
        console.error("Fetch error:", err);
        alert('Gagal mengambil data jadwal.');
    }
}

async function resetPilihan() {
    sessionStorage.removeItem('selectedSlots');

    const tanggal = document.getElementById('tanggal').value;

    // Tunggu data jadwal selesai dimuat
    await fetchJadwalByTanggal(tanggal);

    // Tunggu render selesai dulu sebelum update tombol
    setTimeout(() => {
        updateResetButtonStatus();
    }, 300); // atau kamu bisa panggil langsung jika yakin render selesai di renderjadwal()
}





function updateResetButtonStatus() {
    const resetBtn = document.getElementById("resetBtn");
    const selected = JSON.parse(sessionStorage.getItem("selectedSlots")) || [];
    console.log("Selected slots:", selected); // DEBUG
    resetBtn.disabled = selected.length === 0;
}


function pilihSlot(slotId) {
    let selected = JSON.parse(sessionStorage.getItem("selectedSlots")) || [];
    
    // Cek apakah sudah ada
    if (!selected.includes(slotId)) {
        selected.push(slotId);
    }

    sessionStorage.setItem("selectedSlots", JSON.stringify(selected));
    updateResetButtonStatus();
}

function hapusSlot(slotId) {
    let selected = JSON.parse(sessionStorage.getItem("selectedSlots")) || [];

    selected = selected.filter(id => id !== slotId);

    sessionStorage.setItem("selectedSlots", JSON.stringify(selected));
    updateResetButtonStatus();
}

    // Saat halaman dimuat, set tombol Reset sesuai data
    document.addEventListener("DOMContentLoaded", function () {
        const selected = JSON.parse(sessionStorage.getItem("selectedSlots")) || [];
        document.getElementById("resetBtn").disabled = selected.length === 0;
    });

function cekSebelumSubmit() {
    const selected = JSON.parse(sessionStorage.getItem('selectedSlots') || "[]");
    if (selected.length === 0) {
        alert("Pilih minimal satu slot terlebih dahulu.");
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    const tanggalInput = document.getElementById('tanggal');
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.value = today;
    fetchJadwalByTanggal(today);

    tanggalInput.addEventListener('change', function () {
        const tanggal = this.value;
        const selected = JSON.parse(sessionStorage.getItem('selectedSlots') || "[]")
            .filter(s => s.tanggal === tanggal);
        sessionStorage.setItem('selectedSlots', JSON.stringify(selected));
        fetchJadwalByTanggal(tanggal);
    });
});
</script>
@endsection
