@extends('layouts.admin.app')

@section('title', 'Edit Lapangan')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Lapangan</h1>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <form method="POST" action="{{ route('lapangan.update', $lapangan['_id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Lapangan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name', $lapangan['name']) }}" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $lapangan['deskripsi']) }}</textarea>
            @error('deskripsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            <img src="{{ $lapangan['gambar'] }}" alt="Gambar Lapangan" width="300" class="img-thumbnail">
            <input type="hidden" name="existing_gambar" value="{{ $lapangan['gambar'] }}">
        </div>

        <div class="form-group">
            <label for="gambar">Upload Gambar Baru (Opsional)</label>
            <input type="file" class="form-control-file @error('gambar') is-invalid @enderror"
                id="gambar" name="gambar" accept=".jpg,.png">
            @error('gambar')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.lapangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
