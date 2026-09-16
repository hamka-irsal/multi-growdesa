@php
    // ==========================================================
    // Helper untuk menandai menu & dropdown yang sedang aktif
    // ==========================================================

    // Profil Desa
    $isProfilActive = request()->routeIs(['admin.profil-desa.*', 'admin.dusun.*']);

    // Surat
    $isSuratActive = request()->routeIs(['admin.surat.*', 'admin.persetujuan.*']);

    // Berita Desa
    $isBeritaActive = request()->routeIs(['admin.berita.*', 'admin.kategori-berita.*']);

    // User
    $isUserActive = request()->routeIs(['admin.user.*', 'admin.verifikasi.*']);

    // Dusun
    $isDusunActive = request()->routeIs(['admin.dusun.*']);
@endphp


<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><b></b>GrowDesa | GalTim</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">
                <img src="{{ asset('assets/img/logo_gd.jpeg') }}" alt="GrowDesa"
                    style="width: 32px; height: 32px; object-fit: contain;">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="{{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                    <i class="fas fa-fire"></i>
                    <span><b>Dashboard</b></span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.penduduk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.penduduk.index') }}">
                    <i class="fas fa-users"></i>
                    <span><b>Penduduk</b></span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.iklan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.iklan.index') }}">
                    <i class="fas fa-bullhorn"></i>
                    <span><b>Iklan</b></span>
                </a>
            </li>

            <li class="menu-header">Layanan Desa</li>

            <li class="dropdown {{ $isProfilActive ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-landmark"></i>
                    <span><b>Profil Desa</b></span>
                </a>

                <ul class="dropdown-menu" style="{{ $isProfilActive ? 'display:block;' : '' }}">

                    {{-- Data Profil --}}
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.profil-desa.*') ? 'active' : '' }}"
                            href="{{ route('admin.profil-desa.index') }}">
                            <i class="fas fa-info-circle"></i>
                            Data Profil
                        </a>
                    </li>

                    {{-- Data Dusun --}}
                    <li>
                        <a class="nav-link {{ $isDusunActive ? 'active' : '' }}"
                            href="{{ route('admin.dusun.index') }}">
                            <i class="fas fa-map-marker-alt"></i>
                            Data Dusun
                        </a>
                    </li>
                </ul>
            </li>


            <li class="dropdown {{ $isSuratActive ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="far fa-file-alt"></i>
                    <span><b>Surat</b></span>
                </a>

                <ul class="dropdown-menu" style="{{ $isSuratActive ? 'display:block;' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.surat.pengajuan') ? 'active' : '' }}"
                            href="{{ route('admin.surat.pengajuan') }}">
                            <i class="fas fa-paper-plane"></i>
                            Pengajuan Surat
                        </a>
                    </li>

                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.surat.manajemen') ? 'active' : '' }}"
                            href="{{ route('admin.surat.manajemen') }}">
                            <i class="fas fa-folder-open"></i>
                            Manajemen Surat
                        </a>
                    </li>

                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.persetujuan.*') ? 'active' : '' }}"
                            href="{{ route('admin.persetujuan.index') }}">
                            <i class="fas fa-signature"></i>
                            TTD Surat
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ $isBeritaActive ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-info"></i>
                    <span><b>Berita Desa</b></span>
                </a>

                <ul class="dropdown-menu" style="{{ $isBeritaActive ? 'display:block;' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"
                            href="{{ route('admin.berita.index') }}">
                            <i class="fas fa-newspaper"></i>
                            <span>Data Berita</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.kategori-berita.*') ? 'active' : '' }}"
                            href="{{ route('admin.kategori-berita.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Kategori Berita</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- APBDes --}}
            <li class="{{ request()->routeIs('admin.apbdes.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.apbdes.index') }}">
                    <i class="fas fa-chart-pie"></i>
                    <span><b>APBDes</b></span>
                </a>
            </li>

            {{-- Produk Desa --}}
            <li class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.produk.index') }}">
                    <i class="fas fa-cart-plus"></i>
                    <span><b>Produk Desa</b></span>
                </a>
            </li>
            <li class="menu-header">Aparat</li>
            <li class="{{ request()->routeIs('admin.aparat.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.aparat.index') }}"><i class="fas fa-user"></i>
                    <span><b>Aparat Desa</b></span></a>
            </li>
            <li class="menu-header">Pengguna</li>
            <li class="dropdown {{ $isUserActive ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="far fa-user"></i>
                    <span><b>User</b></span>
                </a>

                <ul class="dropdown-menu" style="{{ $isUserActive ? 'display:block;' : '' }}">

                    {{-- Data Operator --}}
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
                            href="{{ route('admin.user.index') }}">
                            <i class="fas fa-users-cog"></i>
                            Operator
                        </a>
                    </li>


                    {{-- Verifikasi Penduduk --}}
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}"
                            href="{{ route('admin.verifikasi.index') }}">
                            <i class="fas fa-user-check"></i>
                            Verifikasi Penduduk
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </aside>
</div>

