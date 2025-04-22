@extends('layouts.admin.app')

@section('title', 'Data Lapangan')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Lapangan</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Lapangan
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
                        <!-- Contoh Baris Data -->
                        @foreach ($lapangans['data'] as $l)
                        <tr>
                            <td>{{$l['name']}}</td>
                            <td>{{$l['deskripsi']}}</td>
                            <td>
                                <img src="https://res.cloudinary.com/de9cyaoqo/image/upload/v1741416154/uploads/xgiwpdnhdrt5i3ovydn1.jpg"
                                     alt="Lapangan 1" width="100">
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>           
                        @endforeach
                        {{-- <tr>
                            <td>Lapangan 1</td>
                            <td>Lapangan 1 dengan fitur xxxxxx, luas xxxx lebar xxxxx</td>
                            <td>
                                <img src="https://res.cloudinary.com/de9cyaoqo/image/upload/v1741416154/uploads/xgiwpdnhdrt5i3ovydn1.jpg"
                                     alt="Lapangan 1" width="100">
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr> --}}
                        {{-- <tr>
                            <td>Lapangan 2</td>
                            <td>Lapangan yang sangat bagus</td>
                            <td><span class="text-muted">Tidak ada gambar</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr> --}}
                        <!-- Tambahkan baris lain di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
