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
    <a class="nav-link {{ Request::is('event') ? 'active' : '' }}" href="/event">Event</a>
</li>

            </ul>
            <ul class="navbar-nav ms-3">
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-circle fs-5"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
