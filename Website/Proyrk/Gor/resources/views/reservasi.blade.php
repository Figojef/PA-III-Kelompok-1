@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.jwt = "{{ session('jwt') ?? '' }}";
    window.loginUrl = "{{ route('login') }}";
</script>

<title>Jadwal Bermain</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

    .jadwal-slot.expired {
    opacity: 0.3; /* Mengurangi kecerahan untuk menunjukkan slot sudah lewat */
    pointer-events: none; /* Nonaktifkan interaksi, agar tidak bisa diklik */
    background-color: #f5f5f5; /* Warna latar belakang lebih terang untuk slot expired */
}
    

</style>

<div class="container mt-4">
    <h4>Jadwal bermain</h4>

<div class="mb-3">
    <label for="tanggal" class="form-label">Pilih Tanggal</label>
    <input type="text" id="tanggal" class="form-control" placeholder="Pilih Tanggal">
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

    // Ambil waktu sekarang dalam zona waktu Asia/Jakarta
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" });
    const nowDate = new Date(now);  // Waktu sekarang dalam objek Date

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

    // Ambil jam dari angka dan konversi menjadi waktu yang dapat dibandingkan
    const jam = item.jam.toString().padStart(2, "0"); // Menambah angka 0 di depan jika jam < 10
    const tanggalSlot = new Date(`${document.getElementById("tanggal").value} ${jam}:00`);

    // Jika jadwal sudah lewat, beri kelas "expired"
    if (tanggalSlot <= nowDate) {
        slot.classList.add("expired");
    } else if (item.status_booking === "Tersedia") {
        slot.classList.add("available");

        const isSelected = selected.find(s => s._id === item._id);
        if (isSelected) slot.classList.add("dipilih");

        slot.addEventListener('click', () => {
            if (!window.jwt) {
                // Menampilkan SweetAlert2 jika belum login
                Swal.fire({
                    icon: 'warning',
                    title: 'Untuk memesan lapangan harus login',
                    text: 'Apakah Anda ingin login?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true,
                    allowOutsideClick: false, // Mencegah klik di luar alert
                    allowEscapeKey: false, // Mencegah menutup alert dengan tombol Escape
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Arahkan ke halaman login jika pengguna memilih 'Ya'
                        window.location.href = window.loginUrl;
                    }
                });
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
    showToast("Jadwal Dibatalkan.", "warning");
} else {
    selected.push(dataToSave);
    slot.classList.add("dipilih");
    showToast("Jadwal Berhasil ditambahkan.", "success");
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

    updateResetButtonStatus(); // Pastikan ini ada di akhir!
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
        // Menanyakan konfirmasi sebelum reset pilihan
        const result = await Swal.fire({
            title: 'Anda yakin ingin mereset pilihan?',
            text: 'Semua pilihan yang telah dipilih akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Tidak',
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            // Hapus selectedSlots dari sessionStorage
            sessionStorage.removeItem('selectedSlots');

            const tanggal = document.getElementById('tanggal').value;

            // Tunggu data jadwal selesai dimuat
            await fetchJadwalByTanggal(tanggal);

            // Tunggu render selesai sebelum update tombol
            setTimeout(() => {
                updateResetButtonStatus();
            }, 300); // atau panggil langsung jika yakin render selesai di renderjadwal()
        }
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

flatpickr("#tanggal", {
        dateFormat: "Y-m-d", // Format tanggal
        minDate: "today", // Membatasi tanggal hanya hari ini atau setelahnya
        maxDate: new Date().fp_incr(30), // Maksimal 30 hari ke depan
    });


    function showToast(message, type = "primary") {
    const toastEl = document.getElementById("liveToast");
    const toastBody = document.getElementById("toastMessage");

    toastBody.textContent = message;
    toastEl.className = `toast align-items-center text-white bg-${type} border-0`;

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}



</script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert')['type'] }}',
                title: '{{ session('alert')['title'] }}',
                text: '{{ session('alert')['message'] }}',
            });
        </script>
    @endif

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div
    id="liveToast"
    class="toast align-items-center text-white bg-success border-0"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
    data-bs-autohide="true"
    data-bs-delay="1000"
  >
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">
        Slot ditambahkan!
      </div>
      <button
        type="button"
        class="btn-close btn-close-white me-2 m-auto"
        data-bs-dismiss="toast"
        aria-label="Close"
      ></button>
    </div>
  </div>
</div>


@endsection
