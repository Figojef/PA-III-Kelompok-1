@extends('layouts.admin.app')

@section('title', 'Data Lapangan')

@section('content')
<!-- Begin Page Content -->
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
        <h1 class="h3 mb-0 text-gray-800">Data Lapangan</h1>
        <a href="{{ route('lapangan.create') }}" class="d-none d-sm-inline-block btn btn-sm shadow-sm" style="background-color: #002f53; color: white;">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Lapangan
        </a>
    </div>

    <!-- Tabel Lapangan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Lapangan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lapangans['data'] as $l)
                        <tr>
                            <td>{{ $l['name'] }}</td>
                            <td>{{ $l['deskripsi'] }}</td>
                            <td>
                                <img src="{{ $l['gambar'] }}" alt="Lapangan" width="150" height="150"
                                     class="img-thumbnail preview-image" style="cursor: pointer;"
                                     data-src="{{ $l['gambar'] }}">
                            </td>
                            <td>
                                <a href="{{ route('lapangan.edit', $l['_id']) }}" class="btn btn-sm btn-info">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>                            
                        </tr>           
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid rounded shadow" alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const previewImages = document.querySelectorAll(".preview-image");
        const modalImage = document.getElementById("modalImage");
        const imageModal = new bootstrap.Modal(document.getElementById("imageModal"));

        previewImages.forEach(img => {
            img.addEventListener("click", function () {
                const src = this.getAttribute("data-src");
                modalImage.setAttribute("src", src);
                imageModal.show();
            });
        });
    });
</script>
@endsection