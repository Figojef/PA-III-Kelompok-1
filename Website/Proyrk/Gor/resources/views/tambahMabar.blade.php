@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Tambah Mabar</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  .range-umur {
    display: flex;
    gap: 10px;
  }
  .range-umur input {
    flex: 1;
  }
</style>

<div class="container mt-4">
    <h3 class="mb-3">Tambah Mabar</h3>
    <hr style="border: 2px solid #000000; margin: 20px 0;">

    <div class="row">
  <!-- Kolom Kiri: Form Input -->
  <div class="col-md-6">
  <form id="mabarForm" action="{{ route('mabar.buat-mabar') }}" method="POST">
  @csrf
      <!-- Nama Mabar -->
      <div class="mb-3">
        <label for="nama_mabar" class="form-label">
          Nama Mabar
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Judul atau nama dari acara Mabar."></i>
        </label>
        <input type="text" class="form-control" id="nama_mabar" name="nama_mabar" placeholder="Contoh: Seru - Seruan">
      </div>

      <!-- Jadwal dan Lapangan -->
      <div class="mb-3">
        <label for="lapangan" class="form-label">
          Lapangan dan Waktu
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Pilih jadwal & lapangan yang sudah dipesan. Untuk 2 jadwal, harus waktu berturut-turut."></i>
        </label>
        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#jadwalModal">
          Pilih Lapangan & Jadwal
        </button>
        <input type="hidden" id="lapangan" name="lapangan">
        <div id="selectedJadwalDisplay" class="mt-2 text-muted fst-italic"></div>
      </div>

      <!-- Biaya -->
      <div class="mb-3">
        <label for="biaya" class="form-label">
          Biaya
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Masukkan biaya untuk ikut mabar, misal 5000"></i>
        </label>
        <input type="number" class="form-control" id="biaya" name="biaya" placeholder="Contoh: 10000">
      </div>

      <!-- Range Umur -->
      <div class="mb-3">
        <label for="umur_min" class="form-label">
          Range Umur
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Isi rentang umur peserta, contoh: 17 - 25."></i>
        </label>
        <div class="d-flex gap-2">
          <input type="number" class="form-control" id="umur_min" name="umur_min" placeholder="Min">
          <input type="number" class="form-control" id="umur_max" name="umur_max" placeholder="Max">
        </div>
      </div>

      <!-- Level -->
      <div class="mb-3">
        <label for="level" class="form-label">
          Level
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Sesuaikan dengan level yang diinginkan"></i>
        </label>
        <select class="form-select" id="level" name="level">
          <option value="" disabled selected>Pilih level</option>
          <option value="Pemula">Pemula</option>
          <option value="Menengah">Menengah</option>
          <option value="Profesional">Profesional</option>
        </select>
      </div>

      <!-- Kategori -->
      <div class="mb-3">
        <label for="kategori" class="form-label">
          Kategori
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Sesuaikan dengan tipe permainan yang diinginkan"></i>
        </label>
        <select class="form-select" id="kategori" name="kategori">
          <option value="" disabled selected>Pilih kategori</option>
          <option value="Fun">Fun</option>
          <option value="Competitive">Competitive</option>
        </select>
      </div>

      <!-- Slot Peserta -->
      <div class="mb-3">
        <label for="slot" class="form-label">
          Slot Peserta
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Jumlah maksimal peserta, misalnya 10."></i>
        </label>
        <input type="number" class="form-control" id="slot" name="slot" placeholder="Contoh: 10">
      </div>

      <!-- Deskripsi -->
      <div class="mb-3">
        <label for="deskripsi" class="form-label">
          Deskripsi
          <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Penjelasan singkat tentang mabar."></i>
        </label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Contoh: Ayo main Tunjukan Kemampuanmu"></textarea>
      </div>

      <!-- Persetujuan -->
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="termsCheckbox" required>
        <label class="form-check-label" for="termsCheckbox">
          Dengan ini saya menyetujui, menyatakan dan menyadari sepenuhnya untuk hanya membuat event olahraga tanpa mengandung unsur SARA, asusila dan sebagainya yang melanggar hukum dan norma-norma etika yang berjalan. Segala risiko dan konsekuensi yang timbul merupakan tanggung jawab saya.
        </label>
      </div>

      <!-- Tombol Submit -->
      <button type="submit" class="btn btn-dark">Buat Mabar</button>
      <!-- <input type="hidden" name="jadwal_dipesan[]" id="jadwalHiddenInput"> -->
      <input type="hidden" id="userId" name="user_id" value="{{ Session::get('user_data')['_id'] }}">
      <!-- kosongkan dari awal -->
