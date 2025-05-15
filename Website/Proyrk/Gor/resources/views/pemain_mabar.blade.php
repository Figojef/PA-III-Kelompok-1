@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
h2 {
    font-weight: bold;
}

/* Container utama dengan padding */
.container {
    padding: 20px;
}

/* Layout menggunakan Flexbox untuk pembuat dan peserta */
.row {
    display: flex;
    flex-wrap: wrap; /* Agar elemen tidak meluap dan bisa dipindah ke baris baru jika perlu */
    gap: 20px; /* Jarak antar elemen */
}

/* Setiap card (elemen) akan memiliki ukuran yang fleksibel */
.card {
    border: 1px solid #ddd; /* Border tipis */
    padding: 10px; /* Padding di dalam */
    border-radius: 8px; /* Radius sudut */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Efek bayangan ringan */
    width: 30%; /* Setiap card mengambil 30% dari lebar container */
    box-sizing: border-box; /* Untuk menghindari padding mengubah lebar */
    min-width: 250px; /* Minimum lebar agar tidak terlalu sempit */
}

.isi {
    margin: 10px;
}

.card h4 {
    margin-bottom: 10px;
}

/* Styling untuk list peserta */
.card ul {
    padding-left: 20px;
}

.card li {
    margin-bottom: 10px; /* Jarak antar list item */
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .card {
        width: 100%; /* Pada layar kecil, card akan full-width */
    }
}

</style>

<div class="container mt-4">
    <div class="section-padding">
        <h2>
            <i class="bi bi-people"></i>
            Peserta: {{ $jumlahPeserta }}/{{ $kapasitas }}
        </h2>
    </div>
    <hr>

    <!-- Gunakan Flexbox untuk susun pembuat dan peserta -->
<div class="row">
    <!-- Pembuat Mabar -->
    <div class="card mb-3" style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-person" style="font-size: 2.5rem;"></i>
            <div>
                <p style="margin: 0; font-weight: bold;">{{ $pembuat['name'] ?? '-' }}</p>
                <p style="margin: 0;">{{ $pembuat['nomor_telepon'] ?? '-' }}</p>
                <a style="color: green; text-decoration: underline;">Penyelenggara</a>
            </div>
        </div>
        <a href="{{ route('informasi.pemain', ['userId' => $pembuat['_id'] ?? '']) }}" class="btn btn-primary btn-sm">Informasi</a>
        
    </div>

    <!-- Peserta Join -->
    @foreach($peserta as $user)
        <div class="card mb-3" style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                <div>
                    <p style="margin: 0; font-weight: bold;">{{ $user['name'] ?? '-' }}</p>
                    <p style="margin: 0;">{{ $user['nomor_telepon'] ?? '-' }}</p>
                </div>
            </div>
            <a href="{{ route('informasi.pemain', ['userId' => $user['_id'] ?? '']) }}" class="btn btn-primary btn-sm">Informasi</a>
        </div>
    @endforeach
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mabarId = sessionStorage.getItem('mabarId');
        if (mabarId) {
            // Pakai route() untuk generate URL tanpa query
            const url = "{{ route('mabar.pemainFromRequest') }}?mabarId=" + encodeURIComponent(mabarId);
            window.location.href = url;
        } 
    });

 document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.container');
        if(container){
            container.querySelectorAll('*').forEach(el => {
                el.style.paddingRight = '20px'; // atur padding kanan 20px untuk semua elemen di dalam container
            });
        }
    });

</script>

@endsection
