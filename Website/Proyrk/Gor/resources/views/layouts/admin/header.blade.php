<!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #002f53" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
<div class="sidebar-brand-icon">
    {{-- <i class="fas fa-table-tennis"></i> <!-- mirip raket tenis --> --}}
    <i class="fas fa-user"></i>
    {{-- <i class="fas fa-badminton"></i> --}}
</div>

                <div class="sidebar-brand-text mx-3">GOR Ramos <sup>Badminton</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                Interface
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li> --}}

            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li> --}}

            <!-- Divider -->
            {{-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            <div class="sidebar-heading">
                
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li> --}}

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ Request::is(patterns: 'admin/daftar-pelanggan') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('admin.daftar-pelanggan')}}">
                <i class="fas fa-receipt" style="color: gray;"></i> <!-- Oranye -->
                    <span>Catatan Transaksi</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ Request::is(patterns: 'admin/lapangan') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('admin.lapangan.index')}}">
                    <i class="fas fa-futbol text-gray"></i>
                    <span>Lapangan</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ Request::is(patterns: 'admin/jadwal') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.jadwal')}}">
                    <i class="fas fa-calendar-alt text-gray"></i>
                    <span>Jadwal</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ Request::is(patterns: 'admin/jadwal-rutin-harian') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.jadwal-rutin-harian.index')}}">
                    <i class="fas fa-clock text-gray"></i>
                    <span>Jadwal Rutin Harian</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ Request::is(patterns: 'admin/kelola/pemesanan/index') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.kelola.pemesanan.index')}}">
                    <i class="fas fa-shopping-cart text-gray"></i>
                    <span>Pemesanan</span></a>
            </li>

            <li class="nav-item {{ Request::is(patterns: 'admin/events') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.events')}}">
                    <i class="fas fa-calendar-check text-gray"></i>
                    <span>Events</span></a>
            </li>

            <li class="nav-item {{ Request::is(patterns: 'admin/tentang') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/tentang">
                    <i class="fas fa-info-circle text-gray"></i>
                    <span>Tentang</span></a>
            </li>

            <li class="nav-item {{ Request::is(patterns: 'admin/info-kontak') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.info-kontak.index')}}">
                    <i class="fas fa-phone-alt text-gray"></i>
                    <span>Info Kontak</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            {{-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> --}}

        </ul>
        <!-- End of Sidebar -->