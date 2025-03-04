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
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4ee;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f5f5dc;
            padding: 10px 20px;
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
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 25px;
            cursor: pointer;
        }
        .hamburger div {
            width: 30px;
            height: 4px;
            background-color: black;
        }
        @media (max-width: 768px) {
            .menu {
                display: none;
                flex-direction: column;
                width: 100%;
                align-items: center;
                gap: 10px;
                background-color: #f5f5dc;
                padding: 10px;
            }
            .menu.active {
                display: flex;
            }
            .hamburger {
                display: flex;
            }
        }
        .container {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 80%;
            max-width: 1000px;
            margin: 50px auto;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
        font-size: 24px; 
        font-weight: bold;
        }

        .sub-header {
        font-size: 18px; 
         color: #333; 
         margin-bottom: 30px;
        }
        .order-item {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .price {
            font-weight: bold;
            float: right;
        }
        .delete {
            color: gray;
            font-size: 12px;
            cursor: pointer;
        }
        .confirm-btn {
            background-color: #4f7db3;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 14px;
            cursor: pointer;
            border-radius: 15px;
            margin-top: 30px;
        }
        .footer {
            background-color: #0A3873;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 100px;
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
            width: 100px;
            margin-right: 10px;
        }
        @media (max-width: 600px) {
            .footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
            <span>RAMOS BADMINTON CENTER</span>
        </div>
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu" id="menu">
            <a href="#">BERANDA</a>
            <a href="#">JADWAL</a>
            <a href="#">RESERVASI</a>
        </div>
        <div class="user-icon">&#128100;</div>
    </nav>
    
    <div class="container">
        <div class="header">Periksa Pemesanan Anda</div>
        <div class="sub-header">Pastikan pemesanan sudah sesuai dan benar</div>
        <div class="order-item">
            <div>Lapangan 1</div>
            <div>Sabtu, 22 Februari 2025</div>
            <div>16.00 - 17.00 <span class="price">Rp. 30.000</span></div>
            <div class="delete">🗑 Hapus</div>
        </div>
        <div class="order-item">
            <div>Lapangan 1</div>
            <div>Sabtu, 22 Februari 2025</div>
            <div>17.00 - 18.00 <span class="price">Rp. 30.000</span></div>
            <div class="delete">🗑 Hapus</div>
        </div>
        <button class="confirm-btn">Konfirmasi Pemesanan</button>
    </div>
    
    <footer class="footer">
        <div class="contact">
            <div><img src="phone-icon.png" alt="Phone"> +62 124 819 026</div>
            <div><img src="email-icon.png" alt="Email"> info@ramosbadminton.com</div>
            <div><img src="location-icon.png" alt="Location"> Jl. Sitoluama 2, Laguboti</div>
        </div>
        <div class="logo">
            <img src="logo.png" alt="Badminton Logo">
        </div>
    </footer>
    
    <script>
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>