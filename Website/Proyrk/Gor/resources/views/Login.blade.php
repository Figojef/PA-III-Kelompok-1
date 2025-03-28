<!Doctype HTML>
<HTML lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <title>Login</title>
        <style>
            body {
                background-color: #F3F3E0;
                font-family: Arial, sans-serif;
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
            .Login {
                width: 300px;
                height: 40px;
                font-size: 16px;
                padding: 5px 10 10;
                margin: 40px 0 0 0;
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
        <center style="margin-top: 150px;">
        <form id="loginForm" method="post">
            @csrf
            <div>
                <label style="font-weight: 550;font-size: 30px;">Masuk</label><br>
                     <input type="text" name="name" id="name" placeholder="nama pengguna" class="Login" style="border-radius: 3px 3px 3px 3px;" required><br>
                    <input type="password" name="password" id="password" placeholder="password" class="Login" style="border-radius: 3px 3px 3px 3px;" required><br>
                 <button type="submit" class="Login" style="color: white; font-weight: bold; background-color: #608AC2;">Masuk</button><br><br>
            <a href="" style="margin-right: 180px; text-decoration: none;">Lupa Password?</a><br><br>
            <p style="font-size: 25px;">Belum punya akun?
            <a href="{{ url('/') }}" style="text-decoration: none;">Daftar yuk!</a>
            </div>
         </form">
    </center>

    <script>
document.getElementById("loginForm").addEventListener("submit", async function(event) {
    event.preventDefault();
    
    console.log("Form submitted!"); // Cek apakah event listener bekerja

    const name = document.getElementById("name").value;
    const password = document.getElementById("password").value;

    console.log("Sending request to API...");

    try {
        const response = await fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, password}),
        });

        const data = await response.json();
        console.log("Response received:", data);

        if (response.ok) {
            alert("Login berhasil!");
            window.location.href = "/"
        } else {
            alert("Error: " + (data.message || "Gagal login"));
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("Terjadi kesalahan, cek console untuk detail.");
    }
});
</script>
    </body>
</HTML>