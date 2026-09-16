<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Surat</title>
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
                            400: '#d9b64a',
                            500: '#c9a227',
                            600: '#a9841c',
                        },
                        paper: '#f7f4ec',
                    },
                    fontFamily: {
                        display: ['"Fraunces"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 1px 2px rgba(15,29,46,0.06), 0 8px 24px -12px rgba(27,51,80,0.18)',
                        cardHover: '0 4px 10px rgba(15,29,46,0.08), 0 16px 32px -12px rgba(27,51,80,0.28)',
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
        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        /* Subtle batik-inspired "kawung" watermark pattern for the header band */
        .pattern-kawung {
            background-image: radial-gradient(circle at 12px 12px, rgba(255, 255, 255, 0.08) 3px, transparent 3.5px),
                radial-gradient(circle at 32px 32px, rgba(255, 255, 255, 0.08) 3px, transparent 3.5px);
            background-size: 44px 44px;
        }

        /* Official seal / stempel motif */
        .seal {
            position: relative;
        }

        .seal::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 9999px;
            border: 1.5px dashed rgba(201, 162, 39, 0.55);
            animation: spin-slow 40s linear infinite;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .letter-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .letter-card:hover {
            transform: translateY(-4px);
        }

        @media (prefers-reduced-motion: reduce) {

            .letter-card,
            .seal::before {
                transition: none;
                animation: none;
            }
        }

        /* Visible keyboard focus */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid #c9a227;
            outline-offset: 2px;
        }

        #modalNIK {
            backdrop-filter: blur(2px);
        }
    </style>
</head>

