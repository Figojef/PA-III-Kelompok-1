<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #222F37;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .card {
            background-color: #FDFDD7;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            margin: auto;
            /* Pusatkan secara horizontal */
        }

        .login-input {
            height: 50px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding-left: 20px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .login-btn {
            background-color: #222F37;
            color: #FDFDD7;
            font-weight: bold;
            border-radius: 10px;
            height: 50px;
            font-size: 16px;
            border: none;
        }

        .login-btn:hover {
            background-color: #1b252c;
        }

        @media (max-width: 768px) {
            .card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; padding: 15px;">
        <form id="loginForm" action="{{ route('login.submit') }}" method="POST" class="card p-4 shadow-sm w-100">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="text-center mb-4">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" width="100" height="100">
                <h4 class="mt-3 mb-0 fw-bold">Ramos Badminton</h4>
            </div>

            <div class="mb-3">
                <input type="email" name="email" id="email" placeholder="Email Pengguna"
                    class="form-control login-input" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" placeholder="Kata Sandi"
                    class="form-control login-input" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary login-btn">Masuk</button>
            </div>
            <div class="text-center">
                <a href="#" class="text-decoration-none fw-bold" style="color: #222F37;">Lupa Kata
                    Sandi?</a>
            </div>
            <div class="text-center mt-3">
                <span style="font-size: 16px;">Belum punya akun?
                    <a href="{{ url('/') }}" class="text-decoration-none fw-bold">Daftar yuk!</a>
                </span>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login</title>
</head>
<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html> --}}
