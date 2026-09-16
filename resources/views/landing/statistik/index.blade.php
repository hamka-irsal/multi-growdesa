@extends('landing.layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap');

        .statdesa {
            --ink: #1C2B33;
            --sea: #0E4F66;
            --sea-deep: #0A3A4D;
            --sea-light: #1C7293;
            --sand: #F6EFE3;
            --cream: #FCF9F2;
            --clay: #BE5B3D;
            --gold: #D6A94A;
            --palm: #2F7A63;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background: var(--cream);
        }

        .statdesa h1,
        .statdesa h2,
        .statdesa h3,
        .statdesa h4 {
            font-family: 'Fraunces', serif;
        }

        .statdesa .fig,
        .statdesa .fig * {
            font-family: 'Space Grotesk', monospace;
            font-variant-numeric: tabular-nums;
        }

        .statdesa .eyebrow {
            font-family: 'Space Grotesk', monospace;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .statdesa .card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 1px 2px rgba(14, 79, 102, 0.06), 0 12px 28px -14px rgba(14, 79, 102, 0.18);
            border: 1px solid rgba(14, 79, 102, 0.06);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .statdesa .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(14, 79, 102, 0.08), 0 20px 36px -16px rgba(14, 79, 102, 0.24);
        }

        .statdesa .chip {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .statdesa .link-chain {
            position: relative;
        }

        .statdesa .link-chain:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -1.35rem;
            width: 1.1rem;
            height: 1px;
            background: repeating-linear-gradient(90deg, var(--sea-light) 0 6px, transparent 6px 10px);
            opacity: .55;
        }

        .statdesa .wave-divider {
            display: block;
            width: 100%;
            line-height: 0;
        }

        .statdesa .badge-line {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .statdesa .stat-pill {
            border-radius: 1.25rem;
            padding: 1.75rem;
            background: #fff;
            border: 1px solid rgba(14, 79, 102, 0.08);
        }

        .statdesa .woven {
            background-image:
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0, rgba(255, 255, 255, 0.05) 2px, transparent 2px, transparent 14px),
                repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0.05) 0, rgba(255, 255, 255, 0.05) 2px, transparent 2px, transparent 14px);
        }

        .statdesa .section-head {
            max-width: 42rem;
        }
    </style>

    <div class="statdesa">

        <!-- HERO SECTION -->
        <section class="relative">
            <div class="relative w-full h-72 md:h-[440px] overflow-hidden">
                <img src="assets/img/bg-landing.png" alt="Latar Desa Galesong Timur" class="w-full h-full object-cover">
                <div class="absolute inset-0"
                    style="background: linear-gradient(180deg, rgba(10,58,77,0.75) 0%, rgba(14,79,102,0.55) 45%, rgba(14,79,102,0.35) 100%);">
                </div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                    <span class="eyebrow text-white/80 mb-3">Profil &amp; Data Kependudukan</span>
                    <h2 class="text-white text-3xl md:text-5xl font-semibold tracking-tight">Desa Galesong Timur</h2>
                    <p class="text-white/75 mt-3 text-sm md:text-base">Kec. Galesong &middot; Kab. Takalar &middot;
                        Sulawesi Selatan</p>
                </div>
            </div>
            <!-- Signature wave divider: coastline of Galesong Timur -->
            <div class="wave-divider" style="margin-top:-2px;">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-10 md:h-14">
                    <path fill="#FCF9F2"
                        d="M0,32 C240,60 360,4 600,20 C840,36 960,58 1200,36 C1320,24 1380,20 1440,28 L1440,60 L0,60 Z">
                    </path>
                </svg>
            </div>
        </section>

        <!-- Section Infografis -->
        <section class="px-4 py-10 md:px-10 lg:px-20">

            <!-- Baris Atas: Infografis dan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- ====================================== -->
                <!-- INFOGRAFIS DESA -->
                <!-- ====================================== -->
                <div class="woven rounded-2xl shadow-lg text-white p-6 relative flex items-center justify-center min-h-[300px] overflow-hidden"
                    style="background: linear-gradient(160deg, var(--sea-deep) 0%, var(--sea) 55%, var(--sea-light) 100%);">

                    <img src="assets/img/logo_takalar.png" alt="Lambang Desa"
                        class="absolute opacity-10 inset-0 w-full h-full object-contain" />

                    <div class="relative z-10 text-center">

                        <span class="eyebrow text-white/70">
                            Infografis
                        </span>

                        <h3 class="text-2xl font-semibold mt-1 mb-4">
                            Desa Galesong Timur
                        </h3>

                        <div
                            class="space-y-1.5 bg-black bg-opacity-25 p-4 rounded-xl inline-block text-left text-sm md:text-base backdrop-blur-sm">

                            <p>
                                <span class="opacity-70">Nama Desa</span>
                                &nbsp;:
                                <strong>Galesong Timur</strong>
                            </p>

                            <p>
                                <span class="opacity-70">Kecamatan</span>
                                &nbsp;:
                                <strong>Galesong</strong>
                            </p>

                            <p>
                                <span class="opacity-70">Kab/Kota</span>
                                &nbsp;&nbsp;:
                                <strong>Takalar</strong>
                            </p>

                            <p>
                                <span class="opacity-70">Provinsi</span>
                                &nbsp;&nbsp;:
                                <strong>Sulawesi Selatan</strong>
                            </p>

                        </div>
                    </div>
                </div>


                <!-- ====================================== -->
                <!-- STATISTIK LAKI-LAKI & PEREMPUAN -->
                <!-- ====================================== -->
                <div class="flex flex-col gap-6">

                    <!-- Laki-laki -->
                    <div class="rounded-2xl shadow-md text-white p-6 text-center flex-1 flex flex-col justify-center"
                        style="background: var(--sea-light);">

                        <div class="flex justify-center mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <circle cx="9" cy="14" r="6" />

                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 9.5L20 3M14 3h6v6" />

                            </svg>

                        </div>

                        <h4 class="fig text-3xl font-semibold mb-1">
                            {{ number_format($jumlah_laki, 0, ',', '.') }}
                        </h4>

                        <p class="font-medium text-white/85">
                            Laki-laki
                        </p>

                    </div>


                    <!-- Perempuan -->
                    <div class="rounded-2xl shadow-md text-white p-6 text-center flex-1 flex flex-col justify-center"
                        style="background: var(--clay);">

                        <div class="flex justify-center mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <circle cx="12" cy="9" r="6" />

                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v6M9 18h6" />

                            </svg>

                        </div>

                        <h4 class="fig text-3xl font-semibold mb-1">
                            {{ number_format($jumlah_perempuan, 0, ',', '.') }}
                        </h4>

                        <p class="font-medium text-white/85">
                            Perempuan
                        </p>

                    </div>

                </div>


                <!-- ====================================== -->
                <!-- JUMLAH PENDUDUK -->
                <!-- ====================================== -->
                <div class="rounded-2xl shadow-md text-white p-6 text-center flex flex-col justify-center"
                    style="background: var(--palm);">

                    <div class="flex justify-center mb-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4 0a4 4 0 100-8 4 4 0 000 8z" />

                        </svg>

                    </div>

                    <h4 class="fig text-4xl font-semibold mb-1">
                        {{ number_format($jumlah_penduduk, 0, ',', '.') }}
                    </h4>

                    <p class="font-medium text-white/85">
                        Jumlah Penduduk
                    </p>

                </div>

            </div>


            <!-- ========================================== -->
            <!-- STATISTIK TAMBAHAN -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">


                <!-- ====================================== -->
                <!-- JUMLAH DUSUN -->
                <!-- ====================================== -->
                <div class="rounded-2xl shadow-md text-white p-6 flex items-center" style="background: var(--sea-deep);">

                    <div class="flex items-center justify-center w-16 h-16 rounded-xl bg-white/10 mr-5">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">

                            <!-- Rumah -->
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 9.5V21h14V9.5" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-6h6v6" />

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm text-white/70">
                            Wilayah
                        </p>

                        <h4 class="fig text-4xl font-semibold leading-tight">
                            {{ number_format($jumlah_dusun, 0, ',', '.') }}
                        </h4>

                        <p class="font-medium text-white/85">
                            Dusun
                        </p>

                    </div>

                </div>


                <!-- ====================================== -->
                <!-- KEPALA KELUARGA -->
                <!-- ====================================== -->
                <div class="rounded-2xl shadow-md text-white p-6 flex items-center" style="background: var(--sea);">

                    <div class="flex items-center justify-center w-16 h-16 rounded-xl bg-white/10 mr-5">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">

                            <!-- Kepala -->
                            <circle cx="12" cy="7" r="3.5" />

                            <!-- Badan -->
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 21c0-4.2 3.1-7 7-7s7 2.8 7 7" />

                            <!-- Simbol keluarga -->
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 11a2.5 2.5 0 015-1M20 11a2.5 2.5 0 00-5-1" />

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm text-white/70">
                            Data Keluarga
                        </p>

                        <h4 class="fig text-4xl font-semibold leading-tight">
                            {{ number_format($jumlah_kepala_keluarga, 0, ',', '.') }}
                        </h4>

                        <p class="font-medium text-white/85">
                            Kepala Keluarga
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <!-- Diagram Pekerja -->
        <section class="py-10 px-4 md:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <!-- Diagram (Highcharts) -->
                <div class="card p-4 md:p-6">
                    <div id="pekerjaanChart" class="w-full h-[380px] md:h-[460px]"></div>
                </div>

                <!-- Deskripsi -->
                <div class="section-head">
                    <span class="eyebrow" style="color:var(--sea-light)">Mata Pencaharian</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mt-2 mb-4">Pekerjaan Warga</h2>
                    <p class="mb-6" style="color:#4b5a62">
                        Berikut adalah beberapa jenis pekerjaan mayoritas warga di Desa Galesong Timur.
                        Berdasarkan data tersebut, mayoritas warga Desa Galesong Timur berprofesi sebagai:
                    </p>
                    <div class="stat-pill text-center w-full max-w-sm">
                        <p class="fig text-5xl font-semibold" style="color:var(--sea)">{{ $pekerjaan_teratas->total }}</p>
                        <p class="mt-2 text-lg font-semibold">{{ $pekerjaan_teratas->jenis_pekerjaan }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Diagram Pendidikan -->
        <section class="py-12 px-4 md:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                <!-- Deskripsi -->
                <div class="text-center lg:text-left section-head lg:mx-0 mx-auto">
                    <span class="eyebrow" style="color:var(--palm)">Tingkat Pendidikan</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mt-2 mb-4">Pendidikan Warga</h2>
                    <p class="mb-6" style="color:#4b5a62">
                        Berikut adalah data pendidikan terakhir mayoritas warga Desa Galesong Timur. Berdasarkan data
                        tersebut,
                        mayoritas warga Desa Galesong Timur memiliki pendidikan terakhir di tingkat:
                    </p>
                    <div class="stat-pill text-center w-full max-w-sm mx-auto lg:mx-0">
                        <p class="fig text-5xl font-semibold" style="color:var(--palm)">{{ $pendidikan_teratas->total }}
                        </p>
                        <p class="mt-2 text-lg font-semibold uppercase">
                            {{ Str::upper($pendidikan_teratas->pendidikan) }}
                        </p>
                    </div>
                </div>

                <!-- Chart -->
                <div class="w-full order-1 lg:order-2 card p-4 md:p-6">
                    <div id="pendidikanChart" class="w-full h-[380px]"></div>
                </div>
            </div>
        </section>

        {{-- Diagram Agama --}}
        <section class="py-12 px-4 md:px-8">
            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                <!-- Deskripsi -->
                <div class="text-center lg:text-left order-2 lg:order-1 section-head lg:mx-0 mx-auto">
                    <span class="eyebrow" style="color:var(--sea)">Kepercayaan</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mt-2 mb-4">Distribusi Agama</h2>
                    <p class="mb-6" style="color:#4b5a62">
                        Berikut adalah distribusi populasi berdasarkan agama yang dianut oleh warga Desa Galesong Timur.
                    </p>
                    <div class="stat-pill text-center w-full max-w-sm mx-auto lg:mx-0">
                        <p class="fig text-5xl font-semibold" id="agamaTerbesarPersen" style="color:var(--sea)">
                            {{ $agama_teratas_persen }}%
                        </p>
                        <p class="mt-2 text-lg font-semibold" id="agamaTerbesarNama">
                            {{ $agama_teratas->agama ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Chart Highcharts -->
                <div class="w-full order-1 lg:order-2 card p-4 md:p-6">
                    <div id="agamaChart" class="w-full h-[380px]"></div>
                </div>
            </div>
        </section>

        {{-- Diagram Status Perkawinan --}}
        <section class="py-12 px-4 md:px-8">
            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                <!-- Chart Highcharts -->
                <div class="w-full order-1 lg:order-2 card p-4 md:p-6">
                    <div id="perkawinanChart" class="w-full h-[380px]"></div>
                </div>

                <!-- Deskripsi -->
                <div class="text-center lg:text-left order-1 lg:order-2 section-head lg:mx-0 mx-auto">
                    <span class="eyebrow" style="color:var(--clay)">Status Keluarga</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mt-2 mb-4">Status Perkawinan Warga</h2>
                    <p class="mb-6" style="color:#4b5a62">
                        Diagram berikut menunjukkan jumlah warga berdasarkan status perkawinan yang tercatat:
                    </p>
                    <div class="stat-pill text-center w-full max-w-sm mx-auto lg:mx-0">
                        <p class="fig text-5xl font-semibold" style="color:var(--clay)">
                            {{ $perkawinan_teratas->total ?? 0 }}</p>
                        <p class="mt-2 text-lg font-semibold">
                            {{ $perkawinan_teratas->status_perkawinan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Diagram Kelompok Usia -->
        <section class="py-12 px-4 md:px-8">

            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                <!-- ================================= -->
                <!-- CHART -->
                <!-- ================================= -->

                <div class="w-full order-2 lg:order-1 card p-4 md:p-6">

                    <div id="usiaChart" class="w-full h-[460px]">
                    </div>

                </div>


                <!-- ================================= -->
                <!-- DESKRIPSI -->
                <!-- ================================= -->

                <div class="text-center lg:text-left order-1 lg:order-2 section-head lg:mx-0 mx-auto">

                    <span class="eyebrow" style="color:var(--gold)">
                        Demografi Usia
                    </span>

                    <h2 class="text-3xl md:text-4xl font-semibold mt-2 mb-4">
                        Kelompok Usia Warga
                    </h2>

                    <p class="mb-6" style="color:#4b5a62">

                        Berikut adalah data kelompok umur warga
                        Desa Galesong Timur. Berdasarkan data tersebut,
                        kelompok umur dengan jumlah warga terbanyak adalah:

                    </p>


                    <!-- ================================= -->
                    <!-- KELOMPOK TERBANYAK -->
                    <!-- ================================= -->

                    <div class="stat-pill text-center w-full max-w-sm mx-auto lg:mx-0">

                        <p class="fig text-5xl font-semibold" style="color:#a97e2c">

                            {{ number_format($kelompok_usia_teratas, 0, ',', '.') }}

                        </p>

                        <p class="mt-2 text-lg font-semibold">

                            {{ $nama_kelompok_usia_teratas }}

                        </p>

                    </div>

                </div>

            </div>

        </section>
    </div>

    {{-- Count Pekerjaan --}}
    @php
        $colors = ['#0E4F66', '#BE5B3D', '#D6A94A', '#2F7A63', '#1C7293', '#8E6B4F', '#6C8CA6', '#A9683F', '#4C6B5A'];
        $pekerjaanData = [];

        foreach ($pekerjaan as $index => $item) {
            $pekerjaanData[] = [$item->jenis_pekerjaan, (int) $item->total, $colors[$index % count($colors)]];
        }
    @endphp


    <script>
        // JS scrol
        const navbar = document.getElementById("navbar");
        window.addEventListener("scroll", function() {
            if (window.scrollY > 20) {
                navbar.classList.remove("bg-green-700");
                navbar.classList.add("bg-black", "bg-opacity-60", "shadow-lg");
            } else {
                navbar.classList.remove("bg-black", "bg-opacity-60", "shadow-lg");
                navbar.classList.add("bg-green-700");
            }
        });

        // Tema global Highcharts agar selaras dengan identitas visual desa
        Highcharts.setOptions({
            colors: ['#0E4F66', '#BE5B3D', '#D6A94A', '#2F7A63', '#1C7293', '#8E6B4F', '#6C8CA6', '#A9683F',
                '#4C6B5A'
            ],
            chart: {
                style: {
                    fontFamily: "'Plus Jakarta Sans', sans-serif"
                },
                backgroundColor: 'transparent'
            },
            title: {
                style: {
                    fontFamily: "'Fraunces', serif",
                    color: '#1C2B33',
                    fontWeight: '600'
                }
            },
            subtitle: {
                style: {
                    color: '#6b7c85'
                }
            },
            credits: {
                enabled: false
            }
        });

        // JS Diagram Pekerjaan
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('pekerjaanChart', {
                chart: {
                    type: 'item',
                    inverted: true
                },
                title: {
                    text: 'Pekerjaan Warga'
                },
                subtitle: {
                    text: 'Distribusi pekerjaan mayoritas warga Desa Galesong Timur'
                },
                legend: {
                    labelFormat: '{name} <span style="opacity: 0.4">({y})</span>'
                },
                series: [{
                    name: 'Jumlah Warga',
                    keys: ['name', 'y', 'color'],
                    data: {!! json_encode($pekerjaanData) !!},
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }]
            });
        });

        // JS Diagram Pendidikan
        document.addEventListener('DOMContentLoaded', function() {
            const dataPendidikan = @json(
                $pendidikan->map(function ($item) {
                    return [
                        'name' => strtoupper($item->pendidikan),
                        'y' => $item->total,
                    ];
                }));

            Highcharts.chart('pendidikanChart', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: 'Pendidikan Warga'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y} orang</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: ' orang'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: dataPendidikan
                }]
            });
        });


        // JS Diagram Kelompok Usia

        const dataKelompokUsia = @json($kelompokUsia);

        const kategoriUsia = Object.keys(dataKelompokUsia);

        const dataPerempuan = kategoriUsia.map(function(kelompok) {
            return dataKelompokUsia[kelompok]['Perempuan'];
        });

        const dataLakiLaki = kategoriUsia.map(function(kelompok) {
            return dataKelompokUsia[kelompok]['Laki-laki'];
        });

        Highcharts.chart('usiaChart', {

            chart: {
                type: 'bar'
            },

            title: {
                text: 'Kelompok Usia Warga'
            },

            xAxis: {
                categories: kategoriUsia,
                title: {
                    text: null
                }
            },

            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah',
                    align: 'high'
                },
                allowDecimals: false
            },

            tooltip: {
                valueSuffix: ' orang'
            },

            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    }
                }
            },

            legend: {
                reversed: true
            },

            series: [{
                    name: 'Perempuan',
                    color: '#1C7293',
                    data: dataPerempuan
                },
                {
                    name: 'Laki-laki',
                    color: '#BE5B3D',
                    data: dataLakiLaki
                }
            ]

        });


        // Ajax Agama
        const agamaData = @json(
            $agama->map(fn($a) => [
                    'name' => $a->agama,
                    'y' => $a->total,
                ]));
        Highcharts.chart('agamaChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Agama'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y} orang</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: ' orang'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y}'
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: agamaData
            }]
        });


        // ==================================================
        // JS DIAGRAM STATUS PERKAWINAN
        // ==================================================

        document.addEventListener('DOMContentLoaded', function() {

            const rawData = @json($perkawinan);

            // Ubah data Laravel menjadi format Highcharts
            const perkawinanData = rawData.map(function(item) {
                return {
                    name: item.status_perkawinan,
                    y: Number(item.total)
                };
            });

            console.log('Data Status Perkawinan:', perkawinanData);


            // ==================================================
            // CEK JIKA DATA KOSONG
            // ==================================================

            if (perkawinanData.length === 0) {

                document.getElementById('perkawinanChart').innerHTML = `
            <div class="flex items-center justify-center h-full text-gray-500">
                Data status perkawinan belum tersedia.
            </div>
        `;

                return;
            }


            // ==================================================
            // HIGHCHARTS
            // ==================================================

            Highcharts.chart('perkawinanChart', {

                chart: {
                    type: 'pie'
                },

                title: {
                    text: 'Status Perkawinan Warga'
                },

                tooltip: {
                    pointFormat: '<b>{point.y} orang</b>'
                },

                accessibility: {
                    point: {
                        valueSuffix: ' orang'
                    }
                },

                plotOptions: {
                    pie: {

                        innerSize: '60%',

                        allowPointSelect: true,

                        cursor: 'pointer',

                        showInLegend: true,

                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y} orang'
                        }
                    }
                },

                legend: {
                    enabled: true
                },

                series: [{
                    name: 'Jumlah Warga',
                    colorByPoint: true,
                    data: perkawinanData
                }]

            });

        });
    </script>
@endsection