<body class="bg-paper min-h-screen text-navy-900">

    <!-- Header band -->
    <header class="bg-gradient-to-br from-navy-700 to-navy-900 pattern-kawung">
        <div class="max-w-7xl mx-auto px-5 md:px-8 py-10 md:py-14 flex items-center gap-5">
            <button type="button" onclick="window.location.href='{{ route('anjungan.home') }}'"
                class="shrink-0 h-11 w-11 md:h-12 md:w-12 rounded-full bg-navy-800/80 border border-gold-500/40 flex items-center justify-center text-gold-400 hover:bg-navy-800 hover:text-gold-300 transition-colors"
                aria-label="Kembali">

                <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                </svg>

            </button>
            <div
                class="seal shrink-0 bg-navy-800 border border-gold-500/40 rounded-full h-14 w-14 md:h-16 md:w-16 flex items-center justify-center">
                <svg class="h-7 w-7 md:h-8 md:w-8 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-gold-400 text-xs md:text-sm font-semibold tracking-[0.2em] uppercase mb-1">Layanan
                    Anjungan Mandiri</p>
                <h1 class="font-display text-2xl md:text-4xl font-semibold text-white leading-tight">Daftar Surat</h1>
                <p class="text-navy-100/80 text-sm md:text-base mt-1 max-w-xl">Pilih jenis surat yang ingin dibuat, lalu
                    verifikasi NIK untuk melanjutkan.</p>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-5 md:px-8 py-8 md:py-12 -mt-6 md:-mt-8">

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">

            @forelse ($dataSurat as $surat)
                <article
                    class="letter-card w-full bg-white rounded-2xl shadow-card hover:shadow-cardHover border border-navy-100 p-6 flex flex-col">

                    <div class="flex items-center gap-4 mb-4">

                        <!-- Icon Surat -->
                        <div class="bg-navy-50 rounded-xl p-3 shrink-0">

                            <svg class="h-6 w-6 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                    d="M4 5.25A2.25 2.25 0 016.25 3h11.5A2.25 2.25 0 0120 5.25v13.5A2.25 2.25 0 0117.75 21H6.25A2.25 2.25 0 014 18.75V5.25z" />

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                    d="M8 8h8M8 12h8M8 16h5" />
                            </svg>

                        </div>

                        <!-- Nama Jenis Surat -->
                        <h2 class="font-display text-lg font-semibold text-navy-900">
                            {{ $surat->nama_jenis }}
                        </h2>

                    </div>

                    <!-- Deskripsi -->
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">

                        {{ $surat->deskripsi ?? 'Layanan pengajuan ' . strtolower($surat->nama_jenis) . ' untuk warga desa.' }}

                    </p>

                    <!-- Tombol Buat Surat -->
                    <button type="button"
                        class="btn-buat-surat mt-auto w-full bg-navy-700 hover:bg-navy-800 text-white text-sm font-semibold py-3 px-4 rounded-xl transition-colors"
                        data-id="{{ $surat->id }}" data-surat="{{ \Illuminate\Support\Str::slug($surat->nama_jenis) }}"
                        data-nama="{{ $surat->nama_jenis }}">
                        Buat Surat
                    </button>

                </article>

            @empty

                <!-- Jika belum ada jenis surat -->
                <div class="col-span-full bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center">

                    <svg class="w-12 h-12 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 5.25A2.25 2.25 0 016.25 3h11.5A2.25 2.25 0 0120 5.25v13.5A2.25 2.25 0 0117.75 21H6.25A2.25 2.25 0 014 18.75V5.25z" />
                    </svg>

                    <h3 class="text-lg font-semibold text-slate-700">
                        Belum Ada Jenis Surat
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Data jenis surat belum tersedia.
                    </p>

                </div>
            @endforelse

        </div>

    </main>

    <!-- Modal NIK / Email -->
    <div id="modalNIK" class="fixed inset-0 bg-navy-900/60 flex justify-center items-center z-50 hidden p-4">

        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 w-full max-w-md border border-navy-100">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-1">

                <div class="bg-gold-500/10 rounded-lg p-2">
                    <svg class="h-5 w-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7-7h14a7 7 0 00-7-7z" />

                    </svg>
                </div>

                <h2 class="font-display text-xl md:text-2xl font-semibold text-navy-900">
                    Identitas Warga
                </h2>

            </div>


            <!-- Subtitle -->
            <p id="modalSubtitle" class="text-slate-500 text-sm mb-5 ml-1">

                Silakan masukkan NIK atau email Anda

            </p>


            <!-- Jenis Surat -->
            <input type="hidden" id="jenisSurat">


            <!-- Input Identitas -->
            <div class="mb-6">

                <label for="nik" class="block text-navy-900 text-sm font-semibold mb-2">

                    NIK atau Email

                </label>


                <input type="text" id="nik" name="identifier" autocomplete="off" class="w-full p-3 border border-navy-100 rounded-xl
                       focus:outline-none
                       focus:ring-2
                       focus:ring-gold-500
                       focus:border-gold-500
                       text-navy-900
                       placeholder:text-slate-400" placeholder="NIK 16 digit atau email">


                <!-- Contoh -->
                <p class="mt-2 text-slate-400 text-xs">

                    Contoh: 320101XXXXXXXXXX atau nama@email.com

                </p>


                <!-- Error -->
                <p id="statusNIK" class="mt-2 text-red-600 text-sm">
                </p>

            </div>


            <!-- Tombol -->
            <div class="flex justify-end gap-3">

                <button type="button" id="btnCloseModal" class="bg-slate-100 hover:bg-slate-200
                       text-navy-900
                       font-semibold
                       text-sm
                       py-2.5
                       px-5
                       rounded-xl
                       transition-colors">

                    Batal

                </button>


                <button type="button" id="cekNIK" class="bg-navy-700 hover:bg-navy-800
                       text-white
                       font-semibold
                       text-sm
                       py-2.5
                       px-5
                       rounded-xl
                       transition-colors">

                    Lanjut

                </button>

            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | Buka Modal
            |--------------------------------------------------------------------------
            */

            $('.btn-buat-surat').on('click', function () {

                // Ambil ID dan nama jenis surat
                const jenisSuratId = $(this).data('id');
                const namaSurat = $(this).data('nama');

                // Simpan ID jenis surat
                $('#jenisSurat').val(jenisSuratId);

                // Ubah subtitle modal
                $('#modalSubtitle').text(
                    `Silakan masukkan NIK atau email untuk membuat ${namaSurat}`
                );

                // Bersihkan input dan status
                $('#nik').val('');
                $('#statusNIK').text('');

                // Tampilkan modal
                $('#modalNIK').removeClass('hidden');

                // Fokus input
                $('#nik').focus();

            });


            /*
            |--------------------------------------------------------------------------
            | Tutup Modal
            |--------------------------------------------------------------------------
            */

            $('#btnCloseModal').on('click', function () {

                $('#modalNIK').addClass('hidden');

                $('#nik').val('');

                $('#jenisSurat').val('');

                $('#statusNIK').text('');

            });


            /*
            |--------------------------------------------------------------------------
            | Cek NIK / Email dengan AJAX
            |--------------------------------------------------------------------------
            */

            $('#cekNIK').on('click', function () {

                // Ambil NIK atau Email
                const identifier =
                    $('#nik').val().trim();

                // Ambil ID jenis surat
                const jenisSuratId =
                    $('#jenisSurat').val();


                /*
                |--------------------------------------------------------------------------
                | Validasi input kosong
                |--------------------------------------------------------------------------
                */

                if (!identifier) {

                    $('#statusNIK')
                        .removeClass('text-green-600')
                        .addClass('text-red-600')
                        .text(
                            'Silakan masukkan NIK atau email terlebih dahulu.'
                        );

                    $('#nik').focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Validasi NIK atau Email
                |--------------------------------------------------------------------------
                */

                const isNik =
                    /^\d{16}$/.test(identifier);

                const isEmail =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(identifier);


                if (!isNik && !isEmail) {

                    $('#statusNIK')
                        .removeClass('text-green-600')
                        .addClass('text-red-600')
                        .text(
                            'Masukkan NIK 16 digit atau email yang valid.'
                        );

                    $('#nik').focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Pastikan jenis surat tersedia
                |--------------------------------------------------------------------------
                */

                if (!jenisSuratId) {

                    $('#statusNIK')
                        .removeClass('text-green-600')
                        .addClass('text-red-600')
                        .text(
                            'Jenis surat tidak ditemukan.'
                        );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Status loading
                |--------------------------------------------------------------------------
                */

                const button =
                    $(this);

                button.prop(
                    'disabled',
                    true
                );

                button.text(
                    'Memeriksa...'
                );


                $('#statusNIK')
                    .removeClass(
                        'text-red-600 text-green-600'
                    )
                    .text(
                        isNik
                            ? 'Sedang memeriksa NIK...'
                            : 'Sedang memeriksa email...'
                    );


                /*
                |--------------------------------------------------------------------------
                | AJAX cek NIK / Email
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    // Route yang sudah kamu pertahankan
                    url: "{{ route('anjungan.cek-nik') }}",

                    type: "POST",

                    dataType: "json",

                    data: {

                        _token:
                            $('meta[name="csrf-token"]')
                                .attr('content'),

                        // Penting:
                        // controller sekarang membaca identifier
                        identifier:
                            identifier

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Jika request berhasil
                    |--------------------------------------------------------------------------
                    */

                    success: function (response) {

                        if (
                            response.status === 'valid'
                        ) {

                            $('#statusNIK')
                                .removeClass(
                                    'text-red-600'
                                )
                                .addClass(
                                    'text-green-600'
                                )
                                .text(
                                    isNik
                                        ? 'NIK ditemukan. Mengarahkan ke form...'
                                        : 'Email ditemukan. Mengarahkan ke form...'
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Buat URL form berdasarkan ID jenis surat
                            |--------------------------------------------------------------------------
                            */

                            let url =
                                "{{ route('anjungan.surat.form', ':id') }}";


                            url =
                                url.replace(
                                    ':id',
                                    jenisSuratId
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Redirect membawa identifier
                            |--------------------------------------------------------------------------
                            |
                            | Sebelumnya:
                            | ?nik=...
                            |
                            | Sekarang:
                            | ?identifier=...
                            |--------------------------------------------------------------------------
                            */

                            window.location.href =
                                url +
                                '?identifier=' +
                                encodeURIComponent(
                                    identifier
                                );

                        } else {

                            $('#statusNIK')
                                .removeClass(
                                    'text-green-600'
                                )
                                .addClass(
                                    'text-red-600'
                                )
                                .text(
                                    response.message ||
                                    'NIK atau email tidak ditemukan.'
                                );

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Jika AJAX gagal
                    |--------------------------------------------------------------------------
                    */

                    error: function (xhr) {

                        let pesan =
                            'Terjadi kesalahan saat memproses data.';


                        /*
                        |--------------------------------------------------------------------------
                        | Jika validasi Laravel gagal
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            const errors =
                                xhr.responseJSON.errors;


                            if (
                                errors.identifier
                            ) {

                                pesan =
                                    errors.identifier[0];

                            } else if (
                                errors.nik
                            ) {

                                // Kompatibilitas jika masih ada
                                // validasi lama
                                pesan =
                                    errors.nik[0];

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Jika CSRF gagal
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.status === 419
                        ) {

                            pesan =
                                'Sesi halaman telah berakhir. Silakan muat ulang halaman.';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Tampilkan error
                        |--------------------------------------------------------------------------
                        */

                        $('#statusNIK')
                            .removeClass(
                                'text-green-600'
                            )
                            .addClass(
                                'text-red-600'
                            )
                            .text(
                                pesan
                            );

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Setelah request selesai
                    |--------------------------------------------------------------------------
                    */

                    complete: function () {

                        button.prop(
                            'disabled',
                            false
                        );

                        button.text(
                            'Lanjut'
                        );

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Enter pada input NIK / Email
            |--------------------------------------------------------------------------
            */

            $('#nik').on(
                'keypress',
                function (event) {

                    if (
                        event.which === 13
                    ) {

                        event.preventDefault();

                        $('#cekNIK').click();

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | SweetAlert sukses
            |--------------------------------------------------------------------------
            */

            @if (session('success'))

                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil!',

                    text: @json(session('success')),

                    timer: 3000,

                    showConfirmButton: false

                });

            @endif


            /*
            |--------------------------------------------------------------------------
            | SweetAlert error
            |--------------------------------------------------------------------------
            */

            @if (session('error'))

                Swal.fire({

                    icon: 'error',

                    title: 'Oops!',

                    text: @json(session('error')),

                    confirmButtonText: 'OK'

                });

            @endif

    });
    </script>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Surat Berhasil Dibuat!',
                text: @json(session('success')),
                confirmButtonText: 'Kembali',
                confirmButtonColor: '#1b3350',
                allowOutsideClick: false
            });
        });
    </script>
@endif