<div id="jadwalHiddenInput"></div>
    </form>
    
  </div>


        <!-- Kolom Kanan: Preview -->
        <div class="col-md-6">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Preview Event Mabar
        </div>
        <div class="card-body">
            <div class="mb-4">
                <strong>Nama Mabar</strong>
                <div id="previewMabarName" class="mb-3">-</div>
                <!-- Hapus Jadwal dan Deskripsi jika tidak dibutuhkan -->
                <div class="mb-2">
                    <strong>Lapangan (Jadwal)</strong>
                    <div id="previewJadwal">-</div>
                </div>
                <div class="mb-2">
                    <strong>Biaya</strong>
                    <div id="previewBiaya">-</div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script -->
<script>

function updatePreviewJadwal() {
  const data = loadSelectedFromSession();
  if (data.length > 0) {
    document.getElementById("previewJadwal").innerHTML = data
      .map(j => j.info)
      .join("<br>");
  } else {
    document.getElementById("previewJadwal").innerText = "-";
  }
}

// Mengubah Format Tanggal
function formatTanggalLengkap(tanggalStr) {
  const tanggalObj = new Date(tanggalStr);
  const hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  const hari = hariList[tanggalObj.getDay()];
  const tanggal = tanggalObj.getDate();
  const bulan = bulanList[tanggalObj.getMonth()];
  const tahun = tanggalObj.getFullYear();

  return `${hari}, ${tanggal} ${bulan} ${tahun}`;
}

function formatJam(jam) {
    const jamInt = parseInt(jam, 10);
    const jamAwal = jamInt.toString().padStart(2, '0') + ":00";
    const jamAkhir = (jamInt + 1).toString().padStart(2, '0') + ":00";
    return `${jamAwal} - ${jamAkhir}`;
}

    function formatRupiah(value) {
        const angka = parseInt(value.replace(/\D/g, ''));
        return isNaN(angka) ? '-' : 'Rp. ' + angka.toLocaleString('id-ID');
    }

    function updatePreview() {
    // Mengambil nilai Nama Mabar
    document.getElementById('previewMabarName').innerText = document.getElementById('nama_mabar')?.value || '-';

    // Mengambil nilai Jadwal
    const selectedJadwal = loadSelectedFromSession(); // Load jadwal yang disimpan dalam session
    if (selectedJadwal.length > 0) {
        // Menampilkan jadwal yang dipilih
        document.getElementById('previewJadwal').innerHTML = selectedJadwal
            .map(j => j.info) // Ambil info dari jadwal yang sudah dipilih
            .join("<br>");
    } else {
        document.getElementById('previewJadwal').innerText = "-";
    }

    // Mengambil dan memformat Biaya
    const biayaVal = document.getElementById('biaya')?.value || '';
    document.getElementById('previewBiaya').innerText = formatRupiah(biayaVal);
}




    function saveSelectedToSession() {
  sessionStorage.setItem('selectedJadwal', JSON.stringify(selectedJadwal));
}

function loadSelectedFromSession() {
  const data = sessionStorage.getItem('selectedJadwal');
  return data ? JSON.parse(data) : [];
}


