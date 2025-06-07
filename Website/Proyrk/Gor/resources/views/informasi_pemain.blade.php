@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <h2>
        <i class="bi bi-people" style="font-size: 2rem;"></i>
        Detail Profil Peserta
    </h2>

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
            <a href="{{ route('informasi.rating.detail', ['mabarId' => $item['mabar']['id'] ?? 0]) }}" 
               style="text-decoration: none; color: inherit; display: block;"
            >
                <div 
                    style="position: relative; border: 1px solid #ccc; padding: 10px; /* margin dipindah ke bawah */ border-radius: 8px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#f5f5f5';"
                    onmouseout="this.style.backgroundColor='white';"
                >
                    <!-- Tanggal di pojok kanan atas -->
                    <div style="position: absolute; top: 10px; right: 10px; font-size: 0.9rem; color: #666;">
                        {{ $item['mabar']['tanggal'] ? \Carbon\Carbon::parse($item['mabar']['tanggal'])->format('d M Y') : '-' }}
                    </div>

                    <strong>{{ $item['mabar']['nama_mabar'] ?? '-' }}</strong><br>
                    Kapasitas: {{ $item['mabar']['kapasitas'] ?? '-' }} peserta<br>
                    <div>
                        Nilai: 
                        @php
                            $nilai = $item['ratings']['nilai'] ?? 0;
                            $maxBintang = 5;
                        @endphp
                        @for ($i = 1; $i <= $maxBintang; $i++)
                            @if ($i <= $nilai)
                                <span style="color: gold; font-size: 1.2rem;">&#9733;</span> {{-- ★ --}}
                            @else
                                <span style="color: #ccc; font-size: 1.2rem;">&#9734;</span> {{-- ☆ --}}
                            @endif
                        @endfor
                    </div>

                    Kategori: {{ $item['mabar']['kategori'] ?? '-' }}<br>
                    Range Umur: {{ $item['mabar']['range_umur'] ?? '-' }} Tahun<br>
                </div>
            </a>
            <!-- Margin bawah dipindah di luar agar tidak clickable -->
            <div style="height: 20px;"></div>
        @empty
            <p>Tidak ada data penilaian.</p>
        @endforelse
    </div>
</div>




    </div>
</div>

@endsection
