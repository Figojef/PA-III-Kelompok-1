@extends('layouts.app')

@section('content')

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
            <form id="mabarForm">
                <div class="mb-3">
                    <label for="mabarName" class="form-label">
                        Nama Mabar
                        <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Judul atau nama dari acara Mabar."></i>
                    </label>
                    <input type="text" class="form-control" id="mabarName" name="mabarName" placeholder="Contoh: Seru - Seruan">
                </div>
                <input type="hidden" id="userId" value="{{ Session::get('user_data')['_id'] }}">
                <div class="mb-3">
  <label for="lapangan" class="form-label">
    Lapangan dan Waktu
    <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Pilih jadwal & lapangan yang sudah dipesan. Untuk 2 jadwal, harus waktu berturut-turut."></i>
  </label>

  <!-- Button untuk buka modal -->
  <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#jadwalModal">
    Pilih Lapangan & Jadwal
  </button>

  <!-- Hidden input untuk menyimpan nilai yang dipilih -->
  <input type="hidden" id="lapangan" name="lapangan">
  <div id="selectedJadwalDisplay" class="mt-2 text-muted fst-italic"></div>
</div>

                <div class="mb-3">
                    <label for="biaya" class="form-label">
                        Biaya
                        <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Masukkan biaya untuk ikut mabar, misal 5000"></i>
                    </label>
                    <input type="number" class="form-control" id="biaya" name="biaya" placeholder="Contoh: 10000">
                </div>
                <label for="umur_min" class="form-label">
                    Range Umur
                    <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Isi rentang umur peserta, contoh: 17 - 25."></i>
                </label>
                <div class="d-flex gap-2 mb-3">
                    <input type="number" class="form-control" id="umur_min" name="umur_min" placeholder="Min">
                    <input type="number" class="form-control" id="umur_max" name="umur_max" placeholder="Max">
                </div>

                <div class="mb-3">
    <label for="level" class="form-label">
        Level
        <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Sesuaikan dengan level yang diinginkan"></i>
    </label>
    <select class="form-select" id="kategori" name="kategori">
        <option value="" disabled selected>Pilih kategori</option>
        <option value="fun">Amateur</option>
        <option value="competitive">Intermediate</option>
        <option value="competitive">Professional</option>
    </select>
</div>
                <div class="mb-3">
    <label for="kategori" class="form-label">
        Kategori
        <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Sesuaikan dengan tipe permainan yang diinginkan"></i>
    </label>
    <select class="form-select" id="kategori" name="kategori">
        <option value="" disabled selected>Pilih kategori</option>
        <option value="fun">Fun</option>
        <option value="competitive">Competitive</option>
    </select>
</div>
                <div class="mb-3">
                    <label for="slot" class="form-label">
                        Slot Peserta
                        <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Jumlah maksimal peserta, misalnya 10."></i>
                    </label>
                    <input type="number" class="form-control" id="slot" name="slot" placeholder="Contoh: 10">
                </div>
                <div class="mb-3">
  <label for="deskripsi" class="form-label">
    Deskripsi
    <i class="bi bi-question-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Penjelasan singkat tentang mabar."></i>
  </label>
  <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Contoh: Ayo main Tunjukan Kemampuanmu"></textarea>
</div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="termsCheckbox" required>
                    <label class="form-check-label" for="termsCheckbox">
                        Dengan ini saya menyetujui, menyatakan dan menyadari sepenuhnya untuk hanya membuat event olahraga tanpa mengandung unsur SARA, asusila dan sebagainya yang melanggar hukum dan norma-norma etika yang berjalan. Segala risiko dan konsekuensi yang timbul merupakan tanggung jawab saya.
                    </label>
                </div>

                <button type="submit" class="btn btn-dark">Buat Mabar</button>
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
                <div class="mb-2">
                   <strong>Lapangan</strong>
                    <div id="previewLapangan">-</div>
                </div>
  
                        <div class="mb-2">
                            <strong>Biaya</strong>
                            <div id="previewBiaya">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    function formatRupiah(value) {
        const angka = parseInt(value.replace(/\D/g, ''));
        return isNaN(angka) ? '-' : 'Rp. ' + angka.toLocaleString('id-ID');
    }

    function updatePreview() {
        document.getElementById('previewMabarName').innerText = document.getElementById('mabarName')?.value || '-';
        document.getElementById('previewLapangan').innerText = document.getElementById('lapangan')?.value || '-';

        const biayaVal = document.getElementById('biaya')?.value || '';
        document.getElementById('previewBiaya').innerText = formatRupiah(biayaVal);

        const umurMin = document.getElementById('umur_min')?.value;
        const umurMax = document.getElementById('umur_max')?.value;
        document.getElementById('previewUmur').innerText = (umurMin && umurMax) ? `${umurMin} - ${umurMax} tahun` : '-';

        document.getElementById('previewKategori').innerText = document.getElementById('kategori')?.value || '-';
        document.getElementById('previewSlot').innerText = document.getElementById('slot')?.value || '-';
        document.getElementById('previewDeskripsi').innerText = document.getElementById('deskripsi')?.value || '-';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.querySelectorAll('#mabarForm input, #mabarForm textarea, #mabarForm select').forEach(el => {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        });

        updatePreview(); // inisialisasi awal
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

  // Menampilkan pilihan jadwal
  document.addEventListener("DOMContentLoaded", function () {
  const tombolPilih = document.querySelector('[data-bs-target="#jadwalModal"]');
  const userId = document.getElementById('userId').value;

  tombolPilih.addEventListener("click", async function () {
  try {
    const response = await fetch("http://localhost:3000/api/v1/mabar/select_jadwal", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ user_id: userId }),
    });

    const result = await response.json();
    const display = document.getElementById("jadwalListModal"); 


    if (result && result.data && result.data.length > 0) {
      display.innerHTML = result.data.map((jadwal, index) => {
        const lapangan = jadwal.lapangan?.name ?? 'Tidak Diketahui';
        const jam = jadwal.jam;
        const tanggal = new Date(jadwal.tanggal).toLocaleDateString('id-ID');
        const jadwalInfo = `${lapangan} - ${tanggal} Jam ${jam}`;
        return `
          <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
            <div>${jadwalInfo}</div>
            <button type="button" class="btn btn-sm btn-primary pilih-jadwal" 
              data-jadwal='${JSON.stringify(jadwalInfo)}' data-id='${jadwal._id}'>
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
      document.querySelectorAll(".pilih-jadwal").forEach(button => {
        button.addEventListener("click", function () {
          const selectedInfo = this.getAttribute("data-jadwal");
          const selectedId = this.getAttribute("data-id");

          document.getElementById("lapangan").value = selectedId;
          document.getElementById("selectedJadwalDisplay").innerHTML =
  `<div class="alert alert-success">Dipilih: ${selectedInfo}</div>`;


          // Tutup modal (opsional)
          const modal = bootstrap.Modal.getInstance(document.getElementById('jadwalModal'));
          if (modal) modal.hide();
        });
      });
    }, 100); // Tunggu DOM rendering tombol selesai

  } catch (error) {
    console.error("Gagal ambil jadwal:", error);
    document.getElementById("selectedJadwalDisplay").innerHTML = "Terjadi kesalahan saat mengambil data.";
  }
});

});

</script>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="termsToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Anda harus menyetujui persyaratan terlebih dahulu.
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

@endsection