document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    document.querySelectorAll('#mabarForm input, #mabarForm textarea, #mabarForm select').forEach(el => {
    el.addEventListener('input', updatePreview);
    el.addEventListener('change', updatePreview);
})

    // Tambahkan log untuk debugging
    const previewBiayaElem = document.getElementById('previewBiaya');
    if (previewBiayaElem) {
        updatePreview(); // hanya panggil updatePreview jika elemen sudah ada
    } else {
        console.error("Elemen previewBiaya belum ditemukan saat DOMContentLoaded");
    }
});


    // Mengatur agar tidak bisa lanjutkan bila checkbox belum di check, dan mengeluarkan notif
    document.querySelector('form').addEventListener('submit', function (e) {
  const checkbox = document.getElementById('termsCheckbox');
  if (!checkbox.checked) {
    e.preventDefault();
    const toast = new bootstrap.Toast(document.getElementById('termsToast'));
    toast.show();
  }
});


  // Tambahkan ini di atas listener DOMContentLoaded
  let selectedJadwal = []; // Simpan jadwal yang dipilih

  function isJadwalBerurutan(listJam) {
  if (listJam.length <= 1) return true;  // Jika hanya ada 1 atau tidak ada jadwal, anggap valid

  const sorted = [...listJam].sort((a, b) => a - b);
  for (let i = 0; i < sorted.length - 1; i++) {
    if (sorted[i + 1] - sorted[i] !== 1) {
      return false;
    }
  }
  return true;
}




  // Menampilkan pilihan jadwal
  document.addEventListener("DOMContentLoaded", function () {
  const tombolPilih = document.querySelector('[data-bs-target="#jadwalModal"]');
  const userId = document.getElementById('userId').value;

  tombolPilih.addEventListener("click", async function () {
    try {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch("http://localhost:3000/api/v1/mabar/select_jadwal", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": token
      },
      body: JSON.stringify({ user_id: userId }),
    });

    const result = await response.json();
    const display = document.getElementById("jadwalListModal"); 


    if (result && result.data && result.data.length > 0) {
        display.innerHTML = result.data.map((jadwal, index) => {
  const lapangan = jadwal.lapangan?.name ?? 'Tidak Diketahui';
  const gambar = jadwal.lapangan?.gambar ?? null;
  const jam = jadwal.jam;
  const tanggal = formatTanggalLengkap(jadwal.tanggal);
  const jadwalInfo = `${lapangan} - ${tanggal} Pukul ${formatJam(jam)}`;




  return `
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 p-2 border rounded">
      <div class="d-flex align-items-center gap-3">
        ${gambar ? `<img src="${gambar}" alt="Gambar Lapangan" style="width: 150px; height: auto; border-radius: 8px;">
` : ''}
        <div>
          <div><strong>${lapangan}</strong></div>
          <div>${tanggal}<br>Pukul ${formatJam(jam)}</div>

        </div>
      </div>
<button type="button" class="btn btn-sm btn-primary pilih-jadwal mt-2 mt-md-0" 
  data-jam="${jam}" 
  data-tanggal="${jadwal.tanggal}" 
  data-lapangan="${lapangan}" 
  data-jadwal='${JSON.stringify(jadwalInfo)}' 
  data-id='${jadwal._id}'>
  Pilih
</button>

    </div>
  `;
}).join("");

    } else {
      display.innerHTML = "Tidak ada jadwal ditemukan.";
    }

    // Event listener untuk semua tombol "Pilih"
    setTimeout(() => {
  selectedJadwal = loadSelectedFromSession();

  function updateUI() {
  // Reset semua tombol "Pilih"
  document.querySelectorAll(".pilih-jadwal").forEach(btn => {
    btn.classList.remove("btn-success");
    btn.classList.add("btn-primary");
    btn.innerText = "Pilih";
  });

  // Tampilkan ulang pilihan yang sudah dipilih
  selectedJadwal.forEach(j => {
    const btn = document.querySelector(`.pilih-jadwal[data-id='${j.id}']`);
    if (btn) {
      btn.classList.remove("btn-primary");
      btn.classList.add("btn-success");
      btn.innerText = "Dipilih";
    }
  });

  // Tampilkan preview jadwal yang dipilih
  if (selectedJadwal.length > 0) {
    document.getElementById("lapangan").value = selectedJadwal.map(j => j.id).join(",");
    document.getElementById("selectedJadwalDisplay").innerHTML =
      `<div class="alert alert-success">Dipilih:<br>${selectedJadwal.map(j => j.info).join("<br>")}</div>`;
  } else {
    document.getElementById("lapangan").value = "";
    document.getElementById("selectedJadwalDisplay").innerHTML = "";
  }

    updatePreviewJadwal(); // <- tambahkan ini
  };

// Menangani klik tombol Pilih
document.querySelectorAll(".pilih-jadwal").forEach(btn => {
  btn.addEventListener("click", function () {
    const id = this.dataset.id;
    const info = this.dataset.jadwal;
    const jam = parseInt(this.dataset.jam, 10);
    const tanggal = this.dataset.tanggal;

    // Cek apakah sudah dipilih
    const index = selectedJadwal.findIndex(j => j.id === id);
    if (index > -1) {
      selectedJadwal.splice(index, 1); // Hapus jika sudah dipilih
    } else {
      const jamList = selectedJadwal.map(j => j.jam);
      jamList.push(jam);
      
      // Validasi jam harus berurutan
      if (!isJadwalBerurutan(jamList)) {
        alert("Jam harus berturut-turut.");
        return;
      }

      selectedJadwal.push({ id, info, jam, tanggal });
    }

    saveSelectedToSession();
    updateUI();
  });
});




updateUI(); // Panggil awal saat modal muncul
}, 300); // Beri waktu render dulu
} catch (error) {
  console.error("Gagal memuat jadwal:", error);
}
});
});


