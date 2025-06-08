@extends('layouts.app')
@section('content')
    <!doctype html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Status Pembayaran</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons (optional) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            .harga {
                font-size: 2rem;
                font-weight: 600;
            }

            .info-line {
                font-size: 0.95rem;
            }

            .tombol {
                color: white;
                font-weight: 700;
                background-color: black;
                width: 100%;
                height: 40px;
                border-radius: 10px;
                font-size: 16px;
            }

            /* Optional: override tombol class if you have custom styles elsewhere */
            .tombol {
                /* Example custom padding */
                padding: 8px 24px;
            }
        </style>
    </head>

    <body>
        <div class="container py-5">
            <!-- Icon & Status -->
            <div class="text-center">
                <i class="bi bi-clock-history display-4"></i>
                <h5 class="mt-3" style="font-size: 25px;">Menunggu Konfirmasi Pembayaran</h5>
                <div class="harga mt-2">Rp&nbsp;135.000</div>
            </div>

            <!-- Garis pemisah -->
            <hr style="border: 2px solid #000000; margin: 20px 0;">


            <!-- Informasi rincian -->
            <div class="mt-3">
                <div class="d-flex justify-content-between info-line">
                    <span class="label" style="font-size: 25px;">Nomor Rekening</span>
                    <span style="font-size: 25px;">1542 8765 7489234</span>
                </div>
                <div class="d-flex justify-content-between info-line">
                    <span class="label" style="font-size: 25px;">Waktu Pembayaran</span>
                    <span style="font-size: 25px;">22-02-2025, 14:21:31</span>
                </div>
                <div class="d-flex justify-content-between info-line">
                    <span class="label" style="font-size: 25px;">Metode Pembayaran</span>
                    <span style="font-size: 25px;">Transfer Bank</span>
                </div>
                <div class="d-flex justify-content-between info-line">
                    <span class="label" style="font-size: 25px;">Nama Pengirim</span>
                    <span style="font-size: 25px;">Benhard Sijabat</span>
                </div>
                <div class="d-flex justify-content-between info-line">
                    <span class="label" style="font-size: 25px;">Jenis Lapangan</span>
                    <span style="font-size: 25px;">Lapangan 1 & Lapangan 2</span>
                </div>
            </div>

            <!-- Garis sebelum nominal -->
            <hr style="border: 2px solid #000000; margin: 20px 0;">


            <div class="d-flex justify-content-between info-line">
                <span class="label" style="font-size: 25px;">Nominal</span>
                <span style="font-size: 25px;">Rp&nbsp;135.000</span>
            </div>

            <!-- Garis setelah nominal -->
            <hr style="border: 2px solid #000000; margin: 20px 0;">


            <div class="text-center">
                <button type="button" onclick="window.location='{{ route('profil') }}'" class="tombol"
                    style="margin-top: 40px">Cek Status
                    Pesanan</button>
            </div>
        </div>


        <!-- Bootstrap JS (optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function uploadImage() {
                // TODO: implement uploadImage
                alert('uploadImage() clicked');
            }
        </script>
    </body>

    </html>
@endsection
