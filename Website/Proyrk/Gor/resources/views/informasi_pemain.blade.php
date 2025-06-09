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
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>
            <i class="bi bi-people" style="font-size: 2rem;"></i>
            Detail Profil Peserta
        </h2>

        <!-- Rating rata-rata keseluruhan di kanan atas -->
        <div>
            {!! renderStars($rataRataKeseluruhan ?? 0) !!}
        </div>
    </div>

    <hr>


    <div style="display: flex; align-items: flex-start; margin-top: 5%;">
        <i class="bi bi-person-circle" style="font-size: 5rem; margin-right: 25px;"></i>
        <div style="font-size: 1.2rem;">

            <!-- Nama Peserta -->
            <div style="display: flex; margin-bottom: 12px;">
                <div style="width: 160px; text-align: right; font-weight: bold; padding-right: 10px;">
                    Nama :
                </div>
                <div style="margin-left: 10px;">{{ $user['name'] }}</div>
            </div>

            <!-- No. Telepon -->
            <div style="display: flex; margin-bottom: 12px;">
                <div style="width: 160px; text-align: right; font-weight: bold; padding-right: 10px;">
                    No. Telepon :
                </div>
                <div style="margin-left: 10px;">{{ $user['nomor_telepon'] }}</div>
            </div>

            <!-- Email -->
            <div style="display: flex; margin-bottom: 12px;">
                <div style="width: 160px; text-align: right; font-weight: bold; padding-right: 10px;">
                    Email :
                </div>
                <div style="margin-left: 10px;">{{ $user['email'] }}</div>
            </div>
        </div>
    </div>

    <!-- Penilaian -->
<!-- Penilaian -->
<div style="margin-top: 40px;">
    <h3>Penilaian Mabar yang Pernah Diikuti</h3>
    <div style="display: flex; flex-direction: column; margin-top: 40px;">
@forelse ($ratings as $item)
    <div 
        style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; border-radius: 8px;">
        
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
@empty
    <p>Tidak ada data penilaian.</p>
@endforelse

    </div>
</div>




    </div>
</div>

@endsection
