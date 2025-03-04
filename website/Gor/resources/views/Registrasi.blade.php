<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Badminton</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F3F3E0;
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
            width: 100px;
            height: 100px;

        }
        @media (max-width: 600px) {
            .footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .label {
                width: 300px;
                height: 40px;
                font-size: 16px;
                padding: 5px 10 10;
        }
        .title {
            font-weight: lighter;
            font-size: 20px;
        }
            
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
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
            <a href="Beranda">BERANDA</a>
            <a href="#">JADWAL</a>
            <a href="#">RESERVASI</a>
        </div>
        <div class="user-icon">&#128100;</div>
    </nav>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('active');
        }
    </script>

<center style="margin-top: 100px;">
    <div>
        <label style="font-weight: 550;font-size: 30px;">Registrasi</label><br>
        <div class="Jarak" style="margin-top: 40px;">
             <label class="title" style="margin-right: 150px;">Nama Pengguna</label><br>
             <input type="text" name="nama" id="" class="label" style="border-radius: 3px 3px 3px 3px;"><br>
        </div><br>
        <div class="Jarak">
            <label class="title" style="margin-right: 250px;">Email</label><br>
            <input type="text" name="nama" id="" class="label" style="border-radius: 3px 3px 3px 3px;"><br>
        </div><br>
        <div class="Jarak">
            <label class="title" style="margin-right: 200px;">Kata Sandi</label><br>
            <input type="text" name="nama" id="" class="label" style="border-radius: 3px 3px 3px 3px;"><br>
        </div><br>
        <div class="Jarak">
            <label class="title" style="margin-right: 100px;">Konfirmasi Kata Sandi</label><br>
            <input type="text" name="nama" id="" class="label" style="border-radius: 3px 3px 3px 3px;"><br>
        </div><br>
        <a href="Login.html">
        <button type="submit" class="label" style="color: white; margin: 30px;font-weight: bold; background-color: #608AC2;">Masuk</button><br><br>
        </a>
    </div>
</center>
</body>
<footer>
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
</html>
