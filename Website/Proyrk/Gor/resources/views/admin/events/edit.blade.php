@extends('layouts.admin.app')

@section('title', 'Edit Event')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Event</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.events.update', $event['_id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="judul">Judul Event</label>
            <input type="text" name="judul" class="form-control" id="judul" value="{{ old('judul', $event['judul']) }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" required>{{ old('deskripsi', $event['deskripsi']) }}</textarea>
        </div>

        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="{{ old('tanggal_mulai', $event['tanggal_mulai']) }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai" value="{{ old('tanggal_selesai', $event['tanggal_selesai']) }}" required>
            <small id="tanggal_selesai_hint" class="form-text text-muted">
                Silakan pilih tanggal mulai terlebih dahulu.
            </small>
        </div>


        <div class="form-group">
            <label for="gambar">Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" class="form-control-file" id="gambar" accept="image/*">
            @if($event['gambar'])
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ $event['gambar'] }}" alt="Gambar Event" width="150">
                </div>
                <input type="hidden" name="old_gambar" value="{{ $event['gambar'] }}">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
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

        // Set tanggal minimal hari ini
        tanggalMulaiInput.setAttribute('min', localToday);

        // Jika belum ada tanggal mulai, nonaktifkan tanggal selesai
        if (!tanggalMulaiInput.value) {
            tanggalSelesaiInput.disabled = true;
            hint.style.display = 'block';
        } else {
            // Pastikan tanggal selesai tidak sebelum tanggal mulai
            tanggalSelesaiInput.disabled = false;
            tanggalSelesaiInput.setAttribute('min', tanggalMulaiInput.value);
            hint.style.display = 'none';

            // Jika tanggal selesai sebelumnya kurang dari tanggal mulai
            if (tanggalSelesaiInput.value < tanggalMulaiInput.value) {
                tanggalSelesaiInput.value = '';
            }
        }

        tanggalMulaiInput.addEventListener('change', function () {
            if (tanggalMulaiInput.value) {
                tanggalSelesaiInput.disabled = false;
                tanggalSelesaiInput.setAttribute('min', tanggalMulaiInput.value);
                hint.style.display = 'none';

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