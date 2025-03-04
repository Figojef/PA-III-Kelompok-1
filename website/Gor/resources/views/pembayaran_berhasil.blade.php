<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            text-align: center;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f5f5dc;
            padding: 15px 30px;
        }
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
        }
        .logo img {
            height: 50px;
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
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .success-message {
            color: green;
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .amount {
            font-size: 2em;
            font-weight: bold;
            color: black;
            margin-bottom: 20px;
        }
        .details {
            text-align: left;
            margin-bottom: 20px;
        }
        .details p {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #608BC1;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1.2em;
            margin-top: 20px;
            border-radius: 5px;
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
        <p class="success-message">Pembayaran Berhasil!</p>
        <p class="amount">Rp 60.000</p>
        <div class="details">
            <p><strong>Nomor Rekening:</strong> 1542 8765 7489234</p>
            <p><strong>Waktu Pembayaran:</strong> 22-02-2025, 14:21:31</p>
            <p><strong>Metode Pembayaran:</strong> Transfer Bank</p>
            <p><strong>Nama Pengirim:</strong> Benhard Sijabat</p>
            <p><strong>Jenis Lapangan:</strong> Lapangan 1</p>
            <p><strong>Nominal:</strong> Rp 60.000</p>
        </div>
        <a href="#" class="button">Lanjutkan</a>
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
