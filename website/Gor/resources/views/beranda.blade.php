<!DOCTYPE html>
<html lang="id">
<head>
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
            padding: 20px;
            background-color: #f8f5e8;
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
            color: black;
            font-weight: bold;
        }
        .hero {
            position: relative;
            text-align: center;
            color: white;
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
            background-color: #0A3873;
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
    <nav class="navbar">
        <img width="50px" height="50px" src="logo.png" alt="Badminton Logo">

        <h2 class="ok">Ramos Badminton Center</h2>
        <ul>
            <li><a href="#">Beranda</a></li>
            <li><a href="#">Jadwal</a></li>
            <li><a href="#">Reservasi</a></li>
            <li><a href="#"><div class="user-icon">&#128100;</div></a></li>
        </ul>
    </nav>
    
    <section class="hero">
        <img src="image.png" alt="Lapangan Badminton">
        <a href="#" class="button">Lihat Jadwal</a>
    </section>
    
    <section class="features">
        <div class="feature-box">
            <div class="title">
                <img src="a1.png" alt="Makanan">
                <h3>Makanan & Minuman</h3>
            </div>
            <p>Menyediakan makanan dan minuman</p>
        </div>
        <div class="feature-box">
            <div class="title">
                <img src="a2.png" alt="Peralatan">
                <h3>Peralatan</h3>
            </div>
            <p>Menyediakan booking untuk raket dan shuttlecock</p>
        </div>
        <div class="feature-box">
            <div class="title">
                <img src="a3.png" alt="Kenyamanan">
                <h3>Kenyamanan</h3>
            </div>
            <p>Mengutamakan kenyamanan penyewa</p>
        </div>
    </section>
    
    <center>
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
</body>
</html>
