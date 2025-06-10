@extends('layouts.app')

@section('content')
@php
function renderStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $stars .= '<i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>';
        } elseif ($rating >= $i - 0.5) {
            $stars .= '<i class="bi bi-star-half text-warning" style="font-size: 1.5rem;"></i>';
        } else {
            $stars .= '<i class="bi bi-star text-warning" style="font-size: 1.5rem;"></i>';
        }
    }
    return $stars;
}
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-8">
            <h2>
                <i class="bi bi-people" style="font-size: 2rem;"></i>
                Detail Profil Peserta
            </h2>
        </div>

        <!-- Rating rata-rata keseluruhan di kanan atas -->
        <div class="col-md-4 text-md-right">
            {!! renderStars($rataRataKeseluruhan ?? 0) !!}
        </div>
    </div>

    <hr>

    <div class="row align-items-center mt-5">
        <div class="col-md-3 text-center text-md-left">
            <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
        </div>
        <div class="col-md-9">
            <div class="d-flex flex-column" style="font-size: 1.2rem;">
                <!-- Nama Peserta -->
                <div class="d-flex mb-2">
                    <div class="col-4 text-md-right font-weight-bold pr-3">Nama:</div>
                    <div class="col-8">{{ $user['name'] }}</div>
                </div>

                <!-- No. Telepon -->
                <div class="d-flex mb-2">
                    <div class="col-4 text-md-right font-weight-bold pr-3">No. Telepon:</div>
                    <div class="col-8">{{ $user['nomor_telepon'] }}</div>
                </div>

                <!-- Email -->
                <div class="d-flex mb-2">
                    <div class="col-4 text-md-right font-weight-bold pr-3">Email:</div>
                    <div class="col-8">{{ $user['email'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penilaian -->
    <div style="margin-top: 40px;">
        <h3>Penilaian Mabar yang Pernah Diikuti</h3>
        <div class="row flex-column mt-4">
            @forelse ($ratings as $item)
            <div class="col-12 mb-4">
                <div class="border p-3 rounded">
                    <strong>{{ $item['nama_mabar'] }}</strong><br>
                    Kapasitas: {{ $item['jumlah_peserta'] }}/{{ $item['slot_peserta'] }} peserta<br>

                    <div>
                        Nilai Rata-rata:
                        @php
                            $nilai = round($item['rating_rata_rata']);
                            $maxBintang = 5;
                        @endphp
                        @for ($i = 1; $i <= $maxBintang; $i++)
                            @if ($i <= $nilai)
                                <span style="color: gold; font-size: 1.2rem;">&#9733;</span>
                            @else
                                <span style="color: #ccc; font-size: 1.2rem;">&#9734;</span>
                            @endif
                        @endfor
                    </div>

                    Kategori: {{ $item['kategori'] }}<br>
                    Range Umur: {{ $item['range_umur'] }} Tahun<br>
                    Waktu: {{ $item['tanggal_mulai'] }}
                </div>
            </div>
            @empty
                <p>Tidak ada data penilaian.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
