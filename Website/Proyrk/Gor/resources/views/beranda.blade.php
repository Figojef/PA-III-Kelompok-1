@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
.booksekarang {
    padding: 15px 25px;
    border: 1px solid #fff;
    border-radius: 40px;
    text-decoration: none;
    color: white;
    font-weight: 600;
}
.booksekarang:hover {
    background-color: rgba(255, 255, 255, 0.9);
    color: #111;
    border-color: rgba(255, 255, 255, 1);
    transition:  0.5s ease;
}

</style>

<!-- Carousel -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/carosel.jpg') }}" class="d-block w-100" alt="Picture 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/lapangan2.jpg') }}" class="d-block w-100" alt="Picture 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/lapangan3.jpg') }}" class="d-block w-100" alt="Picture 3">
        </div>
    </div>

    <!-- Teks tetap di tengah carousel -->
    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
        <!-- Siapkan Tenaga di atas -->
        <h2 class="text-center text-white fw-bold mb-1">Siapkan Tenaga,</h2> <!-- Mengurangi margin bawah -->
        <h2 class="text-center text-white fs-bold mb-1">Saatnya Smash Terbaikmu!</h2> <!-- Mengurangi margin bawah -->
        <p class="text-center text-white fs-5" style=" white-space: nowrap;">Lapangan Berkualitas Siap untuk Aksimu - Jangan Lewatkan Momen Ini!</p>
        <a href="{{ route('reservasi') }}" class="booksekarang">
    Booking Sekarang <i class="bi bi-arrow-right"></i>
</a>
    </div>


    <!-- Tombol navigasi dengan ikon panah -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Card Informasi -->
<div class="container text-center card-baru">
    <div class="row">
        @php
        $cards = [
            ['icon' => asset('icons/Fast Food.png'), 
            'info'  => 'Kami menyediakan makanan dan minuman'],
            ['icon' => asset('icons/badminton.png'), 
            'info'  => 'Kami menyediakan booking untuk raket dan shuttlecock'],
            ['icon' => asset('icons/comfort.png'), 
            'info'  => 'Mengutamakan kenyamanan para pemain']
        ];
        @endphp

        @foreach ($cards as $card)
            <div class="col ms-5">
                <div class="card p-3" style="color: #626262;width: 20rem; background: linear-gradient(180deg, #ffffff 0%, #cbcbc0 88%, #979780 98%, #fdfdd7 100%);">
                    <div>
                        <img src="{{ $card['icon'] }}" alt="Icon" width="100" height="100">
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

<div class="container mt-5 ">
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
    </div>
</div>

<div class="container">
    <div class="container-fluid mt-4">
        <div class="card border-dark p-4" style="background: linear-gradient(180deg, #ffffff 0%, #cbcbc0 88%, #979780 98%, #fdfdd7 100%);">
            <p class="fs-5 text-justify">
                Selamat datang di Ramos Badminton Center. Kami menyediakan lapangan profesional untuk para penggemar bulutangkis. Selamat 
                datang di Ramos Badminton Center. Kami menyediakan lapangan profesional untuk para penggemar bulutangkis. Selamat datang di 
                Ramos Badminton Center. Kami menyediakan lapangan profesional untuk para penggemar bulutangkis. Selamat datang di Ramos Badminton Center. 
                Kami menyediakan lapangan profesional untuk para penggemar bulutangkis. Selamat datang di Ramos Badminton Center. Kami menyediakan lapangan
                profesional untuk para penggemar.
            </p>
            <a href="tentang" class="text-dark fw-bold text-decoration-none d-inline-flex align-items-center">
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
            <div class="col-md-9 d-flex flex-column justify-content-center bg-dark text-white p-4">
                <h1 class="fw-bold">Lokasi</h1>
                <p class="fs-5">Sitoluama, Kec. Sigumpar, Toba, Sumatera Utara 22382</p>
                
            </div>
            <!-- Bagian Gambar Peta -->
            <div class="col-md-3 d-flex justify-content-center align-items-center p-3">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.3572780658474!2d99.14953731059431!3d2.3866894975825805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e01006b2f6d8f%3A0x60ccf1992db75d43!2sRamos%20Badminton%20Center!5e0!3m2!1sid!2sid!4v1742659859447!5m2!1sid!2sid"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    // Cek URL: kalau ada logout=true, hapus sessionStorage
    if (window.location.search.includes("logout=true")) {
        sessionStorage.removeItem('selectedSlots');
        sessionStorage.removeItem('transactionId');
        sessionStorage.removeItem('selectedMabar');
        console.log("selectedSlots dihapus karena logout");
    }

    // Tampilkan tombol scroll ke atas dengan animasi halus
    window.onscroll = function () {
        const btn = document.getElementById("scrollToTopBtn");
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            btn.style.display = "block";
            setTimeout(() => {
                btn.style.opacity = 1;
            }, 100); // Delay munculnya tombol (100ms)
        } else {
            btn.style.opacity = 0;
            setTimeout(() => {
                btn.style.display = "none";
            }, 500); // Tunggu hingga animasi hilang selesai
        }
    };

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>


<!-- Tombol Scroll ke Atas -->
<button onclick="scrollToTop()" id="scrollToTopBtn" title="Kembali ke atas"
    class="position-fixed shadow"
    style="
        bottom: 40px;
        right: 40px;
        width: 60px;      
        height: 60px;     
        border-radius: 50%;
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
        background: linear-gradient(180deg, #ffffff 0%, #cbcbc0 88%, #979780 98%, #fdfdd7 100%); /* 👉 Gradient background */
        border: 2px solid #626262;  /* opsional: biar kelihatan tegas */
        z-index: 9999;
        color: #000; 
    ">
    <i class="bi bi-arrow-up fs-4"></i>
</button>


<script>
    // SweetAlert for Login Success
    @if(Session::has('login_success'))
        @php
            $loginData = Session::get('login_success');
        @endphp
        
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Login Berhasil!',
                text: 'Selamat datang ! Nikmati layanan pemesanan lapangan badminton kami.',
                icon: 'success',
                confirmButtonText: 'Mulai Bermain',
                confirmButtonColor: '#222F37',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: true,
                allowOutsideClick: false
            });
        });
        
        @php
            Session::forget('login_success');
        @endphp
    @elseif(Session::has('register_success'))
        @php
            $loginData = Session::get('register_successs');
        @endphp
        
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil Mendaftarkan Akun!',
                text: 'Selamat datang ! Nikmati layanan pemesanan lapangan badminton kami.',
                icon: 'success',
                confirmButtonText: 'Mulai Bermain',
                confirmButtonColor: '#222F37',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: true,
                allowOutsideClick: false
            });
        });
        
        @php
            Session::forget('login_success');
        @endphp
    @endif
</script>

<script>
    // Cek URL: kalau ada logout=true, hapus sessionStorage
    if (window.location.search.includes("logout=true")) {
        sessionStorage.removeItem('selectedSlots');
        console.log("selectedSlots dihapus karena logout");
    }
</script>

@endsection

