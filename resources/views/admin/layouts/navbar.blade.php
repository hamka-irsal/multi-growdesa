<style>
    /* ==========================================================
   NOTIFICATION BUTTON
   ========================================================== */

    .notification-toggle {
        position: relative !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }


    /*
|--------------------------------------------------------------------------
| Hilangkan pseudo element bawaan template
|--------------------------------------------------------------------------
*/

    .notification-toggle::before,
    .notification-toggle::after {
        content: none !important;
        display: none !important;
    }


    /*
|--------------------------------------------------------------------------
| Ikon Bell
|--------------------------------------------------------------------------
*/

    .notification-toggle .fa-bell {
        font-size: 24px;
        line-height: 1;
    }


    /*
|--------------------------------------------------------------------------
| Badge Notifikasi
|--------------------------------------------------------------------------
*/

    .notification-badge-custom {
        position: absolute !important;

        top: 3px !important;
        right: 2px !important;

        display: none;

        min-width: 22px !important;
        height: 22px !important;

        padding: 0 5px !important;

        background: #ff4d4f !important;
        color: #fff !important;

        border: 2px solid #6675e8 !important;

        border-radius: 50% !important;

        font-size: 13px !important;
        font-weight: 600 !important;

        line-height: 18px !important;
        text-align: center !important;

        z-index: 20 !important;

        box-sizing: border-box !important;

        pointer-events: none !important;
    }


    /*
|--------------------------------------------------------------------------
| Hilangkan pseudo element dari badge
|--------------------------------------------------------------------------
*/

    .notification-badge-custom::before,
    .notification-badge-custom::after {
        content: none !important;
        display: none !important;
    }


    /* ==========================================================
   PERBESAR TEKS DROPDOWN (NOTIFIKASI & AKUN)
   ========================================================== */

    .notification-dropdown .dropdown-menu,
    .navbar-right .dropdown .dropdown-menu {
        font-size: 15px;
    }

    .dropdown-title {
        font-size: 16px;
    }

    .dropdown-title .font-weight-bold {
        font-size: 16px;
    }

    .dropdown-title small.text-muted {
        font-size: 13px;
    }

    #notification-total-text.badge-primary {
        font-size: 13px;
    }

    #notification-loading .small {
        font-size: 14.5px;
    }

    #notification-empty i,
    #notification-error i {
        font-size: 32px !important;
    }

    #notification-empty .text-muted,
    #notification-error .text-muted {
        font-size: 15px;
    }

    .nav-link-user .d-lg-inline-block {
        font-size: 15.5px;
    }

    .dropdown-menu .dropdown-item.has-icon {
        font-size: 15px;
    }

    .dropdown-menu .dropdown-item.has-icon i {
        font-size: 16px;
    }

    /* ==========================================================
   MATIKAN TRANSISI SESAAT SAAT STATE SIDEBAR DIPULIHKAN
   (mencegah "kedipan" sidebar terbuka lalu tertutup saat reload)
   ========================================================== */

    body.sidebar-notransition,
    body.sidebar-notransition .main-sidebar,
    body.sidebar-notransition #main-content,
    body.sidebar-notransition .navbar {
        transition: none !important;
    }
