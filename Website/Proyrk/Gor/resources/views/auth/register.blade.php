<!Doctype HTML>
<HTML lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>Register - Ramos Badminton</title>
        <style>
            body {
                background-color: #222F37;
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
        .card {
            background-color: #FDFDD7;
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
            .Register {
                width: 400px;
                height: 50px;
                font-size: 16px;
                padding: 10px 20px;
                margin: 15px 0;
                border-radius: 10px;
                border: 1px solid #ccc;
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

        /* Error Styles */
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
            width: 400px;
        }

        .input-error {
            border: 2px solid #dc3545 !important;
        }

        .alert-custom {
            width: 400px;
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-register {
            width: 400px;
            height: 50px;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            border-radius: 10px;
            border: none;
            color: #FDFDD7;
            background-color: #222F37;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-register:hover {
            background-color: #1a252b;
        }
        </style>
    </head>
    <body>
        <center style="margin-top: 50px;">
        <form id="registerForm" action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="card" style="width: 35rem; margin-bottom: 50px; border-radius: 20px; padding: 20px;">
                <center>  
                    <img width="80px" height="80px" src="{{ asset('storage/Logo.png') }}" style="margin-top: 3%;" alt="Badminton Logo"><br>
                        <label style="font-size:20px; font-weight:bold; padding-top:3%;">Daftar Akun Baru</label><br>
                        <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Bergabunglah dengan Ramos Badminton Center</p>
                        
                        <!-- Display Register Errors -->
                        @if($errors->has('register'))
                            <div class="alert alert-danger alert-custom">
                                {{ $errors->first('register') }}
                            </div>
                        @endif
                        
                        <!-- Name Input -->
                        <div style="position: relative;">
                            <input type="text" name="name" id="name" 
                                   placeholder="Nama Lengkap" 
                                   class="Register {{ $errors->has('name') ? 'input-error' : '' }}" 
                                   style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" 
                                   value="{{ old('name') }}" required>
                            @if($errors->has('name'))
                                <div class="error-message">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        
                        <!-- Email Input -->
                        <div style="position: relative;">
                            <input type="email" name="email" id="email" 
                                   placeholder="Email" 
                                   class="Register {{ $errors->has('email') ? 'input-error' : '' }}" 
                                   style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" 
                                   value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="error-message">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        
                        <!-- Phone Number Input -->
                        <div style="position: relative;">
                            <input type="tel" name="nomor_telepon" id="nomor_telepon" 
                                   placeholder="Nomor telepon" 
                                   class="Register {{ $errors->has('nomor_telepon') ? 'input-error' : '' }}" 
                                   style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" 
                                   value="{{ old('nomor_telepon') }}" required>
                            @if($errors->has('nomor_telepon'))
                                <div class="error-message">{{ $errors->first('nomor_telepon') }}</div>
                            @endif
                        </div>
                        
                        <!-- Password Input -->
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" 
                                   placeholder="Kata Sandi" 
                                   class="Register {{ $errors->has('password') ? 'input-error' : '' }}" 
                                   style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" required>
                            @if($errors->has('password'))
                                <div class="error-message">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        
                        <!-- Password Confirmation Input -->
                        <!-- <div style="position: relative;">
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   placeholder="Konfirmasi Kata Sandi" 
                                   class="Register {{ $errors->has('password_confirmation') ? 'input-error' : '' }}" 
                                   style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" required>
                            @if($errors->has('password_confirmation'))
                                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div> -->
                        
                        <button type="submit" class="btn-register">Daftar</button><br>
                        
                        <p style="font-size: 16px; margin-top: 15px;">Sudah punya akun?
                        <a href="{{ route('login') }}" style="text-decoration: none; color: #222F37; font-weight: bold;">Masuk di sini!</a>
                        </p>
                </center>
            </div>
         </form>
    </center>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Frontend Email Validation
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.classList.add('input-error');
            // Create or update error message
            let errorDiv = this.parentNode.querySelector('.error-message');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                this.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = 'Format email tidak valid. Contoh: user@example.com';
        } else {
            this.classList.remove('input-error');
            const errorDiv = this.parentNode.querySelector('.error-message');
            if (errorDiv && !errorDiv.textContent.includes('harus diisi')) {
                errorDiv.remove();
            }
        }
    });

    // Phone number validation
    document.getElementById('nomor_telepon').addEventListener('blur', function() {
        const phone = this.value;
        const phoneRegex = /^[0-9]{10,15}$/;
        
        if (phone && !phoneRegex.test(phone)) {
            this.classList.add('input-error');
            let errorDiv = this.parentNode.querySelector('.error-message');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                this.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = 'Nomor telepon harus berupa angka 10-15 digit';
        } else {
            this.classList.remove('input-error');
            const errorDiv = this.parentNode.querySelector('.error-message');
            if (errorDiv && !errorDiv.textContent.includes('harus diisi')) {
                errorDiv.remove();
            }
        }
    });

    // Password confirmation validation
    // document.getElementById('password_confirmation').addEventListener('blur', function() {
    //     const password = document.getElementById('password').value;
    //     const confirmPassword = this.value;
        
    //     if (confirmPassword && password !== confirmPassword) {
    //         this.classList.add('input-error');
    //         let errorDiv = this.parentNode.querySelector('.error-message');
    //         if (!errorDiv) {
    //             errorDiv = document.createElement('div');
    //             errorDiv.className = 'error-message';
    //             this.parentNode.appendChild(errorDiv);
    //         }
    //         errorDiv.textContent = 'Konfirmasi password tidak cocok';
    //     } else {
    //         this.classList.remove('input-error');
    //         const errorDiv = this.parentNode.querySelector('.error-message');
    //         if (errorDiv && !errorDiv.textContent.includes('harus diisi')) {
    //             errorDiv.remove();
    //         }
    //     }
    // });

    // Real-time validation removal when user starts typing
    ['name', 'email', 'nomor_telepon', 'password', 'password_confirmation'].forEach(function(fieldId) {
        document.getElementById(fieldId).addEventListener('input', function() {
            if (this.classList.contains('input-error') && this.value.trim() !== '') {
                this.classList.remove('input-error');
            }
        });
    });

    // Form submission validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('nomor_telepon').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9]{10,15}$/;
        
        let hasError = false;

        // Name validation
        if (!name || name.length < 3) {
            document.getElementById('name').classList.add('input-error');
            hasError = true;
        }

        // Email validation
        if (!email) {
            document.getElementById('email').classList.add('input-error');
            hasError = true;
        } else if (!emailRegex.test(email)) {
            document.getElementById('email').classList.add('input-error');
            hasError = true;
        }

        // Phone validation
        if (!phone) {
            document.getElementById('nomor_telepon').classList.add('input-error');
            hasError = true;
        } else if (!phoneRegex.test(phone)) {
            document.getElementById('nomor_telepon').classList.add('input-error');
            hasError = true;
        }

        // Password validation
        if (!password) {
            document.getElementById('password').classList.add('input-error');
            hasError = true;
        } else if (password.length < 6) {
            document.getElementById('password').classList.add('input-error');
            hasError = true;
        }

        // Password confirmation validation
        if (!confirmPassword) {
            document.getElementById('password_confirmation').classList.add('input-error');
            hasError = true;
        } else if (password !== confirmPassword) {
            document.getElementById('password_confirmation').classList.add('input-error');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
</script>
    </body>
</HTML>