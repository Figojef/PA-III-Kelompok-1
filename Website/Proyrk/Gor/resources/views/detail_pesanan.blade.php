<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F3F3E0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #F3F3E0;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
        }
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .menu {
            display: flex;
            gap: 20px;
        }
        .menu a {
            text-decoration: none;
            color: black;
            font-size: 1.1em;
        }
        .menu a:hover {
            text-decoration: underline;
        }
        .user-icon {
            font-size: 1.5em;
        }
        .container {
            max-width: 600px;
            margin: 100px auto 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }
        .container h2 {
            margin-bottom: 15px;
        }
        .status {
            background: green;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #608BC1;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1.2em;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #133E87;
        }

        footer {
            background-color: #133E87;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .contact {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .contact div {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .contact img {
            height: 30px;
        }
        .footer-logo img {
            height: 100px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
            <span>RAMOS BADMINTON CENTER</span>
        </div>
        <div class="menu">
            <a href="#">BERANDA</a>
            <a href="#">JADWAL</a>
            <a href="#">RESERVASI</a>
        </div>
        <div class="user-icon">&#128100;</div>
    </nav>
    
    <div class="container">
        <h2>Detail Pesanan</h2>
        <p><strong>Nama Pemesan:</strong> Benhard Sijabat</p>
        <br>
        <p><strong>No. Telepon:</strong> 0823 7534 2314</p>
        <br>
        <p><strong>Jadwal Bermain:</strong> 22 Februari 2025, 16.00 - 18.00</p>
        <br>
        <p><strong>Jenis Lapangan:</strong> Lapangan 1</p>
        <br>
        <p><strong>Status Pembayaran:</strong> <span class="status">Berhasil</span></p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <a href="#" class="button">Selesai</a>
    </div>
    
    <footer>
        <div class="contact">
            <div><img src="phone-icon.png" alt="Phone"> +62 124 819 026</div>
            <div><img src="email-icon.png" alt="Email"> info@ramosbadminton.com</div>
            <div><img src="location-icon.png" alt="Location"> Jl. Sitoluama 2, Laguboti</div>
        </div>
        <div class="footer-logo">
            <img src="logo.png" alt="Badminton Logo">
        </div>
    </footer>
</body>
</html>