@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Events</h2>
    <hr style="border: 3px solid #000; margin: auto; margin-bottom: 40px;">

    <div class="d-flex flex-column gap-5">
        @forelse ($events as $event)
            <div class="d-flex flex-wrap gap-4 align-items-start border-bottom pb-4">
                <img src="{{ $event['gambar'] ?? asset('images/default.jpg') }}" alt="gambar event" style="width: 300px; height: auto; border-radius: 10px; object-fit: cover;">
                
                <div style="flex: 1;">
                    <div class="text-muted mb-1">
                        {{ \Carbon\Carbon::parse($event['tanggal_mulai'])->translatedFormat('d F Y') }}
                        @if($event['tanggal_selesai'])
                            - {{ \Carbon\Carbon::parse($event['tanggal_selesai'])->translatedFormat('d F Y') }}
                        @endif
                    </div>
                    <h5 class="fw-bold">{{ $event['judul'] }}</h5>
                    <p class="text-justify" style="max-width: 100%;">{{ $event['deskripsi'] }}</p>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada event</p>
        @endforelse
    </div>
</div>
@endsection
