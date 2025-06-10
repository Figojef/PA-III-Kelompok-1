@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Catatan Transaksi Pelanggan</h1>
        <a href="{{ route('admin.daftar-pelanggan') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelanggan
        </a>
    </div>

    @if(count($catatan) > 0)
        @foreach($catatan as $trx)
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Transaksi #{{ $trx['transaksi_id'] }}
                </h6>
                {{-- <span class="badge badge-success text-uppercase">{{ $trx['status_pemesanan'] }}</span> --}}
                {{-- <span class="badge badge-success text-uppercase">Telah Dibayar</span> --}}

            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tanggal Transaksi:</strong><br>
                        {{ \Carbon\Carbon::parse($trx['tanggal_transaksi'])->format('d M Y') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Metode Pembayaran:</strong><br>
                        {{ ucwords(str_replace('_', ' ', $trx['metode_pembayaran'])) }}
                    </div>
                    <div class="col-md-4">
                        <strong>Status Pembayaran:</strong><br>
                        {{-- <span class="badge badge-success">{{ ucfirst($trx['status_pembayaran']) }} Dibayar</span> --}}
                        <span class="badge badge-success">Lunas</span>

                    </div>
                </div>

                @if($trx['bukti_pembayaran'])
                <div class="mb-3">
                    <strong>Bukti Pembayaran:</strong><br>
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#buktiModal{{ $trx['transaksi_id'] }}">
                        <i class="fas fa-image"></i> Lihat Bukti Pembayaran
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="buktiModal{{ $trx['transaksi_id'] }}" tabindex="-1" role="dialog" aria-labelledby="buktiModalLabel{{ $trx['transaksi_id'] }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="buktiModalLabel{{ $trx['transaksi_id'] }}">Bukti Pembayaran - Transaksi #{{ $trx['transaksi_id'] }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <img src="{{ $trx['bukti_pembayaran'] }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal Jadwal</th>
                                <th>Jam</th>
                                <th>Lapangan</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trx['jadwal'] as $index => $jadwal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jadwal['tanggal'] }}</td>
                                <td>{{ $jadwal['jam_formatted'] }}</td>
                                <td>{{ $jadwal['lapangan'] }}</td>
                                <td>Rp {{ number_format($jadwal['harga'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right">
                    <strong>Total Harga:</strong> 
                    <span class="text-success font-weight-bold">
                        Rp {{ number_format($trx['total_harga'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">
            Belum ada transaksi untuk pelanggan ini.
        </div>
    @endif
</div>
@endsection