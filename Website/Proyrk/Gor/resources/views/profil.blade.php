@extends('layouts.app')

@section('content')

<title>Profil</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .profile-sidebar {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .profile-sidebar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .profile-sidebar h5 {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .profile-sidebar .menu-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
        color: black;
        cursor: pointer;
        text-decoration: none;
    }

    .profile-sidebar .menu-item a {
    color: black; 
    text-decoration: none; 
    }

    .profile-sidebar .menu-item:hover {
        background-color: #f1f1f1;
    }

    .profile-sidebar .menu-item i {
        margin-right: 10px;
    }

    .profile-content {
        background-color: #ffffff;
        padding: 20px;
    }

    .profile-info strong {
        display: block;
        margin-bottom: 5px;
    }

    /* Style untuk tab aktif */
    .tab-menu .nav-link.active {
        background-color: #f1f1f1;
        color: black;
    }

    .tab-content {
        margin-top: 20px;
    }

    /* Styling untuk tombol ubah profil */
    .btn-update-profile {
        background-color: black;
        color: white;
    }

    .btn-update-profile:hover {
        background-color: #444;
    }
</style>

<div class="container mt-4">
    <h4 class="mb-4">Profil</h4>
    <div class="row">
        <!-- Sidebar kiri (40%) -->
        <div class="col-md-4">
            <div class="profile-sidebar">
                <?php
                    $name = Session::get('user_data')['name'];
                    $name_parts = explode(' ', $name);
                    $first_name = $name_parts[0];
                    $last_name = end($name_parts);
                    $nama_pendek = $first_name . ' ' . $last_name;
                ?>
                <h5>{{ $nama_pendek }}</h5>
                <hr style="width:;">
                <!-- Tab Menu -->
                <div class="nav flex-column nav-pills tab-menu" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                        <i class="bi bi-person"></i> Profil
                    </a>
                    <a class="nav-link" id="v-pills-edit-profile-tab" data-bs-toggle="pill" href="#v-pills-edit-profile" role="tab" aria-controls="v-pills-edit-profile" aria-selected="false">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                    <a class="nav-link" id="v-pills-change-password-tab" data-bs-toggle="pill" href="#v-pills-change-password" role="tab" aria-controls="v-pills-change-password" aria-selected="false">
                        <i class="bi bi-lock"></i> Ubah Kata Sandi
                    </a>
                </div>
            </div>
        </div>

        <!-- Konten kanan (60%) -->
        <div class="col-md-8">
            <div class="profile-content">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Profil Tab -->
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <h5>Informasi Profil</h5>
                        <div class="row align-items-center">
                            <!-- Informasi Profil (kiri) -->
                            <div class="col-md-8">
                                <div class="profile-info mb-3">
                                    <strong>Nama Lengkap</strong>
                                    <p>{{ Session::get('user_data')['name'] ?? 'John Doe' }}</p>
                                </div>
                                <div class="profile-info mb-3">
                                    <strong>Nomor Telepon</strong>
                                    <p>
                                        @php
                                            $nomor_whatsapp = Session::get('user_data')['nomor_whatsapp'] ?? '6281234567890';
                                            if (substr($nomor_whatsapp, 0, 2) === '62') {
                                                $nomor_whatsapp = '0' . substr($nomor_whatsapp, 2);
                                            }
                                            echo $nomor_whatsapp;
                                        @endphp
                                    </p>
                                </div>
                                <div class="profile-info mb-3">
                                    <strong>Email</strong>
                                    <p>{{ Session::get('user_data')['email'] }}</p>
                                </div>
                            </div>
                            <!-- Foto Profil (kanan) -->
                            <div class="col-md-4 text-center">
                                <img src="https://via.placeholder.com/120" alt="Foto Profil" class="img-fluid">
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profil Tab -->
                    <div class="tab-pane fade" id="v-pills-edit-profile" role="tabpanel" aria-labelledby="v-pills-edit-profile-tab">
                        <h5>Edit Profil</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Session::get('user_data')['name'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="nomor_whatsapp" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_whatsapp" name="nomor_whatsapp" value="{{ Session::get('user_data')['nomor_whatsapp'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Session::get('user_data')['email'] ?? '' }}">
                            </div>
                            <button type="button" class="btn btn-update-profile">Ubah Profil</button>
                        </form>
                    </div>

                    <!-- Ubah Kata Sandi Tab -->
                    <div class="tab-pane fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">
                        <h5>Ubah Kata Sandi</h5>
                        <form>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Kata Sandi Lama</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                            <button type="button" class="btn btn-update-profile">Ubah Kata Sandi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
