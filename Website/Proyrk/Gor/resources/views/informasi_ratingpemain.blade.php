@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <h3>
        <i class="bi bi-people" style="font-size: 1.6rem;"></i>
        Info Mabar dan Penilaian Teman
        <span class="float-end" style="font-size: 1.2rem; color: #f39c12;">
            <i class="bi bi-star-fill"></i>
            @php
                $totalRating = count($mabarDetail['ratings']);
                $avgRating = $totalRating ? number_format(collect($mabarDetail['ratings'])->avg('nilai'), 1) : '0.0';
            @endphp
            {{ $avgRating }} <small class="text-muted">({{ $totalRating }} Penilaian)</small>
        </span>
    </h3>
    <hr>

    <!-- Info Pemain -->
    <div class="row mt-4">
        <div class="col-md-1 text-center">
            <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
        </div>
        <div class="col-md-11" style="font-size: 1rem;">
            <div><strong>Nama</strong> : {{ $pemain['name'] }}</div>
            <div><strong>No. Telepon</strong> : {{ $pemain['phone'] }}</div>
        </div>
    </div>

    <!-- Info Mabar -->
    <div class="mt-4">
        <h5 class="fw-bold">Info Main Bareng</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Mabar</strong> : {{ $mabarDetail['mabar']['nama_mabar'] ?? '-' }}</p>
                <p><strong>Hari/Tanggal</strong> :
                    @if (!empty($mabarDetail['jadwal'][0]['tanggal']))
                        {{ \Carbon\Carbon::parse($mabarDetail['jadwal'][0]['tanggal'])->translatedFormat('l, d F Y') }}
                    @endif
                </p>
                <p><strong>Lapangan & Waktu</strong> :
                    {{ $mabarDetail['jadwal'][0]['lapangan'] ?? '-' }}<br>
                    Pukul {{ $mabarDetail['jadwal'][0]['jam'] ?? '-' }}
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Range Umur</strong> : {{ $mabarDetail['mabar']['range_umur'] ?? '-' }}</p>
                <p><strong>Kategori</strong> : {{ $mabarDetail['mabar']['kategori'] ?? '-' }}</p>
                <p><strong>Level</strong> : {{ $mabarDetail['mabar']['level'] ?? '-' }}</p>
                <p><strong>Jumlah Peserta</strong> : {{ $mabarDetail['mabar']['total_peserta'] ?? 0 }}/6</p>
            </div>
        </div>
    </div>

    <!-- Penilaian Teman -->
    <div class="mt-5">
        <h5 class="fw-bold">Penilaian Teman Bermain</h5>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
            @forelse ($mabarDetail['ratings'] as $rating)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-person-circle fs-4 me-2"></i>
                                <strong>{{ $rating['dari_user'] }}</strong>
                            </div>
                            <div class="text-warning mb-2">
                                @for ($i = 0; $i < $rating['nilai']; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                            <p class="card-text">{{ $rating['komentar'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada penilaian dari teman.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
