@extends('layouts.admin.app')

@section('title', 'Data Jadwal Rutin Harian')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.jadwal-rutin-harian.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJadwalLabel">Tambah Jadwal Rutin Harian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jam">Jam</label>
                        <select class="form-control" id="jam" name="jam" required>
                            @for($i = 1; $i <= 24; $i++)
                                <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required min="0" placeholder="Contoh: 10000">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>


    {{-- ALERT SUCCESS / ERROR --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Jadwal Rutin Harian</h1>
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambahJadwal">
    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal Rutin Harians
</button>

    </div>

    <!-- Tabel Jadwal Rutin Harian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card mb-4">
    <div class="card-header">
        <strong>Terapkan Jadwal Rutin Harian</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jadwal-rutin-harian.terapkan') }}" id="formTerapkan">
            @csrf
            <div class="form-row align-items-end">
                <div class="col-md-5">
                    <label for="lapangan_id">Pilih Lapangan</label>
                    <select class="form-control" name="lapangan_id" id="lapangan_id" required>
                        <option value="" disabled selected>-- Pilih Lapangan --</option>
                        @foreach ($lapangan as $lp)
                            <option value="{{ $lp['_id'] }}">{{ $lp['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tanggal">Pilih Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success btn-block">Terapkan Jadwal</button>
                </div>
            </div>
        </form>
    </div>
</div>

            <h6 class="m-0 font-weight-bold text-primary">Tabel Jadwal</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Jam</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalRutinHarian as $item)
<!-- Modal Edit Jadwal -->
<div class="modal fade" id="modalEditJadwal{{ $item['_id'] }}" tabindex="-1" aria-labelledby="modalEditJadwalLabel{{ $item['_id'] }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.jadwal-rutin-harian.update', $item['_id']) }}">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditJadwalLabel{{ $item['_id'] }}">Edit Jadwal ({{ str_pad($item['jam'], 2, '0', STR_PAD_LEFT) }}:00)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jam">Jam</label>
                        <select class="form-control" name="jam" required>
                            @for($i = 1; $i <= 24; $i++)
                                <option value="{{ $i }}" {{ $item['jam'] == $i ? 'selected' : '' }}>
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" class="form-control" required min="0" value="{{ $item['harga'] }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

                        @forelse($jadwalRutinHarian as $index => $item)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['jam'] }}:00</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditJadwal{{ $item['_id'] }}">
                                    <i class="fas fa-edit"></i>
                                </button>

<button class="btn btn-sm btn-danger btn-delete-jadwal" data-id="{{ $item['_id'] }}">
    <i class="fas fa-trash"></i>
</button>


                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">Tidak ada data tersedia.</td>
                        </tr>
                    @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-jadwal');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');

                // Konfirmasi menggunakan native confirm dialog
                const isConfirmed = window.confirm('Yakin ingin menghapus jadwal ini?');

                if (isConfirmed) {
                    // Buat form delete dan submit secara dinamis
                    const form = document.createElement('form');
                    form.action = `/admin/jadwal-rutin-harian/${id}`;
                    form.method = 'POST';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