</style>
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">

    {{-- ====================================================================== --}}
    {{-- SIDEBAR --}}
    {{-- ====================================================================== --}}

    <div class="mr-auto">
        <ul class="navbar-nav">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </div>


    @php
        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | FOTO USER
        |--------------------------------------------------------------------------
        |
        | Foto diambil dari tabel penduduk.
        |
        | Relasi:
        |
        | users
        |   ↓
        | penduduk
        |   ↓
        | foto
        |
        */

        $fotoUser = asset('assets/img/avatar/avatar-1.png');

        if ($user && $user->penduduk && !empty($user->penduduk->foto)) {
            $fotoUser = asset('storage/' . ltrim($user->penduduk->foto, '/'));
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE USER
        |--------------------------------------------------------------------------
        */

        $roleUser = $user ? ucfirst($user->role) : '';
    @endphp


    {{-- ====================================================================== --}}
    {{-- NOTIFIKASI & USER --}}
    {{-- ====================================================================== --}}

    <ul class="navbar-nav navbar-right">

        {{-- ================================================================== --}}
        {{-- NOTIFIKASI --}}
        {{-- ================================================================== --}}

        <li class="dropdown notification-dropdown">

            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle"
                style="position: relative;">

                <i class="far fa-bell"></i>

                <span id="notification-badge" class="notification-badge-custom" style="display: none;">
                    0
                </span>

            </a>


            <div class="dropdown-menu dropdown-menu-right dropdown-menu-large"
                style="
                    width: 380px;
                    max-height: 500px;
                    overflow-y: auto;
                ">

                <div class="dropdown-title d-flex justify-content-between align-items-center">

                    <span>
                        Notifikasi
                    </span>

                    <span id="notification-total-text" class="badge badge-primary" style="display: none;">
                        0
                    </span>

                </div>


                <div id="notification-loading" class="text-center py-4">

                    <div class="spinner-border spinner-border-sm text-primary"></div>

                    <div class="small text-muted mt-2">
                        Memuat notifikasi...
                    </div>

                </div>


                <div id="notification-list"></div>


                <div id="notification-empty" class="text-center py-4" style="display: none;">

                    <i class="far fa-bell-slash text-muted" style="font-size: 30px;"></i>

                    <div class="text-muted mt-2">
                        Tidak ada notifikasi baru.
                    </div>

                </div>


                <div id="notification-error" class="text-center py-4" style="display: none;">

                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 25px;"></i>

                    <div class="text-muted mt-2">
                        Gagal memuat notifikasi.
                    </div>

                </div>

            </div>

        </li>


        {{-- ================================================================== --}}
        {{-- USER --}}
        {{-- ================================================================== --}}

        <li class="dropdown">

            {{-- Tombol User --}}
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <img alt="{{ $user->name ?? 'User' }}" src="{{ $fotoUser }}" class="rounded-circle mr-1"
                    style="
                        width: 40px;
                        height: 40px;
                        object-fit: cover;
                    ">


                <div class="d-sm-none d-lg-inline-block">
                    {{ $user->name ?? 'User' }}
                </div>

            </a>


            {{-- Dropdown User --}}
            <div class="dropdown-menu dropdown-menu-right">

                {{-- Informasi User --}}
                <div class="dropdown-title">

                    <div class="font-weight-bold">
                        {{ $user->name ?? 'User' }}
                    </div>

                    <small class="text-muted">
                        {{ $roleUser }}
                    </small>

                </div>


                {{-- Profile --}}
                <a href="#" class="dropdown-item has-icon">

                    <i class="far fa-user"></i>

                    Profile

                </a>


                {{-- Pengaturan --}}
                <a href="#" class="dropdown-item has-icon">

                    <i class="fas fa-cog"></i>

                    Settings

                </a>


                <div class="dropdown-divider"></div>


                {{-- Logout --}}
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">

                    <i class="fas fa-sign-out-alt"></i>

                    Logout

                </a>

            </div>

        </li>

    </ul>


    {{-- ====================================================================== --}}
    {{-- SIDEBAR TOGGLE — INGAT STATE (STAY) ANTAR HALAMAN --}}
    {{-- ====================================================================== --}}

    <script>
        (function() {

            const STORAGE_KEY = 'gd_sidebar_collapsed';

            let isRestoring = false;

            /*
            |--------------------------------------------------------------------------
            | Simpan status HANYA untuk klik manual (bukan klik hasil restore)
            |--------------------------------------------------------------------------
            */

            document.addEventListener('DOMContentLoaded', function() {

                const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');

                if (!sidebarToggle) {
                    return;
                }

                sidebarToggle.addEventListener('click', function() {

                    if (isRestoring) {
                        return; // abaikan klik hasil restore otomatis
                    }

                    const current = localStorage.getItem(STORAGE_KEY) === '1' ? '1' : '0';

                    const next = current === '1' ? '0' : '1';

                    localStorage.setItem(STORAGE_KEY, next);

                });

            });

            /*
            |--------------------------------------------------------------------------
            | Pulihkan status tersimpan — ditunda sampai window 'load' supaya
            | script tema (stisla.js) yang memasang event click pada tombol
            | toggle sudah pasti siap lebih dulu.
            |--------------------------------------------------------------------------
            */

            window.addEventListener('load', function() {

                const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');

                if (!sidebarToggle) {
                    return;
                }

                if (localStorage.getItem(STORAGE_KEY) === '1') {

                    document.body.classList.add('sidebar-notransition');

                    isRestoring = true;

                    sidebarToggle.click();

                    isRestoring = false;

                    requestAnimationFrame(function() {
                        requestAnimationFrame(function() {
                            document.body.classList.remove('sidebar-notransition');
                        });
                    });

                }

            });

        })();
    </script>


    {{-- ====================================================================== --}}
    {{-- JAVASCRIPT NOTIFIKASI --}}
    {{-- ====================================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | URL
            |--------------------------------------------------------------------------
            */

            const notificationCountUrl =
                "{{ route('admin.notif.count') }}";

            const notificationLatestUrl =
                "{{ route('admin.notif.latest') }}";


            /*
            |--------------------------------------------------------------------------
            | Element
            |--------------------------------------------------------------------------
            */

            const badge =
                document.getElementById(
                    'notification-badge'
                );

            const totalText =
                document.getElementById(
                    'notification-total-text'
                );

            const notificationList =
                document.getElementById(
                    'notification-list'
                );

            const loading =
                document.getElementById(
                    'notification-loading'
                );

            const empty =
                document.getElementById(
                    'notification-empty'
                );

            const error =
                document.getElementById(
                    'notification-error'
                );


            /*
            |--------------------------------------------------------------------------
            | Format Waktu
            |--------------------------------------------------------------------------
            */

            function formatWaktu(dateString) {

                if (!dateString) {
                    return '';
                }

                const date =
                    new Date(dateString);

                if (isNaN(date.getTime())) {
                    return '';
                }

                const sekarang =
                    new Date();

                const selisih =
                    Math.floor(
                        (sekarang - date) / 1000
                    );


                if (selisih < 60) {

                    return 'Baru saja';

                }


                if (selisih < 3600) {

                    const menit =
                        Math.floor(
                            selisih / 60
                        );

                    return menit +
                        ' menit yang lalu';

                }


                if (selisih < 86400) {

                    const jam =
                        Math.floor(
                            selisih / 3600
                        );

                    return jam +
                        ' jam yang lalu';

                }


                if (selisih < 604800) {

                    const hari =
                        Math.floor(
                            selisih / 86400
                        );

                    return hari +
                        ' hari yang lalu';

                }


                return date.toLocaleDateString(
                    'id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Escape HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(text) {

                if (
                    text === null ||
                    text === undefined
                ) {

                    return '';

                }


                return String(text)
                    .replace(
                        /&/g,
                        '&amp;'
                    )
                    .replace(
                        /</g,
                        '&lt;'
                    )
                    .replace(
                        />/g,
                        '&gt;'
                    )
                    .replace(
                        /"/g,
                        '&quot;'
                    )
                    .replace(
                        /'/g,
                        '&#039;'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Load Jumlah Notifikasi
            |--------------------------------------------------------------------------
            */

            function loadNotificationCount() {

                fetch(
                        notificationCountUrl, {
                            method: 'GET',

                            headers: {
                                'Accept': 'application/json',

                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    )
                    .then(function(response) {

                        if (!response.ok) {

                            throw new Error(
                                'Gagal mengambil jumlah notifikasi.'
                            );

                        }

                        return response.json();

                    })
                    .then(function(response) {

                        if (
                            !response.success ||
                            !response.data
                        ) {

                            return;

                        }


                        const total =
                            Number(
                                response.data.total || 0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Badge
                        |--------------------------------------------------------------------------
                        */

                        if (total > 0) {

                            badge.textContent =
                                total > 99 ?
                                '99+' :
                                total;

                            badge.style.display =
                                'inline-block';

                        } else {

                            badge.style.display =
                                'none';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Total Header
                        |--------------------------------------------------------------------------
                        */

                        if (total > 0) {

                            totalText.textContent =
                                total;

                            totalText.style.display =
                                'inline-block';

                        } else {

                            totalText.style.display =
                                'none';

                        }

                    })
                    .catch(function(err) {

                        console.error(
                            'Notification count error:',
                            err
                        );

                    });
            }


            /*
            |--------------------------------------------------------------------------
            | Load Notifikasi Terbaru
            |--------------------------------------------------------------------------
            */

            function loadLatestNotifications() {

                loading.style.display =
                    'block';

                empty.style.display =
                    'none';

                error.style.display =
                    'none';

                notificationList.innerHTML =
                    '';


                fetch(
                        notificationLatestUrl, {
                            method: 'GET',

                            headers: {
                                'Accept': 'application/json',

                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    )
                    .then(function(response) {

                        if (!response.ok) {

                            throw new Error(
                                'Gagal mengambil notifikasi.'
                            );

                        }

                        return response.json();

                    })
                    .then(function(response) {

                        loading.style.display =
                            'none';


                        if (
                            !response.success ||
                            !response.data ||
                            response.data.length === 0
                        ) {

                            empty.style.display =
                                'block';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Render Notifikasi
                        |--------------------------------------------------------------------------
                        */

                        response.data.forEach(
                            function(item) {

                                const icon =
                                    item.icon ||
                                    'far fa-bell';


                                const warna =
                                    item.warna ||
                                    'primary';


                                const judul =
                                    escapeHtml(
                                        item.judul ||
                                        'Notifikasi'
                                    );


                                const pesan =
                                    escapeHtml(
                                        item.pesan ||
                                        ''
                                    );


                                const aksi =
                                    escapeHtml(
                                        item.aksi ||
                                        'Lihat'
                                    );


                                const waktu =
                                    formatWaktu(
                                        item.created_at
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | Element
                                |--------------------------------------------------------------------------
                                */

                                const element =
                                    document.createElement(
                                        'a'
                                    );


                                element.href =
                                    item.url || '#';


                                element.className =
                                    'dropdown-item has-icon';


                                element.style =
                                    'white-space: normal;';


                                /*
                                |--------------------------------------------------------------------------
                                | HTML
                                |--------------------------------------------------------------------------
                                */

                                element.innerHTML = `

                                    <div class="d-flex w-100">

                                        <div
                                            class="mr-3 text-${warna}"
                                            style="
                                                width: 35px;
                                                min-width: 35px;
                                                text-align: center;
                                            "
                                        >

                                            <i
                                                class="${icon}"
                                                style="
                                                    font-size: 20px;
                                                "
                                            ></i>

                                        </div>


                                        <div
                                            class="flex-grow-1"
                                            style="
                                                min-width: 0;
                                            "
                                        >

                                            <div
                                                class="font-weight-bold"
                                                style="
                                                    font-size: 15px;
                                                "
                                            >
                                                ${judul}
                                            </div>


                                            <div
                                                class="text-muted"
                                                style="
                                                    font-size: 14px;
                                                    margin-top: 3px;
                                                "
                                            >
                                                ${pesan}
                                            </div>


                                            <div
                                                class="d-flex justify-content-between align-items-center"
                                                style="
                                                    margin-top: 6px;
                                                "
                                            >

                                                <small
                                                    class="text-muted"
                                                    style="font-size: 13px;"
                                                >
                                                    ${waktu}
                                                </small>


                                                <small
                                                    class="text-${warna}"
                                                    style="
                                                        font-weight: 600;
                                                        font-size: 13px;
                                                    "
                                                >
                                                    ${aksi}
                                                </small>

                                            </div>

                                        </div>

                                    </div>

                                `;


                                notificationList.appendChild(
                                    element
                                );

                            }
                        );

                    })
                    .catch(function(err) {

                        console.error(
                            'Notification latest error:',
                            err
                        );


                        loading.style.display =
                            'none';

                        error.style.display =
                            'block';

                    });
            }


            /*
            |--------------------------------------------------------------------------
            | Jalankan Saat Halaman Dibuka
            |--------------------------------------------------------------------------
            */

            loadNotificationCount();


            /*
            |--------------------------------------------------------------------------
            | Ketika Dropdown Dibuka
            |--------------------------------------------------------------------------
            */

            $('.notification-toggle').on(
                'click',
                function() {

                    loadLatestNotifications();

                    loadNotificationCount();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Refresh Badge Setiap 30 Detik
            |--------------------------------------------------------------------------
            */

            setInterval(
                function() {

                    loadNotificationCount();

                },
                30000
            );

        });
    </script>

</nav>
