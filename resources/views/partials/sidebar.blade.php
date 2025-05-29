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
            <a class="nav-link " href="/dashboard">
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

        @if(Auth::user()->role == 'pengurus')
              <li class="nav-item {{ Request::is('databarang') ? 'active' : '' }}">
            <a class="nav-link " href="/databarang">
                <span class="menu-title">Data Inventaris Barang</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
            </a>
        </li>
              <li class="nav-item {{ Request::is('verifikasipeminjamanbarang') ? 'active' : '' }}">
            <a class="nav-link " href="/verifikasipeminjamanbarang">
                <span class="menu-title">Verifikasi Peminjaman Barang</span>
                <i class="mdi mdi-check menu-icon"></i>
            </a>
        </li>
              <li class="nav-item {{ Request::is('konfirmasipengembalianbarang') ? 'active' : '' }}">
            <a class="nav-link " href="/konfirmasipengembalianbarang">
                <span class="menu-title">Konfirmasi Pengembalian Barang</span>
                <i class="mdi mdi-restore menu-icon"></i>
            </a>
        </li>
              <li class="nav-item {{ Request::is('catatankondisibarang') ? 'active' : '' }}">
            <a class="nav-link " href="/catatankondisibarang">
                <span class="menu-title">Catatan Kondisi Barang</span>
                <i class="mdi mdi-note-outline menu-icon"></i>
            </a>
        </li>
        @endif
        @if(Auth::user()->role == 'peminjam')
         <li class="nav-item {{ Request::is('databarang') ? 'active' : '' }}">
            <a class="nav-link " href="/databarang">
                <span class="menu-title">Data Inventaris Barang</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
            </a>
        </li>
         <li class="nav-item {{ Request::is('riwayatpeminjamanbarang') ? 'active' : '' }}">
            <a class="nav-link " href="/riwayatpeminjamanbarang">
                <span class="menu-title">Riwayat Peminjaman Barang</span>
                <i class="mdi mdi-history menu-icon"></i>
            </a>
        </li>
         <li class="nav-item {{ Request::is('ajuanpeminjamanbarang') ? 'active' : '' }}">
            <a class="nav-link " href="/ajuanpeminjamanbarang">
                <span class="menu-title">Ajuan Peminjaman Barang</span>
                <i class="mdi mdi-file-document menu-icon"></i>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a href="#" class="nav-link" style="text-decoration: none;"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-logout menu-icon"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>
<!-- partial -->