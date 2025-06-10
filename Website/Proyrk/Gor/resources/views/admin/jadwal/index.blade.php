@extends('layouts.admin.app')

@section('title', 'Data Jadwal')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Jadwal</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form method="GET" action="{{ route('admin.jadwal') }}">
                <div class="form-row">
                    <div class="col-md-4">
                        <label>Pilih Lapangan</label>
                        <select class="form-control" name="lapangan_id" required>
                            @foreach($lapanganList as $lapangan)
                                <option value="{{ $lapangan['_id'] }}" {{ $selectedLapangan == $lapangan['_id'] ? 'selected' : '' }}>
                                    {{ $lapangan['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Pilih Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $selectedTanggal }}" required>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary btn-block">Cari Jadwal</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            @if(empty($jadwalList))
                <div class="alert alert-info text-center">Tidak ada jadwal ditemukan untuk tanggal dan lapangan tersebut.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Jam</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalList as $jadwal)
                                    <!-- Modal Edit Harga -->
                                    <div class="modal fade" id="modalEditHarga{{ $jadwal['_id'] }}" tabindex="-1" role="dialog" aria-labelledby="editHargaLabel{{ $jadwal['_id'] }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form method="POST" action="{{ route('admin.jadwal.editHarga') }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="jadwal_id" value="{{ $jadwal['_id'] }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Harga Jadwal</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Jam:</strong> {{ str_pad($jadwal['jam'], 2, '0', STR_PAD_LEFT) }}:00</p>
                                                        <p><strong>Tanggal:</strong> {{ $jadwal['tanggal'] }}</p>
                                                        <p><strong>Lapangan:</strong> {{ $jadwal['lapangan'] }}</p>
                                                        <div class="form-group">
                                                            <label for="harga">Harga Baru</label>
                                                            <input type="number" name="harga" class="form-control" value="{{ $jadwal['harga'] }}" min="0" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                <tr>
                                    <td>{{ str_pad($jadwal['jam'], 2, '0', STR_PAD_LEFT) }}:00</td>
                                    <td>Rp{{ number_format($jadwal['harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $jadwal['status'] === 'Tersedia' ? 'success' : 'danger' }}">
                                            {{ $jadwal['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($jadwal['user'])
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalUser{{ $jadwal['_id'] }}">
                                                Lihat Detail
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="modalUser{{ $jadwal['_id'] }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $jadwal['_id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="userModalLabel{{ $jadwal['_id'] }}">Detail User</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Nama:</strong> {{ $jadwal['user']['name'] }}</p>
                                                            <p><strong>Email:</strong> {{ $jadwal['user']['email'] }}</p>
                                                            <p><strong>Nomor Telepon:</strong> {{ $jadwal['user']['nomor_telepon'] }}</p>
                                                            @if ($jadwal['user']['foto'])
                                                                <!-- Gambar thumbnail -->
                                                                <img src="{{ $jadwal['user']['foto'] }}" alt="Foto User" width="100" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#fotoModal" style="cursor: pointer;">

                                                                <!-- Modal Bootstrap -->
                                                                <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ $jadwal['user']['foto'] }}" alt="Foto User" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada foto</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum Ada User yang Memesan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($jadwal['status'] === 'Tersedia')
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditHarga{{ $jadwal['_id'] }}">
                                            Edit Harga
                                        </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
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