<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="images/logo.jpg" alt="Logo" class="header-logo">
            Ramos Badminton Center
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Link menu utama -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('tentang') ? 'active' : '' }}" href="/tentang">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('jadwal') ? 'active' : '' }}" href="/jadwal">Jadwal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('reservasi') ? 'active' : '' }}" href="/reservasi">Reservasi</a>
                </li>
                <li class="nav-item">
                <a class="nav-link {{ Request::is('mabar', 'detail_mabar', 'tambahMabar') ? 'active' : '' }}" href="/mabar">Mabar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('event') ? 'active' : '' }}" href="/event">Event</a>
                </li>
            </ul>

            <!-- Bagian Login/Logout -->
          <!-- Bagian Login/Logout -->
<!-- Bagian Login/Logout -->
<ul class="navbar-nav ms-3">
    @if (!Session::get('jwt'))
        <li class="nav-item">
            <a class="btn btn-outline-primary" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
        </li>
    @else
        <li class="nav-item dropdown d-flex align-items-center text-white">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <?php
// Ambil nama lengkap dari session
$name = Session::get('user_data')['name'];

// Pecah nama berdasarkan spasi
$name_parts = explode(' ', $name);

// Ambil kata pertama dan kata terakhir
$first_name = $name_parts[0];
$last_name = end($name_parts); // Ambil kata terakhir

// Gabungkan kembali kata pertama dan kata terakhir
$short_name = $first_name . ' ' . $last_name;
?>

                <span>
                <label>{{ $short_name }}</label>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profil') }}">Profile</a></li>
                <li>
                    <!-- Link logout yang mengarah ke controller -->
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </li>
    @endif
</ul>



        </div>
    </div>
</nav>
