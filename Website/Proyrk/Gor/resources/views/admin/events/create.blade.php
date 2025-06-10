@extends('layouts.admin.app')

@section('title', 'Tambah Event')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Event</h1>

    {{-- ALERT SUCCESS / ERROR --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- <h1 class="h3 mb-4 text-gray-800">Tambah Lapangan</h1> --}}

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="judul">Judul Event</label>
            <input type="text" name="judul" class="form-control" id="judul" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" required>
        </div>

<div class="form-group">
    <label for="tanggal_selesai">Tanggal Selesai</label>
    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai" required>
    <small id="tanggal_selesai_hint" class="form-text text-muted">
        Silakan pilih tanggal mulai terlebih dahulu.
    </small>
</div>


        <div class="form-group">
            <label for="gambar">Gambar (Opsional)</label>
            <input type="file" name="gambar" class="form-control-file" id="gambar" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.events') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const localToday = ${year}-${month}-${day};

        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
        const hint = document.getElementById('tanggal_selesai_hint');

        // Atur tanggal minimum tanggal mulai (tidak bisa ke masa lalu)
        tanggalMulaiInput.setAttribute('min', localToday);

        // Awalnya, tanggal selesai dinonaktifkan
        tanggalSelesaiInput.disabled = true;
        hint.style.display = 'block';

        tanggalMulaiInput.addEventListener('change', function () {
            if (tanggalMulaiInput.value) {
                tanggalSelesaiInput.disabled = false;
                tanggalSelesaiInput.setAttribute('min', tanggalMulaiInput.value);

                // Sembunyikan keterangan
                hint.style.display = 'none';

                // Reset jika tanggal selesai di bawah tanggal mulai
                if (tanggalSelesaiInput.value < tanggalMulaiInput.value) {
                    tanggalSelesaiInput.value = '';
                }
            } else {
                tanggalSelesaiInput.disabled = true;
                tanggalSelesaiInput.value = '';
                hint.style.display = 'block';
            }
        });
    });
</script>


@endsection