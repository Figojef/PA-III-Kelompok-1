@extends('layouts.app')

@section('content')

<!-- Carousel -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/lapangan1.jpg') }}" class="d-block w-100" alt="Picture 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/lapangan2.jpg') }}" class="d-block w-100" alt="Picture 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/lapangan3.jpg') }}" class="d-block w-100" alt="Picture 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Card Informasi -->
<div class="container text-center card-baru">
    <div class="row">
        @php
        $cards = [
            ['icon' => asset('icons/Fast Food.png'), 
            'title' => 'Makanan dan Minuman',
            'info'  => 'Kami menyediakan makanan dan minuman'],
            ['icon' => asset('icons/badminton.png'), 
            'title' => 'Peralatan Olahraga',
            'info'  => 'Kami menyediakan booking untuk raket dan shuttlecock'],
            ['icon' => asset('icons/comfort.png'), 
            'title' => 'Pelayanan dan Kenyamanan',
            'info'  => 'Mengutamakan kenyamanan penyewa']
        ];
        @endphp

        @foreach ($cards as $card)
            <div class="col">
                <div class="card p-3" style="width: 20rem;">
                    <div class="card-content">
                        <img src="{{ $card['icon'] }}" alt="Icon" width="100" height="100">
                        <div class="card-text-section">
                            <h5 class="card-title">{{ $card['title'] }}</h5>
                        </div>
                    </div>
                    <p class="text-center mt-3">{{ $card['info'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div> <!-- ✅ Tambahkan penutup `div` yang kurang -->

<!-- Event Section -->
<div class="container text-left mt-5">
    <div class="d-flex align-items-center">
        <h2 class="me-3">Event</h2>
        <div class="line"></div>
    </div>
</div>

<div class="container mt-4 ">
    <div class="event-container">
        <div class="event-card">
            <img src="{{ asset('images/event4.jpg') }}" alt="Event 1">
        </div>
        <div class="event-card">
            <img src="{{ asset('images/event2.jpg') }}" alt="Event 2">
        </div>
        <div class="event-card">
            <img src="{{ asset('images/event3.jpg') }}" alt="Event 3">
        </div>
    </div>
</div>

<!-- Tentang Kami -->
<div class="container text-left mt-5">
    <div class="d-flex align-items-center">
        <h2 class="me-3">Tentang Kami</h2>
        <div class="line"></div>
        <h2>
            @php
                if(isset($jwt)){
                    echo $jwt;
                }else{
                    echo "Not found";
                }
            @endphp
        </h2>
    </div>
</div>

<div class="container">
    <div class="container-fluid mt-4">
        <div class="card border-dark p-4">
            <p class="fs-5 text-justify">
                Selamat datang di Ramos Badminton Center. Kami menyediakan lapangan profesional untuk para penggemar
                bulutangkis. 
                Kami memiliki fasilitas terbaik dan program latihan untuk pemain dari semua tingkat keahlian.
            </p>
            <a href="#" class="text-dark fw-bold text-decoration-none d-inline-flex align-items-center">
                Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Card Lokasi -->
<div class="container mt-5">
    <div class="container-fluid mt-4">
        <div class="card border-dark d-flex flex-row align-items-stretch" style="min-height: 40vh;">
            <!-- Bagian Tulisan dengan Background Hitam -->
            <div class="col-md-6 d-flex flex-column justify-content-center bg-dark text-white p-4">
                <h1 class="fw-bold">Lokasi</h1>
                <p class="fs-5">Sitoluama, Kec. Sigumpar, Toba, Sumatera Utara 22382</p>
            </div>
            <!-- Bagian Gambar Peta -->
            <div class="col-md-6 d-flex justify-content-center align-items-center p-3">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.3572780658474!2d99.14953731059431!3d2.3866894975825805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e01006b2f6d8f%3A0x60ccf1992db75d43!2sRamos%20Badminton%20Center!5e0!3m2!1sid!2sid!4v1742659859447!5m2!1sid!2sid"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection
