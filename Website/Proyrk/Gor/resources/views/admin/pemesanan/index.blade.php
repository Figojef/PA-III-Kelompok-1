@extends('layouts.admin.app')

@section('title', 'Data Pemesanan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pemesanan oleh Pelanggan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemesanan Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="pemesananTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Total Harga</th>
                            <th>Metode</th>
                            {{-- <th>Status Pemesanan</th>
                            <th>Status Pembayaran</th> --}}
                            <th>Deadline</th>
                            <th>Jadwal Dipesan</th>
                            <th>Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemesananData as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $item['user']['name'] }}<br>
                                    <small>{{ $item['user']['email'] }}</small>
                                </td>
                                <td>Rp {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                                <td class="text-capitalize">
                                    {{ str_replace('_', ' ', $item['metode_pembayaran']) }}
                                </td>
                                {{-- <td>
                                    <span class="badge badge-warning">{{ $item['status_pemesanan'] }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $item['status_pembayaran'] }}</span>
                                </td> --}}
                                <td>
                                    <span class="text-danger">{{ \Carbon\Carbon::parse($item['deadline_pembayaran'])->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }}</span>
                                </td>
                                <td>
                                    <!-- Tombol untuk memicu modal -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#jadwalModal{{ $index }}">
                                        Lihat Selengkapnya
                                    </button>
                                
                                    <!-- Modal Jadwal -->
                                    <div class="modal fade" id="jadwalModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="jadwalModalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="jadwalModalLabel{{ $index }}">Detail Jadwal Pemesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="list-group">
                                                        @foreach ($item['jadwal'] as $jadwal)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                <div>
                                                                    <strong>Tanggal:</strong> {{ $jadwal['tanggal'] }}<br>
                                                                    <strong>Jam:</strong> {{ $jadwal['jam'] }}:00<br>
                                                                    <strong>Lapangan:</strong> {{ $jadwal['lapangan'] }}
                                                                </div>
                                                                <span class="badge badge-primary badge-pill">Rp {{ number_format($jadwal['harga'], 0, ',', '.') }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                
                                
                                <td>
                                    @if ($item['metode_pembayaran'] === 'transfer_bank')
                                        {{-- <a href="{{ $item['bukti_pembayaran'] ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat Bukti</a> --}}
                                        @if ($item['bukti_pembayaran'] == '')
                                        <span style="color: red;">Belum di-upload</span>                                        
                                        @else
                                        <a href="{{ $item['bukti_pembayaran'] ?? '#' }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat Bukti</a>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.kelola.pemesanan.konfirmasi-pemesanan', ['id' => $item['_id']]) }}" class="btn btn-success btn-sm mb-1">
                                        <i class="fas fa-check"></i> Konfirmasi
                                    </a>
                                    <!-- Ganti tombol Tolak -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tolakModal{{ $index }}">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>

                                    <!-- Modal Penolakan -->
                                    <div class="modal fade" id="tolakModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form method="POST" action="{{ route('admin.kelola.pemesanan.tolak-pemesanan', ['id' => $item['_id']]) }}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Alasan Penolakan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="alasan_penolakan">Tuliskan alasan penolakan:</label>
                                                            <textarea name="alasan_penolakan" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Tolak Pemesanan</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Tolak</button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Tidak ada data pemesanan yang perlu dikonfirmasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert')['type'] }}',
                title: '{{ session('alert')['title'] }}',
                text: '{{ session('alert')['message'] }}',
            });
        </script>
    @endif
@endsection