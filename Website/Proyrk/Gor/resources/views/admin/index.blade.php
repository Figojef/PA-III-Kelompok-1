@extends('layouts.admin.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Lapangan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lapangan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLapangan }}</div>
                </div>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pelanggan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPelanggan }}</div>
                </div>
            </div>
        </div>

        <!-- Total Pemesanan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pemesanan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPemesanan }}</div>
                </div>
            </div>
        </div>

        <!-- Total Pemesanan Berhasil -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pemesanan yang Berhasil</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPemesananBerhasil }}</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Keuntungan per Bulan</h6>
                </div>
                <div class="card-body">
                    <!-- Set tinggi grafik lebih kecil -->
                    <div style="height: 300px;">
                        <canvas id="pendapatanChart" style="height: 100% !important;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Chart Script
    const ctx = document.getElementById('pendapatanChart').getContext('2d');

    const labels = {!! json_encode(array_keys($pendapatanPerBulan)) !!};
    const data = {!! json_encode(array_values($pendapatanPerBulan)) !!};

    const pendapatanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Keuntungan (Rp)',
                data: data,
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Kunci utama untuk memungkinkan kontrol tinggi manual
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // SweetAlert for Login Success
    @if(Session::has('login_success'))
        @php
            $loginData = Session::get('login_success');
        @endphp
        
        document.addEventListener('DOMContentLoaded', function() {
            @if($loginData['type'] == 'admin')
                Swal.fire({
                    title: 'Selamat Datang Admin!',
                    text: 'Halo {{ $loginData["name"] }}, login berhasil sebagai Administrator',
                    icon: 'success',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#222F37',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    allowOutsideClick: false
                });
            @else
                Swal.fire({
                    title: 'Login Berhasil!',
                    text: 'Selamat datang {{ $loginData["name"] }}!',
                    icon: 'success',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#222F37',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    allowOutsideClick: false
                });
            @endif
        });
        
        @php
            Session::forget('login_success');
        @endphp
    @endif
</script>
@endsection