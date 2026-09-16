<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Surat Usaha</title>
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
            <div
                class="shrink-0 bg-navy-800 border border-gold-500/40 rounded-full h-12 w-12 md:h-14 md:w-14 flex items-center justify-center">
                <svg class="h-6 w-6 md:h-7 md:w-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                        d="M3 7a2 2 0 012-2h14a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM8 5V4a2 2 0 012-2h4a2 2 0 012 2v1M3 11h18" />
                </svg>
            </div>
            <div>
                <p class="text-gold-400 text-xs md:text-sm font-semibold tracking-[0.2em] uppercase mb-1">Formulir
                    Permohonan</p>
                <h1 class="font-display text-2xl md:text-3xl font-semibold text-white leading-tight">Surat Keterangan
                    Usaha</h1>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-5 md:px-8 py-8 md:py-10 -mt-4 md:-mt-6">
        <div class="bg-white rounded-2xl shadow-card border border-navy-100 p-6 md:p-8">

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

            <form id="formSurat" action="{{ route('anjungan.surat.simpan', ['jenisSurat' => $jenis->id]) }}"
                method="POST" class="space-y-6">

                @csrf

                 {{-- NIK penduduk --}}
                <input type="hidden" name="identifier" value="{{ $identifier ?? $penduduk->nik ?? '' }}">

                {{-- Nama Usaha --}}
                <div>

                    <label for="nama_usaha" class="block text-sm font-semibold text-navy-900 mb-2">

                        Nama Usaha

                    </label>

                    <div class="relative">

                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2
                h-5 w-5 text-navy-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M3 10h18" />

                        </svg>

                        <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}"
                            placeholder="Contoh: Toko Berkah Jaya" class="field-input" required>

                    </div>

                    @error('nama_usaha')
                        <p class="mt-2 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Jenis Usaha --}}
                <div>

                    <label for="jenis_usaha" class="block text-sm font-semibold text-navy-900 mb-2">

                        Jenis Usaha

                    </label>

                    <div class="relative">

                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2
                h-5 w-5 text-navy-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M3 7h18M5 7l1 14h12l1-14M9 7V4h6v3" />

                        </svg>

                        <input type="text" id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha') }}"
                            placeholder="Contoh: Perdagangan Sembako" class="field-input" required>

                    </div>

                    @error('jenis_usaha')
                        <p class="mt-2 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Alamat Usaha --}}
                <div>

                    <label for="alamat_usaha" class="block text-sm font-semibold text-navy-900 mb-2">

                        Alamat Usaha

                    </label>

                    <div class="relative">

                        <svg class="absolute left-3.5 top-4
                h-5 w-5 text-navy-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M12 21s7-5.5 7-12a7 7 0 10-14 0c0 6.5 7 12 7 12z" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />

                        </svg>

                        <textarea id="alamat_usaha" name="alamat_usaha" rows="4"
                            placeholder="Contoh: Dusun Bontoloe, Desa Galesong Timur"
                            class="field-input resize-none pt-3" required>{{ old('alamat_usaha') }}</textarea>

                    </div>

                    @error('alamat_usaha')
                        <p class="mt-2 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Tahun Berdiri --}}
                <div>

                    <label for="tahun_berdiri" class="block text-sm font-semibold text-navy-900 mb-2">

                        Tahun Berdiri

                    </label>

                    <div class="relative">

                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2
                h-5 w-5 text-navy-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M8 3v3m8-3v3M4 9h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />

                        </svg>

                        <input type="number" id="tahun_berdiri" name="tahun_berdiri" value="{{ old('tahun_berdiri') }}"
                            min="1900" max="{{ date('Y') }}" placeholder="Contoh: 2020" class="field-input" required>

                    </div>

                    @error('tahun_berdiri')
                        <p class="mt-2 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Tombol kirim --}}
                <div class="pt-2 flex flex-col sm:flex-row gap-3">

                    <button type="submit" id="btnKirim" class="w-full sm:w-auto
                bg-navy-700 hover:bg-navy-800
                text-white font-semibold
                py-3 px-6 rounded-xl
                transition-colors">

                        Kirim Permohonan

                    </button>

                    <p class="text-xs text-slate-500 self-center">

                        Pastikan data usaha yang diisi sudah benar sebelum mengirim.

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