document.getElementById("mabarForm").addEventListener("submit", function (event) {
    event.preventDefault(); // ⬅️ Hentikan submit otomatis dulu

    const selectedJadwal = JSON.parse(sessionStorage.getItem("selectedJadwal") || "[]");
    const container = document.getElementById("jadwalHiddenInput");
    container.innerHTML = ""; // Kosongkan dulu

    // Cek apakah selectedJadwal ada
    console.log("Selected Jadwal:", selectedJadwal);
    
    // Jika tidak ada jadwal yang dipilih, tampilkan error
    if (selectedJadwal.length === 0) {
        alert("Pilih jadwal terlebih dahulu sebelum melanjutkan.");
        return; // Hentikan submit jika tidak ada jadwal yang dipilih
    }

    // Proses input untuk jadwal yang dipilih
    selectedJadwal.forEach(jadwal => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "jadwal_dipesan[]";
        input.value = jadwal.id;
        container.appendChild(input);
    });

    console.log("Data dikirim:", selectedJadwal);

    // Hapus selectedJadwal dari sessionStorage setelah disubmit
    sessionStorage.removeItem("selectedJadwal");

    try {
        // Cek jika data valid sebelum submit
        if (selectedJadwal.length > 0) {
            // Tampilkan SweetAlert setelah form disubmit
            Swal.fire({
                title: 'Mabar Berhasil Dibuat!',
                text: 'Mabar Anda telah berhasil dibuat. Klik OK untuk melanjutkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Setelah klik OK, baru submit form
                    event.target.submit();  // Lanjutkan submit form setelah klik OK
                }
            });
        } else {
            console.log("Tidak ada jadwal yang dipilih.");
            alert("Tidak ada jadwal yang dipilih.");
        }
    } catch (submitError) {
        console.error("Gagal mengirim form:", submitError);
        alert("Terjadi kesalahan saat mengirim form. Silakan coba lagi.");
    }
});


</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
</script>
@endif


<!-- Toast untuk Terms & Conditions -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
  <div id="termsToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Anda harus menyetujui syarat dan ketentuan terlebih dahulu sebelum membuat Mabar.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>


<div class="modal fade" id="jadwalModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="jadwalListModal">
        Loading jadwal...
      </div>
    </div>
  </div>
</div>

<!-- Toast untuk checkbox not checked -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="termsToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Peringatan</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Anda harus menyetujui syarat & ketentuan terlebih dahulu!
    </div>
  </div>
</div>

@endsection
