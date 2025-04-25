@extends('layouts.admin.app')

@section('title', 'Tambah Lapangan')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Lapangan</h1>

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

    <form method="POST" action="{{ route('lapangan.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lapangan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="gambar">Upload Gambar (jpg/png)</label>
            <input type="file" class="form-control-file @error('gambar') is-invalid @enderror"
                id="gambar" name="gambar" accept=".jpg,.png">
            @error('gambar')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.lapangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
