<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Surat</title>
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

        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #c9a227;
            outline-offset: 2px;
        }

        /* Responsive: kartu di mobile, tabel di layar lebih besar */
        @media (max-width: 767px) {
            .riwayat-table thead {
                display: none;
            }

            .riwayat-table,
            .riwayat-table tbody,
            .riwayat-table tr,
            .riwayat-table td {
                display: block;
                width: 100%;
            }

            .riwayat-table tr {
                background: #fff;
                border: 1px solid #d7e0ec;
                border-radius: 0.75rem;
                margin-bottom: 0.75rem;
                padding: 0.75rem 1rem;
            }

            .riwayat-table td {
                padding: 0.4rem 0 !important;
                white-space: normal !important;
                text-align: left !important;
                border: none !important;
            }

            .riwayat-table td[data-label]::before {
                content: attr(data-label);
                display: block;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #a9841c;
                margin-bottom: 0.15rem;
            }

            .riwayat-table td.no-label::before {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-paper min-h-screen">

    <!-- Header band -->
    <header class="bg-gradient-to-br from-navy-700 to-navy-900 pattern-kawung">
        <div class="max-w-6xl mx-auto px-5 md:px-8 py-8 md:py-10 flex items-center gap-4">
            <button type="button" onclick="window.location.href='{{ route('anjungan.home') }}'"
                class="shrink-0 h-11 w-11 md:h-12 md:w-12 rounded-full bg-navy-800/80 border border-gold-500/40 flex items-center justify-center text-gold-400 hover:bg-navy-800 hover:text-gold-300 transition-colors"
                aria-label="Kembali">

                <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                </svg>

            </button>
            <div
                class="shrink-0 bg-navy-800 border border-gold-500/40 rounded-full h-12 w-12 md:h-14 md:w-14 flex items-center justify-center">
                <svg class="h-6 w-6 md:h-7 md:w-7 text-gold-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-gold-400 text-xs md:text-sm font-semibold tracking-[0.2em] uppercase mb-1">Riwayat
                    Pengajuan</p>
                <h1 class="font-display text-2xl md:text-3xl font-semibold text-white leading-tight">Riwayat Surat</h1>
                <p class="text-navy-100/80 text-sm md:text-base mt-1">NIK: {{ $nik }}</p>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-5 md:px-8 py-8 md:py-10 -mt-4 md:-mt-6">

        <div class="bg-white rounded-2xl shadow-card border border-navy-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="riwayat-table min-w-full divide-y divide-navy-100">

                    <thead class="bg-navy-50/60">

                        <tr>

                            <th scope="col"
                                class="px-6 py-3.5 text-left text-xs font-bold text-navy-600 uppercase tracking-wider">

                                No

                            </th>


                            <th scope="col"
                                class="px-6 py-3.5 text-left text-xs font-bold text-navy-600 uppercase tracking-wider">

                                Jenis Surat

                            </th>


                            <th scope="col"
                                class="px-6 py-3.5 text-left text-xs font-bold text-navy-600 uppercase tracking-wider">

                                Tanggal

                            </th>


                            <th scope="col"
                                class="px-6 py-3.5 text-left text-xs font-bold text-navy-600 uppercase tracking-wider">

                                Status

                            </th>


                            <th scope="col"
                                class="px-6 py-3.5 text-right text-xs font-bold text-navy-600 uppercase tracking-wider">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody class="bg-white divide-y divide-navy-100">

                        @forelse ($surat as $index => $s)
                            <tr class="hover:bg-navy-50/40 transition-colors">


                                <!-- Nomor urut tetap berlanjut antar halaman -->
                                <td class="no-label px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">

                                    {{ $surat->firstItem() + $index }}

                                </td>


                                <!-- Jenis Surat -->
                                <td data-label="Jenis Surat"
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-navy-900">

                                    {{ $s->jenisSurat->nama_jenis ?? '-' }}

                                </td>


                                <!-- Tanggal -->
                                <td data-label="Tanggal" class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">

                                    {{ isset($s->tanggal_pengajuan) ? \Carbon\Carbon::parse($s->tanggal_pengajuan)->format('d-m-Y') : '-' }}

                                </td>


                                <!-- Status -->
                                <td data-label="Status" class="px-6 py-4 whitespace-nowrap">

                                    @if ($s->status_surat == 'selesai')
                                        <span
                                            class="px-3 py-1 inline-flex items-center text-sm leading-5 font-medium rounded-full bg-green-100 text-green-700">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />

                                            </svg>

                                            Selesai

                                        </span>
                                    @elseif ($s->status_surat == 'proses')
                                        <span
                                            class="px-3 py-1 inline-flex items-center text-sm leading-5 font-medium rounded-full bg-amber-100 text-amber-700">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                                            </svg>

                                            Diproses

                                        </span>
                                    @elseif ($s->status_surat == 'tolak')
                                        <span
                                            class="px-3 py-1 inline-flex items-center text-sm leading-5 font-medium rounded-full bg-red-100 text-red-700">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />

                                            </svg>

                                            Ditolak

                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full bg-slate-100 text-slate-500">

                                            -

                                        </span>
                                    @endif

                                </td>


                                <!-- Aksi -->
                                <td data-label="Aksi"
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                    @if ($s->status_surat == 'selesai')
                                        <a href="{{ route('anjungan.riwayat.cetak', $s->id) }}" target="_blank"
                                            class="inline-flex items-center justify-end gap-1.5 text-navy-700 hover:text-gold-600 font-semibold transition-colors">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />

                                            </svg>

                                            Cetak

                                        </a>
                                    @else
                                        <span class="text-slate-300">

                                            —

                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="px-6 py-12 whitespace-nowrap text-sm text-center text-slate-500">

                                    <div class="flex flex-col items-center gap-2">

                                        <svg class="h-9 w-9 text-navy-100" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                        </svg>

                                        Belum ada riwayat surat.

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- Pagination di tengah -->
            @if ($surat->hasPages())
                <div class="flex justify-center items-center px-6 py-5 border-t border-navy-100">

                    {{ $surat->onEachSide(1)->links() }}

                </div>
            @endif

        </div>

    </main>

</body>

</html>
