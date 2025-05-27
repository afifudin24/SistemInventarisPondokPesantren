<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">

                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small text-capitalize">{{ Auth::user()->role }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link " href="index.html">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        @if (Auth::user()->role == 'admin')
            <li class="nav-item {{ Request::is('datauser') ? 'active' : '' }}">
                <a class="nav-link " href="/datauser">
                    <span class="menu-title">Data User</span>
                    <i class="mdi mdi-account menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ Request::is('databarang') ? 'active' : '' }}">
                <a class="nav-link " href="/databarang">
                    <span class="menu-title">Data Barang</span>
                    <i class="mdi mdi-package-variant menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ Request::is('transaksibarang') ? 'active' : '' }}">
                <a class="nav-link " href="/transaksibarang">
                    <span class="menu-title">Transaksi Barang</span>
                    <i class="mdi mdi-swap-horizontal menu-icon"></i>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-start w-100" style="text-decoration: none;">
                    <span class="menu-title">Logout</span>
                    <i class="mdi mdi-logout menu-icon"></i>
                </button>
            </form>
        </li>

    </ul>
</nav>
<!-- partial -->
