@extends('layouts.admin.app')

@section('title', 'Data Jadwal')

@section('content')


<div class="container-fluid">
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
        <h1 class="h3 mb-0 text-gray-800">Manajemen Tentang</h1>
        <!-- Tombol Tambah Tentang -->
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambahTentang">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tentang
        </button>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Tentang</h6>
        </div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    {{-- <th>Dibuat</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['judul'] }}</td>
                    <td>{{ $item['deskripsi'] }}</td>
                    {{-- <td>{{ \Carbon\Carbon::parse($item['createdAt'])->format('d M Y H:i') }}</td> --}}
                    <td>
                        {{-- <a href="{{ route('admin.tentang.edit', $item['_id']) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a> --}}
<!-- Tombol Edit -->
<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditTentang{{ $item['_id'] }}">
    <i class="fas fa-edit"></i> Edit
</button>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditTentang{{ $item['_id'] }}" tabindex="-1" role="dialog" aria-labelledby="modalEditTentangLabel{{ $item['_id'] }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.tentang.update', $item['_id']) }}">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTentangLabel{{ $item['_id'] }}">Edit Tentang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Jika error dan edit_id cocok, tampilkan validasi --}}
                    @if ($errors->any() && session('edit_id') === $item['_id'])
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" class="form-control"
                            value="{{ old('judul', $item['judul']) }}"
                            required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                            required maxlength="500">{{ old('deskripsi', $item['deskripsi']) }}</textarea>
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

                        {{-- <form action="{{ route('admin.tentang.destroy', $item['_id']) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form> --}}
                    <!-- Tombol Delete -->
                    <form id="formDelete{{ $item['_id'] }}" action="{{ route('admin.tentang.destroy', $item['_id']) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $item['_id'] }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>

<!-- Modal Tambah Tentang -->
<div class="modal fade" id="modalTambahTentang" tabindex="-1" role="dialog" aria-labelledby="modalTambahTentangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('admin.tentang.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahTentangLabel">Tambah Tentang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" required maxlength="100" value="{{ old('judul') }}">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required maxlength="500">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
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

    @if(session('edit_id'))
<script>
    $(document).ready(function() {
        $('#modalEditTentang{{ session('edit_id') }}').modal('show');
    });
</script>
@endif


<script>
    $(document).ready(function () {
        $('.btn-delete').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formDelete' + id).submit();
                }
            });
        });
    });
</script>


@endsection