@extends('layouts.admin.app')

@section('title', 'Data Jadwal')

@section('content')
<!-- Modal untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid rounded shadow" alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>

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
        <h1 class="h3 mb-0 text-gray-800">Manajemen Event</h1>
        <a href="{{ route('admin.events.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Event
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Event</h6>
        </div>
        <div class="card-body">
            @if (count($events) > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $event['judul'] }}</td>
                        <td>
                            @if ($event['gambar'])
                                <img src="{{ $event['gambar'] }}" alt="Gambar Event" width="100" class="img-thumbnail preview-image" style="cursor: pointer;" data-src="{{ $event['gambar'] }}">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>

                            <td>{{ $event['deskripsi'] }}</td>
                            <td>{{ $event['tanggal_mulai'] }}</td>
                            <td>{{ $event['tanggal_selesai'] }}</td>
                            <td>
                                @php
                                    $status = $event['status'];
                                    $badge = 'secondary';
                                    if ($status === 'belum mulai') $badge = 'info';
                                    elseif ($status === 'berlangsung') $badge = 'success';
                                    elseif ($status === 'kadaluarsa') $badge = 'danger';
                                @endphp
                                <span class="badge badge-{{ $badge }}">{{$status === 'kadaluarsa' ? ucfirst('sudah berakhir') : ucfirst($status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.events.edit', $event['_id']) }}" class="btn btn-sm btn-warning">Update</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-center">Tidak ada data event yang tersedia.</p>
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