<style>
    /* ==========================================================
       TEKS & IKON MENU UTAMA — diperbesar sedikit
       ========================================================== */

    .main-sidebar .sidebar-menu a.nav-link span {
        font-size: 16px;
        color: #1a1a1a !important;
        font-weight: 600;
        transition: color .15s ease;
    }

    .main-sidebar .sidebar-menu a.nav-link span b {
        font-weight: 600;
        color: inherit !important;
    }

    .main-sidebar .sidebar-menu a.nav-link i {
        font-size: 19px;
        color: #1a1a1a !important;
        margin-right: 10px;
        width: 22px;
        text-align: center;
        transition: color .15s ease;
    }

    .main-sidebar .sidebar-menu li.menu-header {
        font-size: 13.5px;
        font-weight: 700;
        color: #2b2b2b !important;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    /* ==========================================================
       SUBMENU (dropdown)
       ========================================================== */

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link {
        font-size: 14.5px;
        color: #1a1a1a !important;
        padding-left: 35px !important;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: color .15s ease, background-color .15s ease;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link i {
        font-size: 15px;
        color: #1a1a1a !important;
        margin-right: 8px;
        width: 18px;
        text-align: center;
    }

    /* Submenu tetap terbuka saat salah satu itemnya aktif */
    .main-sidebar .sidebar-menu li.dropdown.active>.dropdown-menu {
        display: block;
    }

    /* ==========================================================
       HOVER
       ========================================================== */

    .main-sidebar .sidebar-menu li:not(.active)>a.nav-link:hover span,
    .main-sidebar .sidebar-menu li:not(.active)>a.nav-link:hover i {
        color: #2E7D32 !important;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link:not(.active):hover {
        color: #2E7D32 !important;
        background-color: rgba(46, 125, 50, .06);
    }

    /* ==========================================================
       STATE AKTIF — hijau #2E7D32, tetap menyala di halaman itu
       ========================================================== */

    .main-sidebar .sidebar-menu>li.active {
        background-color: rgba(46, 125, 50, .08);
        border-radius: 8px;
    }

    .main-sidebar .sidebar-menu>li.active:not(.dropdown)>a.nav-link {
        position: relative;
    }

    .main-sidebar .sidebar-menu>li.active:not(.dropdown)>a.nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 8px;
        bottom: 8px;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: #2E7D32;
    }

    .main-sidebar .sidebar-menu>li.active>a.nav-link span,
    .main-sidebar .sidebar-menu>li.active>a.nav-link span b,
    .main-sidebar .sidebar-menu>li.active>a.nav-link i {
        color: #2E7D32 !important;
        font-weight: 700;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link.active {
        color: #2E7D32 !important;
        font-weight: 700;
        background-color: rgba(46, 125, 50, .08);
        border-radius: 8px;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link.active i {
        color: #2E7D32 !important;
    }

    /* ==========================================================
       TRANSPARANSI IKON — hilangkan kotak/chip warna di belakang ikon
       (termasuk saat mode collapsed / sidebar-mini & state aktif)
       ========================================================== */

    .main-sidebar .sidebar-menu a.nav-link,
    .main-sidebar .sidebar-menu a.nav-link i,
    .main-sidebar .sidebar-menu li a.nav-link:hover,
    .main-sidebar .sidebar-menu li a.nav-link:focus,
    .main-sidebar .sidebar-menu li.active>a.nav-link,
    .main-sidebar .sidebar-menu li.active>a.nav-link i,
    .main-sidebar .sidebar-menu li.active>a.nav-link:hover,
    .main-sidebar .sidebar-menu a.nav-link.active,
    .main-sidebar .sidebar-menu a.nav-link.active i {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
        box-shadow: none !important;
    }

    /* ==========================================================
       FLYOUT SUBMENU — muncul saat sidebar mode mini/ciut (icon-only)
       (di sini biasanya masih tersisa warna biru bawaan tema)
       ========================================================== */

    .main-sidebar .sidebar-menu li,
    .main-sidebar .sidebar-menu li:hover,
    .main-sidebar .sidebar-menu li.dropdown,
    .main-sidebar .sidebar-menu li.dropdown:hover,
    .main-sidebar .sidebar-menu li.dropdown:focus,
    .main-sidebar .sidebar-menu li.dropdown.active,
    .main-sidebar .sidebar-menu .dropdown-menu li,
    .main-sidebar .sidebar-menu .dropdown-menu li:hover,
    .main-sidebar .sidebar-menu .dropdown-menu li:focus {
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .main-sidebar .sidebar-menu li.dropdown:hover>a.nav-link,
    .main-sidebar .sidebar-menu li.dropdown:focus>a.nav-link,
    .main-sidebar .sidebar-menu li.dropdown>a.nav-link:hover,
    .main-sidebar .sidebar-menu li.dropdown>a.nav-link:focus {
        background: transparent !important;
        color: #2E7D32 !important;
    }

    .main-sidebar .sidebar-menu li.dropdown:hover>a.nav-link i,
    .main-sidebar .sidebar-menu li.dropdown:focus>a.nav-link i,
    .main-sidebar .sidebar-menu li.dropdown>a.nav-link:hover i,
    .main-sidebar .sidebar-menu li.dropdown>a.nav-link:focus i {
        color: #2E7D32 !important;
    }

    /* Panel flyout-nya sendiri: latar putih bersih, bukan biru */
    .main-sidebar .sidebar-menu li.dropdown:hover>.dropdown-menu,
    .main-sidebar .sidebar-menu li.dropdown:focus>.dropdown-menu,
    .main-sidebar .sidebar-menu .dropdown-menu {
        background: #ffffff !important;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link:not(.active) {
        background: transparent !important;
        color: #1a1a1a !important;
    }

    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link:hover,
    .main-sidebar .sidebar-menu .dropdown-menu a.nav-link:focus {
        background: rgba(46, 125, 50, .08) !important;
        color: #2E7D32 !important;
    }

    /* ==========================================================
       OVERRIDE BAWAAN TEMA — flyout submenu saat sidebar-mini
       (selector persis dari style.css milik tema)
       ========================================================== */

    body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li>a:focus,
    body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a,
    body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #2E7D32 !important;
        background-color: rgba(46, 125, 50, 0.15) !important;
    }
</style>
