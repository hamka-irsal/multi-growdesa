<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Surat Kehilangan</title>
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
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .pattern-kawung {
            background-image: radial-gradient(circle at 12px 12px, rgba(255, 255, 255, 0.08) 3px, transparent 3.5px),
                radial-gradient(circle at 32px 32px, rgba(255, 255, 255, 0.08) 3px, transparent 3.5px);
            background-size: 44px 44px;
        }

        .field-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #d7e0ec;
            border-radius: 0.75rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-input:focus {
            outline: none;
            border-color: #c9a227;
            box-shadow: 0 0 0 3px rgba(201, 162, 39, 0.18);
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid #c9a227;
            outline-offset: 2px;
        }
    </style>
</head>

<body class="bg-paper min-h-screen">

    <!-- Header band -->
    <header class="bg-gradient-to-br from-navy-700 to-navy-900 pattern-kawung">

        <div class="max-w-4xl mx-auto px-5 md:px-8 py-8 md:py-10 flex items-center gap-4">
            <button type="button" onclick="window.location.href='{{ route('anjungan.surat.index') }}'"
                class="shrink-0 h-11 w-11 md:h-12 md:w-12 rounded-full bg-navy-800/80 border border-gold-500/40 flex items-center justify-center text-gold-400 hover:bg-navy-800 hover:text-gold-300 transition-colors"
                aria-label="Kembali">

                <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                </svg>

            </button>
            <!-- Icon Surat Tidak Mampu -->
            <div class="shrink-0 bg-navy-800 border border-gold-500/40 rounded-full
            h-12 w-12 md:h-14 md:w-14 flex items-center justify-center">

                <svg class="h-6 w-6 md:h-7 md:w-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <!-- Icon dokumen -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                        d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M14 2v6h6" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 13h8M8 17h5" />

                </svg>

            </div>


            <div>

                <p class="text-gold-400 text-xs md:text-sm font-semibold
                tracking-[0.2em] uppercase mb-1">

                    Formulir Permohonan

                </p>


                <h1 class="font-display text-2xl md:text-3xl
                font-semibold text-white leading-tight">

                    Surat Keterangan Tidak Mampu

                </h1>

            </div>

        </div>

    </header>


    <!-- Konten -->
    <main class="max-w-4xl mx-auto px-5 md:px-8
    py-8 md:py-10 -mt-4 md:-mt-6">

        <div class="bg-white rounded-2xl shadow-card
        border border-navy-100 p-6 md:p-8">


            <!-- Data pemohon -->
            <div class="bg-navy-50/60 border border-navy-100 rounded-xl p-5 md:p-6 mb-8">

                <p class="text-xs font-semibold tracking-[0.15em] uppercase text-navy-600 mb-4">
                    Data Pemohon
                </p>

                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4">

                    <!-- Nama Lengkap -->
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">
                            Nama Lengkap
                        </p>

                        <p class="text-base font-semibold text-navy-900">
                            {{ $penduduk->nama_lengkap }}
                        </p>
                    </div>


                    <!-- NIK -->
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">
                            NIK
                        </p>

                        <p class="text-base font-semibold text-navy-900">
                            {{ $penduduk->nik }}
                        </p>
                    </div>


                    <!-- Alamat -->
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">
                            Alamat
                        </p>

                        <p class="text-base font-semibold text-navy-900">
                            {{ $penduduk->alamat }}
                        </p>
                    </div>


                    <!-- Email -->
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">
                            Email
                        </p>

                        <p class="text-base font-semibold text-navy-900">
                            {{ $email ?? $penduduk->user->email ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>


            <!-- Informasi Surat Tidak Mampu -->
            <div class="bg-gold-400/10
            border border-gold-500/30
            rounded-xl p-5 mb-6">

                <div class="flex items-start gap-3">


                    <!-- Icon Informasi -->
                    <svg class="w-5 h-5 text-gold-600
                    shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>


                    <div>

                        <p class="text-sm font-semibold
                        text-navy-900 mb-1">

                            Tidak Ada Data Tambahan

                        </p>


                        <p class="text-sm text-slate-600
                        leading-relaxed">

                            Permohonan Surat Keterangan Tidak Mampu
                            akan menggunakan data kependudukan yang telah
                            terdaftar pada sistem. Pastikan nama, NIK,
                            dan alamat di atas sudah sesuai sebelum
                            mengirim permohonan.

                        </p>

                    </div>

                </div>

            </div>


            <!-- Form Surat Tidak Mampu -->
            <form id="formSurat" action="{{ route('anjungan.surat.simpan', ['jenisSurat' => $jenis->id]) }}"
                method="POST">

                @csrf


                <!-- NIK Penduduk -->
                <input type="hidden" name="nik" value="{{ $penduduk->nik }}">


                <!-- Tombol Kirim -->
                <div class="pt-2 flex flex-col
                sm:flex-row gap-3">


                    <button type="submit" id="btnKirim" class="w-full sm:w-auto
                    bg-navy-700 hover:bg-navy-800
                    text-white font-semibold
                    py-3 px-6 rounded-xl
                    transition-colors">

                        Kirim Permohonan

                    </button>


                    <p class="text-xs text-slate-500
                    self-center">

                        Pastikan data pemohon di atas sudah benar
                        sebelum mengirim.

                    </p>

                </div>

            </form>

        </div>

    </main>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('formSurat');
            const btnKirim = document.getElementById('btnKirim');

            form.addEventListener('submit', async function (e) {

                // Mencegah form berpindah halaman
                e.preventDefault();

                // Validasi HTML bawaan
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Ubah tombol ketika proses penyimpanan
                btnKirim.disabled = true;

                btnKirim.innerHTML = `
                <span>Memproses...</span>
            `;

                try {

                    const response = await fetch(form.action, {

                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': document.querySelector(
                                'input[name="_token"]'
                            ).value,

                            'X-Requested-With': 'XMLHttpRequest',

                            'Accept': 'application/json',

                        },

                        body: new FormData(form),

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil response dari controller
                    |--------------------------------------------------------------------------
                    */

                    const result = await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | Jika request gagal
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        let pesan =
                            result.message ||
                            'Permohonan surat gagal disimpan.';

                        /*
                        |--------------------------------------------------------------------------
                        | Menampilkan error validasi Laravel
                        |--------------------------------------------------------------------------
                        */

                        if (result.errors) {

                            pesan = Object.values(result.errors)
                                .map(error => error[0])
                                .join('<br>');

                        }

                        throw new Error(pesan);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Jika berhasil
                    |--------------------------------------------------------------------------
                    */

                    if (result.success) {

                        await Swal.fire({

                            icon: 'success',

                            title: 'Permohonan Berhasil Dibuat',

                            html: `
                            Surat Anda berhasil dibuat.<br>
                            Silakan menunggu konfirmasi dari aparat desa.
                        `,

                            confirmButtonText: 'Kembali ke Daftar Surat',

                            allowOutsideClick: false,

                            allowEscapeKey: false,

                        });


                        /*
                        |--------------------------------------------------------------------------
                        | Kembali ke halaman daftar surat
                        |--------------------------------------------------------------------------
                        */

                        window.location.href =
                            "{{ route('anjungan.surat.index') }}";

                    }

                } catch (error) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Permohonan Gagal',

                        html: error.message ||
                            'Terjadi kesalahan saat menyimpan surat.',

                        confirmButtonText: 'Tutup',

                    });

                } finally {

                    // Aktifkan kembali tombol
                    btnKirim.disabled = false;

                    btnKirim.innerHTML =
                        'Kirim Permohonan';

                }

            });

        });
    </script>
</body>

</html>