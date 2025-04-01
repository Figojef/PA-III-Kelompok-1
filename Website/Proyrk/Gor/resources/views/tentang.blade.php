@extends('layouts.app')

@section('content')

<div class="main-content">
        <div class="container my-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Tentang Kami</h2>
                <hr class="mx-auto" style="width: 100px; height: 3px; background-color: black;">
            </div>

            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-md-3 col-12 text-center text-md-start">
                        <img src="assets/picture1.jpeg" alt="Ramos Badminton Center"
                            class="img-fluid rounded shadow w-100">
                    </div>
                    <div class="col-md-9 col-12 mt-3 mt-md-0">
                        <p class="text-justify">
                            Ramos Badminton Center adalah pusat olahraga bulu tangkis yang berlokasi di Sitoluama, Kec.
                            Sigumpar, Toba, Sumatera Utara. Kami menyediakan layanan pemesanan lapangan secara fleksibel
                            melalui website resmi kami, memastikan kemudahan akses bagi setiap pelanggan.
                            Diresmikan pada bulan Januari 2025, Ramos Badminton Center berkomitmen untuk menjadi tempat
                            terbaik bagi komunitas bulu tangkis di Toba.
                            <br>
                            Dengan fasilitas lapangan yang nyaman dan terawat, kami
                            hadir untuk mendukung para pecinta bulu tangkis, baik pemula maupun atlet yang ingin
                            meningkatkan keterampilan mereka. Selain itu, kami juga menghadirkan berbagai event dan
                            turnamen bulu tangkis yang terbuka untuk umum, memberikan kesempatan bagi pemain untuk
                            mengasah kemampuan serta membangun relasi dalam komunitas bulu tangkis. Kami percaya bahwa
                            dengan adanya kompetisi yang sehat, semangat olahraga dapat terus tumbuh dan berkembang.
                            Fasilitas kami mencakup area istirahat yang nyaman, ruang ganti, serta pencahayaan optimal
                            untuk memastikan pengalaman bermain yang maksimal. Dengan sistem pemesanan online yang
                            praktis, pelanggan dapat dengan mudah memilih jadwal yang sesuai. Kami berharap Ramos
                            Badminton Center menjadi tempat berkumpulnya komunitas bulu tangkis untuk berlatih,
                            bersaing, dan bersenang-senang. Dengan dedikasi ini, kami berharap dapat menjadi rumah bagi
                            para pecinta bulu tangkis dan turut berkontribusi dalam perkembangan olahraga ini di Toba.
                        </p>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-9 col-12 order-2 order-md-1 mt-3 mt-md-0">
                        <p class="text-justify">
                            Ramos Badminton Center memiliki dua lapangan berbahan beton yang nyaman untuk bermain.
                            Melalui
                            sistem online, Anda dapat melihat
                            ketersediaan lapangan secara real-time, melakukan booking dengan mudah, dan bahkan bergabung
                            dengan tim yang membutuhkan pemain. Dengan fitur tambahan seperti ulasan pengguna, informasi
                            layanan,
                            dan pengelolaan jadwal yang lebih efisien, kami menghadirkan pengalaman bermain bulu tangkis
                            yang
                            modern, praktis, dan menyenangkan bagi Anda. Kami juga menyediakan perlengkapan bulu tangkis
                            yang dapat disewa seperti kok, raket, dan fasilitas lainnya sehingga pemain tidak perlu
                            khawatir jika tidak membawa peralatan sendiri. Selain itu, kami juga menjual berbagai
                            perlengkapan bulu tangkis seperti jersey eksklusif serta menyediakan makanan dan minuman
                            ringan yang bisa dinikmati.
                        </p>
                    </div>
                    <div class="col-md-3 col-12 text-center text-md-end order-1 order-md-2">
                        <img src="assets/picture2.jpg" alt="Lapangan Badminton" class="img-fluid rounded shadow w-100">
                    </div>
                </div>
            </div>

            <!-- Galeri -->
            <div class="container text-center my-5">
                <h2 class="fw-bold">Galeri</h2>
                <hr class="mx-auto" style="width: 100px; height: 3px; background-color: black;">
                <div class="row mt-4">
                    <div class="col-md-4">
                        <img src="assets/galeri1.png" alt="GOR Ramos" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-4">
                        <img src="assets/galeri2.png" alt="Lapangan Bulu Tangkis" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-4">
                        <img src="assets/galeri3.png" alt="Latihan di Lapangan" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="assets/galeri4.jpeg" alt="Jadwal Booking" class="img-fluid rounded shadow"
                            style="width: 100%; height: 257px; object-fit: cover;">
                    </div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="assets/galeri5.png" alt="GOR Ramos Tampak Depan" class="img-fluid rounded shadow"
                            style="width: 100%; height: 257px; object-fit: cover;">
                    </div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="assets/galeri6.jpeg" alt="Papan Jadwal" class="img-fluid rounded shadow"
                            style="width: 100%; height: 257px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
