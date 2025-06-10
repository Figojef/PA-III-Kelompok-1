@extends('layouts.admin.app')

@section('title', 'Info Kontak GOR')

@section('content')
<!-- Modal untuk Update Info Kontak -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">
                    {{ $infoKontak ? 'Update Info Kontak' : 'Tambah Info Kontak' }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.info-kontak.update') }}" method="POST">
                @csrf
                {{-- @method('POST') --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor_whatsapp">Nomor WhatsApp</label>
                        <input type="text" class="form-control" id="nomor_whatsapp" name="nomor_whatsapp" 
                               value="{{ $infoKontak['nomor_whatsapp'] ?? '' }}" required 
                               placeholder="Contoh: 628123456789">
                    </div>
                    <div class="form-group">
                        <label for="nama_bank">Nama Bank</label>
                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" 
                               value="{{ $infoKontak['nama_bank'] ?? '' }}" required 
                               placeholder="Contoh: Bank BRI">
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekening">Nomor Rekening</label>
                        <input type="number" class="form-control" id="nomor_rekening" name="nomor_rekening" 
                               value="{{ $infoKontak['nomor_rekening'] ?? '' }}" required 
                               placeholder="Contoh: 1234567890">
                    </div>
                    <div class="form-group">
                        <label for="atas_nama">Atas Nama</label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" 
                               value="{{ $infoKontak['atas_nama'] ?? '' }}" required 
                               placeholder="Contoh: John Doe">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $infoKontak ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
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
        <h1 class="h3 mb-0 text-gray-800">Manajemen Info Kontak</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
            <i class="fas {{ $infoKontak ? 'fa-edit' : 'fa-plus' }} fa-sm text-white-50"></i> 
            {{ $infoKontak ? 'Update Info Kontak' : 'Tambah Info Kontak' }}
        </button>
    </div>

    @if($infoKontak)
        <div class="row">
            <!-- Main Info Card -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kontak GOR</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- WhatsApp Card -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-left-success h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    WhatsApp
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $infoKontak['nomor_whatsapp'] }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fab fa-whatsapp fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Info Card -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-left-primary h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ $infoKontak['nama_bank'] }}
                                                </div>
                                                <div class="h6 mb-1 font-weight-bold text-gray-800">
                                                    {{ number_format($infoKontak['nomor_rekening'], 0, ',', '.') }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    A/N: {{ $infoKontak['atas_nama'] }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-university fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <!-- WhatsApp Action -->
                        {{-- <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="mr-3">
                                <a href="https://wa.me/{{ $infoKontak['nomor_whatsapp'] }}" target="_blank" 
                                   class="btn btn-success btn-circle">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                            <div>
                                <div class="font-weight-bold text-gray-800">Chat WhatsApp</div>
                                <div class="small text-gray-600">Hubungi langsung</div>
                            </div>
                        </div> --}}

                        <!-- Copy Rekening Action -->
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="mr-3">
                                <button class="btn btn-info btn-circle" 
                                        onclick="copyToClipboard('{{ number_format($infoKontak['nomor_rekening'], 0, '', '') }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <div>
                                <div class="font-weight-bold text-gray-800">Copy Rekening</div>
                                <div class="small text-gray-600">Salin nomor rekening</div>
                            </div>
                        </div>

                        <!-- Edit Action -->
                        {{-- <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="mr-3">
                                <button class="btn btn-primary btn-circle" data-toggle="modal" data-target="#updateModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                            <div>
                                <div class="font-weight-bold text-gray-800">Edit Info</div>
                                <div class="small text-gray-600">Update informasi kontak</div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Data State -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <div class="text-gray-300 mb-4">
                            <i class="fas fa-address-book fa-4x"></i>
                        </div>
                        <h4 class="text-gray-600 mb-2">Belum Ada Info Kontak</h4>
                        <p class="text-gray-500 mb-4">
                            Silakan tambahkan informasi kontak GOR untuk memudahkan komunikasi dengan pelanggan.
                        </p>
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#updateModal">
                            <i class="fas fa-plus mr-2"></i> Tambah Info Kontak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Nomor rekening berhasil disalin ke clipboard',
            timer: 2000,
            showConfirmButton: false
        });
    }).catch(function(err) {
        console.error('Error copying text: ', err);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal menyalin nomor rekening',
        });
    });
}
</script>
@endsection