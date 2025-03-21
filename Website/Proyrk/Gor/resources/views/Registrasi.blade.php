<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F3F3E0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #608AC2;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Registrasi</h2>
    <form id="registerForm" method="post">
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label>Nama Pengguna</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="form-group">
        <label>Kata Sandi</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="form-group">
        <label>Konfirmasi Kata Sandi</label>
        <input type="password" id="confirmPassword" required>
    </div>
    <button type="submit" class="btn">Daftar</button>
</form>

<script>
document.getElementById("registerForm").addEventListener("submit", async function(event) {
    event.preventDefault();
    
    console.log("Form submitted!"); // Cek apakah event listener bekerja

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
        alert("Kata sandi tidak cocok!");
        return;
    }

    console.log("Sending request to API...");

    try {
        const response = await fetch("http://127.0.0.1:8000/api/register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, password }),
        });

        const data = await response.json();
        console.log("Response received:", data);

        if (response.ok) {
            alert("Registrasi berhasil!");
            window.location.href = "/Login"
        } else {
            alert("Error: " + (data.message || "Gagal registrasi"));
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("Terjadi kesalahan, cek console untuk detail.");
    }
});
</script>
</body>
</html>
