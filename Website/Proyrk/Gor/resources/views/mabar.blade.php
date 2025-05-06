@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

.Tambah {
        padding: 10px 15px;
        background-color: black;
        color: #ffffff;
        border-radius: 4px;
        font-size: 18px;
        margin-left: auto;
        display: block;

    }

    </style>
<title>Jadwal Bermain</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container mt-4">
    <h3>Main Bareng</h3><br>
    <hr style="border: 2px solid #000000; margin: 20px 0;">
    
    <input type="button" class="Tambah" value="+ Tambah" onclick="window.location.href='{{ route('tambahMabar') }}'">
    <div>
asdasd
    </div>
</div> 

@endsection
