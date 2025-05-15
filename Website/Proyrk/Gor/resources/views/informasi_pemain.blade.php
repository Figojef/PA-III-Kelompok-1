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
                <div style="margin-left: 10px;">{{ $ratings['name'] ?? '-' }}
</div>
            </div>

            <!-- No. Telepon -->
            <div style="display: flex; margin-bottom: 12px;">
                <div style="width: 160px; text-align: right; font-weight: bold; padding-right: 10px;">
                    No. Telepon :
                </div>
                <div style="margin-left: 10px;">08123456789</div>
            </div>

            <!-- Email -->
            <div style="display: flex; margin-bottom: 12px;">
                <div style="width: 160px; text-align: right; font-weight: bold; padding-right: 10px;">
                    Email :
                </div>
                <div style="margin-left: 10px;">johndoe@example.com</div>
            </div>
        </div>
    </div>

    <!-- Penilaian -->
<div style="margin-top: 40px;">
    <h3>Penilaian Mabar yang Pernah Diikuti</h3>
    <div style="display: flex; flex-direction: column; margin-top: 40px;">
        @forelse ($ratings as $item)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; border-radius: 8px; ">
                <strong>{{ $item['mabar']['nama_mabar'] ?? '-' }}</strong><br>
                Kapasitas: {{ $item['mabar']['kapasitas'] ?? '-' }} peserta<br>
                Peserta:
                @if (count($item['peserta']) > 0)
                    <ul>
                        @foreach ($item['peserta'] as $peserta)

                        @endforeach
                    </ul>
                @else
                    <span>Tidak ada peserta join.</span>
                @endif
                <br>
                Rating:
                @if ($item['rating'])
                    <div>Nilai: {{ $item['rating']['nilai'] }}</div>
                @else
                    <div>Belum dinilai.</div>
                @endif
            </div>
        @empty
            <p>Tidak ada data penilaian.</p>
        @endforelse
    </div>
</div>


    </div>
</div>

@endsection
