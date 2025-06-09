    @extends('layouts.app')

    @section('content')
    <div class="container py-5">
        <div class="row justify-content-between">
            {{-- Kiri: Info Pesanan --}}
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="mb-0 me-3">Pesanan</h2>
                    @php
                        $status = strtolower($data['status'] ?? 'tidak diketahui');
                        $badgeClass = match($status) {
                            'dibatalkan' => 'bg-danger',
                            'berhasil' => 'bg-success',
                            'menunggu' => 'bg-warning text-dark',
                            'ditolak' => 'bg-danger',
                            default => 'bg-secondary',
                        };
                    @endphp

                    <span class="badge {{ $badgeClass }} px-3 py-2">
                        {{ ucfirst($status) }}
                    </span>
                </div>

                <p class="text-muted mb-1">PAYMENT ID</p>
                <h6 class="mb-4">#{{ $data['transaksi']['_id'] ?? 'N/A' }}</h6>

                <div class="mb-4">
                    <h5 class="mb-1">
                        {{ $data['pemesanan']['jadwal_dipesan'][0]['lapangan']['name'] ?? 'Lapangan' }}
                    </h5>
                    <p class="mb-0">
                        <img src="https://img.icons8.com/?size=512&id=47188&format=png" width="24" class="me-2"/>
                        Metode Pembayaran:
                        <strong>{{ ucfirst(str_replace('_', ' ', $data['transaksi']['metode_pembayaran'])) }}</strong>
                    </p>
                </div>

                {{-- Detail Jadwal Booking --}}
                <h5 class="mt-4 mb-3">Detail Jadwal Booking</h5>

                @foreach($data['pemesanan']['jadwal_dipesan'] as $jadwal)
                    <div class="card mb-3 p-3 bg-warning bg-opacity-10 border border-warning">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>{{ $jadwal['lapangan']['name'] ?? 'Lapangan' }}</strong>
                            <strong>Rp {{ number_format($jadwal['harga'], 0, ',', '.') }}</strong>
                        </div>
                        <small>
                            {{ \Carbon\Carbon::parse($jadwal['tanggal'])->translatedFormat('l, j F Y') }} |
                            {{ $jadwal['jam'] }}:00 - {{ $jadwal['jam'] + 1 }}:00
                        </small>
                    </div>
                @endforeach

    {{-- Notifikasi upload bukti pembayaran --}}
    @if($data['transaksi']['metode_pembayaran'] !== 'bayar_langsung')
        @if(empty($data['transaksi']['bukti_pembayaran']))
            <p class="text-danger mt-4">Anda belum mengupload bukti pembayaran.</p>
        @else
            <p class="text-success mt-4">Menunggu konfirmasi admin, tunggu sebentar lagi.</p>
        @endif
    @endif


                
                {{-- Ambil badge class dari status --}}
                @php
                    $status = $data['status']; // ini dari API
                    $badgeClass = match($status) {
                        'berhasil' => 'bg-success text-white',
                        'ditolak' => 'bg-danger text-white',
                        'dibatalkan' => 'bg-danger text-white',
                        'terlambat' => 'bg-secondary text-white',
                        default => 'bg-dark text-white'
                    };
                @endphp

                    @if ($status === 'menunggu')
                        <div class="d-flex gap-3 mt-3">

                            {{-- Form Batalkan --}}
                                <form action="{{ route('pemesanan.batalkan', $data['pemesanan']['_id']) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-dark">Batalkan</button>
                                </form>


                            {{-- Tombol Bayar disembunyikan / belum digunakan --}}
                            {{-- 
                            @php
                                $sudahUpload = !empty($data['transaksi']['bukti_pembayaran']);
                            @endphp

                            @if (! $sudahUpload)
                                <a href="#" class="btn btn-dark disabled">Bayar</a>
                            @endif
                            --}}
                        </div>
                    @endif


            </div>

            {{-- Kanan: Countdown --}}
            <div class="col-md-4 d-flex align-items-start justify-content-end">
                <div class="text-end">
                    @if ($status === 'menunggu')
                        <div class="d-flex align-items-center justify-content-end mb-1">
                            <i class="bi bi-clock-history me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <small>Selesaikan pembayaran anda dalam</small><br>
                                @php
                                    $deadline = \Carbon\Carbon::parse($data['transaksi']['deadline_pembayaran']);
                                    $now = \Carbon\Carbon::now();
                                    $diff = $deadline->diff($now);
                                @endphp
                                <span class="text-danger fw-bold" style="font-size: 1.5rem;">
                                    {{ $diff->format('%H:%I:%S') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
