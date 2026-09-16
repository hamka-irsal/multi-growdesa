<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Anjungan Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#eef2f7',
                            100: '#d7e0ec',
                            500: '#2a4a73',
                            600: '#1f3a5e',
                            700: '#1b3350',
                            800: '#152841',
                            900: '#0f1d2e',
                        },
                        gold: {
                            300: '#e6cd7c',
                            400: '#d9b64a',
                            500: '#c9a227',
                            600: '#a9841c',
                        },
                    },
                    fontFamily: {
                        display: ['"Fraunces"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="/manifest.json">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .tablet-fullscreen {
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }

        /* Background pengganti gambar: gradasi navy khas identitas anjungan
           + pancaran cahaya lembut + motif titik "kawung" + cincin stempel raksasa */
        .kiosk-bg {
            background-color: #14283f;
            background-image:
                radial-gradient(circle at 18% 20%, rgba(217, 182, 74, 0.16), transparent 40%),
                radial-gradient(circle at 85% 78%, rgba(42, 74, 115, 0.55), transparent 45%),
                radial-gradient(circle at 12px 12px, rgba(255, 255, 255, 0.05) 3px, transparent 3.5px),
                radial-gradient(circle at 32px 32px, rgba(255, 255, 255, 0.05) 3px, transparent 3.5px),
                linear-gradient(160deg, #1b3350 0%, #10203350 45%, #0f1d2e 100%);
            background-size: auto, auto, 44px 44px, 44px 44px, cover;
        }

        .kiosk-bg::before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            width: min(1100px, 140vw);
            height: min(1100px, 140vw);
            transform: translate(-50%, -50%);
            border-radius: 9999px;
            border: 1.5px dashed rgba(201, 162, 39, 0.14);
            pointer-events: none;
        }

        .kiosk-bg::after {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            width: min(880px, 110vw);
            height: min(880px, 110vw);
            transform: translate(-50%, -50%);
            border-radius: 9999px;
            border: 1px solid rgba(201, 162, 39, 0.10);
            pointer-events: none;
        }

        @media (min-width: 768px) and (max-width: 1200px) {
            .tablet-card {
                min-height: 200px;
            }

            .tablet-icon {
                width: 80px;
                height: 80px;
            }
        }

        .tablet-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        }

        .tablet-card:active {
            transform: scale(0.98);
        }

        @media (prefers-reduced-motion: reduce) {
            .tablet-card {
                transition: none;
            }
        }

        #fullscreen-button {
            position: fixed;
            top: 14px;
            right: 14px;
            z-index: 9999;
            background-color: rgba(15, 29, 46, 0.55);
            color: #e6cd7c;
            border: 1px solid rgba(201, 162, 39, 0.35);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid #c9a227;
            outline-offset: 2px;
        }
    </style>
</head>

