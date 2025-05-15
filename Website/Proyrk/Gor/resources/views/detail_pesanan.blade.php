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
        #judul {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user {
            margin-bottom: 10px;
            font-weight: 700;
        }

        .user.data {
            margin-bottom: 15px;
            font-weight: 400;
        }

        .option-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .option-wrapper input[type="radio"] {
            margin-right: 15px;
            cursor: pointer;
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }

        .text-box {
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: white;
            transition: background-color 0.3s;
            margin-bottom: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 40px;
        }

        .text-box:hover {
            background-color: rgb(117, 135, 146);
            transition: background-color 0.3s;
        }

        .text-box.selected {
            background-color: #222F37;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 2px solid #000;
        }

        td {
            padding: 15px;
            border: 2px solid #000;
            border-radius: 8px;
            vertical-align: top;
        }

        .slot-item {
            position: relative;
            padding: 15px;
            margin-bottom: 15px;
            font-weight: 600;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .harga {
            position: absolute;
            top: 10px;
            right: 15px;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            background-color: #f1f1f1;
        }

        .slot-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .slot-detail {
            font-size: 14px;
            color: #555;
        }

        #totalBayarContainer {
            text-align: right;
            font-weight: bold;
            padding: 15px;
            border: 2px solid #000;
            border-top: none;
            border-radius: 0 0 8px 8px;
            background-color: #f9f9f9;
        }

        .konfirmasi {
            align-items: center;
            justify-content: center;
            display: flex;
            margin-top: 80px;
        }

        .tombol {
            color: black;
            font-weight: 700;
            background-color: #fff;
            width: 100%;
            /* Sesuai dengan lebar tabel */
            max-width: 100%;
            /* Tidak melebihi lebar tabel */
            height: 40px;
            border: 2px solid #000;
            border-radius: 8px;
            font-size: 16px;
            padding: 0 20px;
            transition: background-color 0.3s;
        }

        .tombol:hover {
            color: white;
            background-color: #1D4ED8;
            transition: background-color 0.3s;
        }

        /* Responsivitas untuk tablet dan mobile */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            #judul {
                font-size: 1.5rem;
            }

            .option-wrapper {
                justify-content: center;
            }

            .text-box {
                width: 180px;
                height: 38px;
                font-size: 14px;
            }

            .option-wrapper input[type="radio"] {
                width: 20px;
                height: 20px;
                margin-right: 10px;
            }

            td {
                padding: 12px;
            }

            .slot-item {
                padding: 12px;
            }

            .harga {
                font-size: 12px;
                padding: 6px 10px;
            }

            .slot-title {
                font-size: 14px;
            }

            .slot-detail {
                font-size: 12px;
            }

            .tombol {
                font-size: 14px;
                height: 38px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }

            #judul {
                font-size: 1.25rem;
            }

            .option-wrapper {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                margin-bottom: 15px;
            }

            .text-box {
                width: 160px;
                height: 36px;
                font-size: 13px;
                padding: 8px 15px;
            }

            .option-wrapper input[type="radio"] {
                width: 18px;
                height: 18px;
                margin-right: 10px;
            }

            td {
                padding: 10px;
            }

            .slot-item {
                padding: 10px;
            }

            .harga {
                font-size: 11px;
                padding: 5px 8px;
            }

            .slot-title {
                font-size: 13px;
            }

            .slot-detail {
                font-size: 11px;
            }

            .konfirmasi {
                display: flex;
                justify-content: center;
                margin-top: 32px;
                /* sebelumnya 20px */
                width: 100%;
            }

            .konfirmasi form {
                width: 100%;
            }

            .tombol {
                font-size: 13px;
                height: 36px;
                padding: 0 15px;
            }

        }
    </style>

    <div class="container mt-4">
        <div class="mt-4">
            <a href="{{ route('reservasi') }}" class="btn btn-secondary">
                ←
            </a>
        </div>
        <h2 id="judul">Detail Pemesanan</h2>
        <label style="font-size: 25px; text-decoration: underline; font-weight: bold; margin-bottom: 25px;">Informasi
            Pelanggan</label>

        <div>
            <label class="user">Nama Pelanggan</label><br>
            <label class="user data">
                @php
                    echo Session::get('user_data')['name'];
                @endphp
            </label><br>

            <label class="user">No.Telepon</label><br>
            <label class="user data">
                @php
                    // Ambil nomor WhatsApp
                    $nomorWhatsApp = Session::get('user_data')['nomor_telepon'] ?? '';
                    // Ganti kode negara 62 atau +62 dengan 0
                    $nomorWhatsApp = preg_replace('/^\+?62/', '0', $nomorWhatsApp);
                    // Pisahkan setiap 4 angka
                    $nomorWhatsApp = preg_replace('/(\d{4})(?=\d)/', '$1 ', $nomorWhatsApp);
                @endphp
                {{ $nomorWhatsApp }}
            </label>
        </div>

        <hr style="border: 2px solid #000000; margin: 20px 0;">

        <div>
            <h4 style="margin-bottom: 25px;">Pilih Jenis Pembayaran</h4>
            <label class="option-wrapper">
                <input type="radio" name="payment" value="transfer_bank">
                <div class="text-box">Transfer Bank</div>
            </label>

            <label class="option-wrapper">
                <input type="radio" name="payment" value="bayar_langsung">
                <div class="text-box">Bayar Ditempat</div>
            </label>
        </div>

        <hr style="border: 2px solid #000000; margin: 20px 0;">

        <div class="wrapper">
            <table class="table-pemesanan">
                <tr>
                    <td id="slotContainer">
                        <!-- Slot akan tampil di sini -->
                    </td>
                </tr>
                <!-- Baris untuk total harga -->
                <tr>
                    <td id="totalBayarContainer" colspan="2">
                        Total Bayar: <span id="totalHarga">Rp 0</span>
                    </td>
                </tr>
            </table>

            <div class="konfirmasi">
                <div style="width: 100%;">
                    <form id="formKonfirmasi" method="POST" action="{{ route('pemesanan.store') }}">
                        @csrf
                        <input type="hidden" name="jadwal_dipesan" id="jadwalDipesanInput">
                        <input type="hidden" name="total_harga" id="totalHargaInput">
                        <input type="hidden" name="metode_pembayaran" id="metodePembayaranInput">
                        <input type="hidden" name="status_pemesanan" value="Sedang Dipesan">
                        <input type="submit" class="tombol" value="Konfirmasi Pemesanan">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi buat kotak radio itu
        const wrappers = document.querySelectorAll('.option-wrapper');

        wrappers.forEach(wrapper => {
            wrapper.addEventListener('click', () => {
                // Unselect semua
                document.querySelectorAll('.text-box').forEach(tb => tb.classList.remove('selected'));
                // Tambahkan class ke text-box yang diklik
                wrapper.querySelector('.text-box').classList.add('selected');
                // Pastikan radio-nya juga ke-check
                wrapper.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Generate table
        const namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const bulanIndo = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        function formatTanggal(tanggalStr) {
            const date = new Date(tanggalStr);
            const hari = namaHari[date.getDay()];
            const tanggal = date.getDate();
            const bulan = bulanIndo[date.getMonth()];
            const tahun = date.getFullYear();
            return `${hari}, ${tanggal} ${bulan} ${tahun}`;
        }

        const container = document.getElementById("slotContainer");
        const stored = sessionStorage.getItem("selectedSlots");
        const slots = stored ? JSON.parse(stored) : [];

        if (slots.length === 0) {
            container.innerHTML = "<em>Belum ada slot yang dipilih.</em>";
            document.getElementById("totalHarga").textContent = "Rp 0"; // Menampilkan total harga 0
        } else {
            let totalHarga = 0; // Variabel untuk menghitung total harga

            // Menampilkan setiap slot
            slots.forEach(slot => {
                const lapanganName = slot.lapangan?.name || "Lapangan tidak diketahui";
                const harga = slot.harga || 0; // Set default harga ke 0 jika tidak ada
                const tanggalFormatted = formatTanggal(slot.tanggal || "-");
                const jam = slot.jam || "-";

                // Mengubah jam ke integer untuk manipulasi dan menambah 1 jam
                const jamInt = parseInt(jam, 10);
                const jamAkhir = (isNaN(jamInt) ? 0 : jamInt + 1).toString().padStart(2, '0') +
                    ":00"; // Menambahkan 1 jam, jika jam tidak valid, set ke 00:00

                // Menambahkan harga untuk total
                totalHarga += Number(harga);

                const div = document.createElement("div");
                div.className = "slot-item";
                div.innerHTML = `
            <div class="harga">Rp ${Number(harga).toLocaleString()}</div>
            <div class="slot-title">${lapanganName}</div>
            <div class="slot-detail">${tanggalFormatted}<br>
            ${jam}:00 - ${jamAkhir}</div>
        `;
                container.appendChild(div);
            });

            // Tampilkan total harga dalam format rupiah
            document.getElementById("totalHarga").textContent = `Rp ${totalHarga.toLocaleString()}`;
        }

        // Form konfirmasi
        document.getElementById('formKonfirmasi').addEventListener('submit', function(event) {
            // Hentikan form submit untuk memastikan kita bisa melakukan pemeriksaan
            event.preventDefault(); // Mencegah pengiriman form langsung

            // Ambil data slot dari sessionStorage
            const storedSlots = sessionStorage.getItem('selectedSlots');
            const slots = storedSlots ? JSON.parse(storedSlots) : [];

            // Cek apakah belum ada slot yang dipilih
            if (slots.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Belum memilih slot jadwal.',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return; // Jika Batal dipilih, tidak ada tindakan lanjut
                    }

                    // Lanjutkan jika OK dipilih (form masih belum dikirim)
                    submitForm(); // Kirim form setelah konfirmasi
                });
                return;
            }

            // Isi input jadwal dengan slot yang dipilih
            document.getElementById('jadwalDipesanInput').value = JSON.stringify(slots);

            // Hitung total harga
            let totalHarga = slots.reduce((total, slot) => total + Number(slot.harga || 0), 0);
            document.getElementById('totalHargaInput').value = totalHarga;

            // Ambil metode pembayaran yang dipilih
            const metode = document.querySelector('input[name="payment"]:checked');
            if (!metode) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Pilih metode pembayaran dulu.',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika OK dipilih, tetap tidak lanjutkan penghapusan sessionStorage
                        return; // Jangan lanjutkan jika metode pembayaran belum dipilih
                    }
                });
                return; // Mencegah form submit jika metode belum dipilih
            }

            // Isi input metode pembayaran
            document.getElementById('metodePembayaranInput').value = metode.value;

            // Jika metode pembayaran adalah 'Bayar Ditempat', tampilkan pesan konfirmasi
            if (metode.value === 'bayar_langsung') {
                Swal.fire({
                    icon: 'info',
                    title: 'Bayar Ditempat diberikan 1 jam dari pesanan dibuat',
                    text: 'Pelanggan harus membayar dengan tepat waktu apakah yakin melanjutkan',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return; // Jika Batal dipilih, tidak ada tindakan lanjut
                    }

                    // Lanjutkan jika OK dipilih
                    submitForm(); // Kirim form setelah konfirmasi
                });
            }

            // Jika metode pembayaran adalah 'Transfer Bank', tampilkan pesan konfirmasi
            if (metode.value === 'transfer_bank') {
                Swal.fire({
                    icon: 'info',
                    title: 'Pembayaran Transfer Bank hanya berlaku 10 menit setelah jadwal dibuat.',
                    text: 'Setelah itu Pesanan akan kadaluarsa, Yakin melanjutkan?',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return; // Jika Batal dipilih, tidak ada tindakan lanjut
                    }

                    // Lanjutkan jika OK dipilih
                    submitForm(); // Kirim form setelah konfirmasi
                });
            }

            // Fungsi untuk mengirimkan form setelah konfirmasi selesai
            function submitForm() {
                // Hapus selectedSlots setelah form akan dikirim
                sessionStorage.removeItem('selectedSlots');
                console.log('selectedSlots dihapus dari sessionStorage');

                // Generate ID transaksi unik (bisa menggunakan timestamp atau dari backend)
                const transactionId = `TRANS-${Date.now()}`; // Menggunakan timestamp sebagai ID transaksi

                // Simpan ID transaksi di sessionStorage
                sessionStorage.setItem('transactionId', transactionId);
                console.log('ID Transaksi disimpan:', transactionId);

                // Kirim form setelah semuanya siap
                document.getElementById('formKonfirmasi').submit(); // Kirim form
            }
        });
    </script>

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
@endsection
