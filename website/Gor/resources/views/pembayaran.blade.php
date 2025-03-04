<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pembayaran</title>
    <style>
        /* Navbar Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: serif;
            background-color: #f5f5dc;
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
        /* Hamburger Menu Styles */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 25px;
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .hamburger div {
            width: 30px;
            height: 4px;
            background-color: black;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .menu {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: center;
                gap: 10px;
                padding: 10px;
                background-color: #f5f5dc;
            }
            .menu.active {
                display: flex;
            }
            .hamburger {
                display: flex;
            }
        }
        /* Payment Section Styles */
        .container {
            padding: 20px;
        }
        .payment-section {
            background-color: #f8f4e4;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        .payment-section h1 {
            font-size: 1.8em;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 1em;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .payment-options {
            margin: 20px 0;
        }
        .payment-options label {
            margin-right: 15px;
        }
        .summary {
            margin: 20px 0;
            font-size: 1.1em;
        }
        .confirm-button {
            display: block;
            width: 100%;
            background-color: #608BC1;
            color: white;
            text-align: center;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
        }
        .confirm-button:hover {
            background-color: #0056b3;
        }
        /* Footer Styles */
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
            height: 80px;
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
        <div class="payment-section">
            <h1>Pembayaran</h1>
            <div class="form-group">
                <label for="name">Nama Pelanggan</label>
                <input type="text" id="name" placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
                <label for="phone">No. Telepon</label>
                <input type="text" id="phone" placeholder="08xxxxxxxxxx">
            </div>
            <div class="payment-options">
                <label for="payment">Pilih Jenis Pembayaran</label><br><br>
                <label><input type="radio" name="payment" value="bank" checked> Transfer BANK</label>
                <label><input type="radio" name="payment" value="cash"> Bayar Ditempat</label>
            </div>
            <div class="summary">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #ccc;">
                        <td style="padding: 10px; font-size: 1em;">Lapangan 1 - Sabtu, 22 Februari 2025 (16:00 - 17:00)</td>
                        <td style="padding: 10px; font-size: 1em; text-align: right;">Rp. 30.000</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ccc;">
                        <td style="padding: 10px; font-size: 1em;">Lapangan 1 - Sabtu, 22 Februari 2025 (17:00 - 18:00)</td>
                        <td style="padding: 10px; font-size: 1em; text-align: right;">Rp. 30.000</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-size: 1.1em; font-weight: bold;">Total Bayar</td>
                        <td style="padding: 10px; font-size: 1.1em; text-align: right; font-weight: bold;">Rp. 60.000</td>
                    </tr>
                </table>
            </div>
            <button class="confirm-button">Konfirmasi Pembayaran</button>
        </div>
    </div>

    <footer class="footer">
        <div class="contact">
            <div><img src="172517_phone_icon.png" alt="Phone"> +62 124 819 026</div>
            <div><img src="2674096_object_email_web_essential_icon.png" alt="Email"> info@ramosbadminton.com</div>
            <div><img src="352521_location_on_icon.png" alt="Location"> Jl. Sitoluama 2, Laguboti</div>
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
