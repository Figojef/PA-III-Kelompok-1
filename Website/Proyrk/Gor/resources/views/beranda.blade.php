<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramos Badminton Center</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f8f5e8;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #222F37;
        }
        .navbar ul {
            display: flex;
            list-style: none;
        }
        .navbar ul li {
            margin: 0 15px;
        }
        .navbar ul li a {
            text-decoration: none;
            color: white;
            font-size: 20px;
        }

        .carousel-item img {
            height: 1000px;
            object-fit: cover;
            position: relative;
        }
        .hero {
            position: relative;
            text-align: center;
            color: white;
        }
        .card-container {
            top: 85%; /* Sesuaikan agar card turun sedikit */
            left: 50%;
            transform: translate(0%, -25%);
            display: flex;  
        }

        .card {
            width: 300px; /* Sesuaikan ukuran */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hero img {
            width: 100%;
            /* height: auto; */
            height: 500px;
            filter: brightness(70%);
        }
        .hero .button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #6d8ac6;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            border-radius: 10px;
            text-decoration: none;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            position: relative;
            top: -110px;
        }
        .feature-box {
            background-color: #6d8ac6;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            width: 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .feature-box .title {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .feature-box img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
        }
        .description {
            background-color: #fff6d5;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }
        /* .location-box {
            background-color: #6d8ac6;
            color: white;
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 10px;
        }
        .map {
            margin-top: 10px;
        } */
        .location-box {
    background-color: #6d8ac6;
    color: white;
    padding: 15px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    width: 70%;
}

.location-box p {
    margin-left: 20px; 
    width: 50%; 
}

.map {
    width: 40%; 
}

.map img {
    width: 100%;
    border-radius: 10px;
}


        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
                top: -25px;
            }
            .feature-box {
                width: 80%;
            }
        }


        .footer {
            background-color: #222F37;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .footer .contact {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .footer .contact div {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer .contact img {
            width: 20px;
            height: 20px;
        }
        .footer .logo img {
            width: 80px;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('storage/Logo.png') }}" width="90" height="90" class="d-inline-block align-top me-3" alt="Logo">
            <label style="font-size:35px; font-weight: bold;">Ramos Badminton Center</label>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="#"><b>Beranda</b></a></li>
    <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Jadwal</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Reservasi</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Event</a></li>

    @if(session()->has('jwt'))
        <!-- Jika sudah login, tampilkan ikon user -->
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
        </li>
    @else
        <!-- Jika belum login, tampilkan tombol login -->
        <li class="nav-item">
            <a class="nav-link btn btn-primary text-white px-3 py-1" href="/login">Login</a>
        </li>
    @endif
</ul>

        </div>
    </div>
</nav>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('storage/Lapangan.jpg') }}" class="d-block w-100" alt="gambar">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('storage/Depan2.jpg') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<center>
<div class="row card-container">
    <div class="col">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">Makanan dan Minuman</h5>
                    <p class="card-text">Menyediakan makanan dan minuman</p>

                </div>
        </div>
    </div>
    <div class="col-5">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    <div class="col">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>


<br><br>
    
        <section style="margin-top: -70px;" class="description">
            <h2>Deskripsi</h2><br><br>
            <p>2 Lapangan Badminton di Sitoluama, Laguboti, Sumatera Utara.</p><br>
            <p><strong>Buka :</strong> Senin-Minggu, 08.00-22.00</p><br>
            <p><strong>Fasilitas :</strong> 2 Lapangan, parkir, toilet.</p><br>
            <p><strong>Tersedia :</strong> Shuttlecock, dan sewa raket.</p><br><br><br>
            <p><strong>Mohon diperhatikan untuk pengguna lapangan/penyewa lapangan:</strong></p>
            <ul>
                <p><strong>DILARANG MEROKOK</strong></p>
                <p><strong>DILARANG MEMAKAI SENDAL DI DALAM ZONA LAPANGAN</strong></p>
            </ul>
            <p><a href="#">Baca Selengkapnya</a></p>
            <div class="location-box">
                <p>Lokasi : Ramos Badminton Center<br> Sitoluama, Kec. Sigumpar, Toba<br> Sumatera Utara 22382</p>
                <div class="map">
                    <img height="100%" src="map1.png" alt="Peta Lokasi" width="">
                </div>
            </div>
            

        </section>
    </center>

    <br><br>
    <footer class="footer">
        <div class="contact">
            <div><img src="phone-icon.png" alt="Phone"> +62 124 819 026</div>
            <div><img src="email-icon.png" alt="Email"> info@ramosbadminton.com</div>
            <div><img src="location-icon.png" alt="Location"> Jl. Sitoluama 2, Laguboti</div>
        </div>
        <div class="footer-logo">
            <img width="100px" height="100px" src="logo.png" alt="Badminton Logo">
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