<body class="tablet-fullscreen kiosk-bg relative overflow-hidden">
    <button id="fullscreen-button" class="md:text-base">Masuk Mode Layar Penuh</button>

    <div class="tablet-fullscreen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-10">
                <div
                    class="mx-auto mb-5 h-16 w-16 md:h-20 md:w-20 rounded-full bg-navy-800/70 border border-gold-500/40 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-9 md:w-9 text-gold-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-gold-400 text-xs md:text-sm font-semibold tracking-[0.2em] uppercase mb-2">Layanan
                    Mandiri Kependudukan</p>
                <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-white leading-tight">
                    Selamat Datang di Anjungan Surat<br class="hidden md:block"> Desa Galesong Timur
                </h1>
                <p class="text-navy-100/80 text-lg md:text-xl mt-3">Silakan pilih layanan di bawah ini</p>
            </div>

            <!-- Kartu Layanan -->
            <div class="grid md:grid-cols-2 gap-6 justify-center px-4">
                <!-- Kartu Buat Surat -->
                <a href="{{ route('anjungan.surat.index') }}"
                    class="tablet-card cursor-pointer bg-white/95 hover:bg-white rounded-3xl shadow-xl p-8 flex flex-col items-center text-center group border border-white/10">
                    <div
                        class="tablet-icon w-20 h-20 rounded-2xl bg-navy-50 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-navy-700" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M2 4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1.5l-10 7L2 5.5V4zm0 4.697v11.303a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8.697l-10 7-10-7z" />
                        </svg>
                    </div>
                    <h2 class="font-display text-xl md:text-2xl font-semibold text-navy-900">Buat Surat</h2>
                    <p class="text-slate-500 text-base md:text-lg mt-2">Buat surat langsung jadi</p>
                </a>

                <!-- Kartu Cetak Surat -->
                <a href="#" onclick="showModal('anjungan/riwayat/cek'); return false;"
                    class="tablet-card cursor-pointer bg-white/95 hover:bg-white rounded-3xl shadow-xl p-8 flex flex-col items-center text-center group border border-white/10">
                    <div
                        class="tablet-icon w-20 h-20 rounded-2xl bg-gold-500/10 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gold-600" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M6 9V2h12v7h2a2 2 0 0 1 2 2v5h-4v6H8v-6H4v-5a2 2 0 0 1 2-2h0zm2 0h8V4H8v5zm0 8v2h8v-2H8z" />
                        </svg>
                    </div>
                    <h2 class="font-display text-xl md:text-2xl font-semibold text-navy-900">Cetak Surat</h2>
                    <p class="text-slate-500 text-base md:text-lg mt-2">Cetak surat sesuai kebutuhan</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Input NIK / Email -->
    <div id="modal-nik" class="hidden fixed inset-0 bg-navy-900/60 flex items-center justify-center z-50 p-4">

        <div class="bg-white rounded-2xl p-6 md:p-8 w-full max-w-md shadow-2xl border border-navy-100">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-1">

                <div class="bg-gold-500/10 rounded-lg p-2">
                    <svg class="h-5 w-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                    </svg>
                </div>

                <h2 class="font-display text-xl md:text-2xl font-semibold text-navy-900">
                    Identitas Warga
                </h2>

            </div>


            <!-- Deskripsi -->
            <p class="text-slate-500 text-sm mb-5 ml-1">
                Masukkan NIK atau email yang terdaftar untuk melanjutkan
            </p>


            <!-- Input -->
            <input type="text" id="input-nik" name="identifier" placeholder="Masukkan NIK atau Email" autocomplete="off"
                class="w-full border border-navy-100 rounded-xl px-4 py-3
                   focus:outline-none
                   focus:ring-2
                   focus:ring-gold-500
                   focus:border-gold-500
                   text-navy-900
                   placeholder:text-slate-400
                   mb-2" />


            <!-- Keterangan -->
            <p class="text-xs text-slate-400 mb-5 ml-1">
                Contoh: 7304xxxxxxxxxxxx atau nama@email.com
            </p>


            <!-- Tombol -->
            <div class="flex justify-end gap-3">

                <button type="button" onclick="closeModal()" class="bg-slate-100 hover:bg-slate-200
                       text-navy-900
                       font-semibold
                       px-5 py-3
                       rounded-xl
                       text-base
                       transition-colors">

                    Batal

                </button>


                <button type="button" onclick="submitNik()" class="bg-navy-700 hover:bg-navy-800
                       text-white
                       font-semibold
                       px-5 py-3
                       rounded-xl
                       text-base
                       transition-colors">

                    Lanjut

                </button>

            </div>

        </div>
    </div>

    <script>
        let tujuan = '';

        // =========================================================
        // FULLSCREEN
        // =========================================================

        document.addEventListener('DOMContentLoaded', function () {

            const fullscreenButton =
                document.getElementById('fullscreen-button');

            if (fullscreenButton) {

                fullscreenButton.addEventListener(
                    'click',
                    function () {
                        enterFullscreen();
                    }
                );

            }


            // Hide fullscreen button when in fullscreen mode
            document.addEventListener(
                'fullscreenchange',
                updateFullscreenButtonVisibility
            );

            document.addEventListener(
                'webkitfullscreenchange',
                updateFullscreenButtonVisibility
            );

            document.addEventListener(
                'mozfullscreenchange',
                updateFullscreenButtonVisibility
            );

            document.addEventListener(
                'MSFullscreenChange',
                updateFullscreenButtonVisibility
            );


            function updateFullscreenButtonVisibility() {

                if (!fullscreenButton) {
                    return;
                }

                if (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.mozFullScreenElement ||
                    document.msFullscreenElement
                ) {

                    fullscreenButton.style.display = 'none';

                } else {

                    fullscreenButton.style.display = 'block';

                }
            }
        });


        // =========================================================
        // MASUK FULLSCREEN
        // =========================================================

        function enterFullscreen() {

            const docElement =
                document.documentElement;


            if (docElement.requestFullscreen) {

                docElement.requestFullscreen();

            } else if (docElement.webkitRequestFullscreen) {

                docElement.webkitRequestFullscreen();

            } else if (docElement.mozRequestFullScreen) {

                docElement.mozRequestFullScreen();

            } else if (docElement.msRequestFullscreen) {

                docElement.msRequestFullscreen();

            }
        }


        // =========================================================
        // BUKA MODAL
        // =========================================================

        function showModal(target) {

            tujuan = target;


            const modal =
                document.getElementById('modal-nik');

            const input =
                document.getElementById('input-nik');


            modal.classList.remove('hidden');


            // Fokus ke input
            setTimeout(function () {

                input.focus();

            }, 100);
        }


        // =========================================================
        // TUTUP MODAL
        // =========================================================

        function closeModal() {

            const modal =
                document.getElementById('modal-nik');

            const input =
                document.getElementById('input-nik');


            modal.classList.add('hidden');

            input.value = '';
        }


        // =========================================================
        // SUBMIT NIK / EMAIL
        // =========================================================

        function submitNik() {

            const input =
                document.getElementById('input-nik');


            const identifier =
                input.value.trim();


            // -----------------------------------------------------
            // Validasi kosong
            // -----------------------------------------------------

            if (identifier === '') {

                alert(
                    'Silakan masukkan NIK atau email.'
                );

                input.focus();

                return;
            }


            // -----------------------------------------------------
            // Validasi NIK atau Email
            // -----------------------------------------------------

            const isNik =
                /^\d{16}$/.test(identifier);


            const isEmail =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(identifier);


            if (!isNik && !isEmail) {

                alert(
                    'Masukkan NIK 16 digit atau email yang valid.'
                );

                input.focus();

                return;
            }


            // -----------------------------------------------------
            // Ambil CSRF Token
            // -----------------------------------------------------

            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                );


            if (!csrfToken) {

                console.error(
                    'CSRF token tidak ditemukan.'
                );

                alert(
                    'Token keamanan tidak ditemukan. Silakan refresh halaman.'
                );

                return;
            }


            // -----------------------------------------------------
            // Nonaktifkan tombol sementara
            // -----------------------------------------------------

            const buttons =
                document.querySelectorAll(
                    '#modal-nik button'
                );


            buttons.forEach(function (button) {

                button.disabled = true;

            });


            // -----------------------------------------------------
            // AJAX cek NIK / Email
            // -----------------------------------------------------

            fetch(
                '/anjungan/cek-identitas',
                {
                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken.getAttribute('content')
                    },

                    body: JSON.stringify({

                        identifier:
                            identifier

                    })
                }
            )
                .then(async function (response) {

                    /*
                    |--------------------------------------------------------------------------
                    | Coba ambil response JSON
                    |--------------------------------------------------------------------------
                    */

                    let data;

                    try {

                        data =
                            await response.json();

                    } catch (error) {

                        throw new Error(
                            'Response server tidak valid.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Jika HTTP error
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        if (
                            data.errors &&
                            data.errors.identifier
                        ) {

                            throw new Error(
                                data.errors.identifier[0]
                            );

                        }

                        throw new Error(
                            data.message ||
                            'Terjadi kesalahan pada server.'
                        );
                    }


                    return data;
                })
                .then(function (data) {

                    // -------------------------------------------------
                    // IDENTITAS VALID
                    // -------------------------------------------------

                    if (data.status === 'valid') {

                        /*
                        |--------------------------------------------------------------------------
                        | Redirect ke tujuan
                        |
                        | identifier bisa berupa:
                        | - NIK
                        | - Email
                        |--------------------------------------------------------------------------
                        */

                        window.location.href =
                            `/${tujuan}/${encodeURIComponent(identifier)}`;

                        return;
                    }


                    // -------------------------------------------------
                    // IDENTITAS TIDAK VALID
                    // -------------------------------------------------

                    alert(
                        data.message ||
                        'NIK atau email tidak ditemukan.'
                    );

                })
                .catch(function (error) {

                    console.error(
                        'Error:',
                        error
                    );

                    alert(
                        error.message ||
                        'Terjadi kesalahan saat memproses permintaan.'
                    );

                })
                .finally(function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Aktifkan kembali tombol
                    |--------------------------------------------------------------------------
                    */

                    buttons.forEach(function (button) {

                        button.disabled = false;

                    });
                });
        }


        // =========================================================
        // ENTER KEY
        // =========================================================

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const input =
                    document.getElementById('input-nik');


                if (!input) {
                    return;
                }


                input.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Enter'
                        ) {

                            event.preventDefault();

                            submitNik();

                        }
                    }
                );
            }
        );
    </script>
</body>

</html>
