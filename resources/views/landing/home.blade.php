@extends('landing.layouts.app')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --clr-cream: #FBF6EA;
            --clr-cream-deep: #F3EAD6;
            --clr-forest: #1F4B3B;
            --clr-forest-deep: #123027;
            --clr-gold: #D9A441;
            --clr-gold-soft: #F1D48C;
            --clr-clay: #A85A34;
            --clr-ink: #1C2A22;
            --font-display: 'Fraunces', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        .beranda-wrap {
            font-family: var(--font-body);
            color: var(--clr-ink);
            background: var(--clr-cream);
        }

        .beranda-wrap h1,
        .beranda-wrap h2,
        .beranda-wrap h3,
        .beranda-wrap .font-display {
            font-family: var(--font-display);
        }

        .beranda-wrap .font-mono {
            font-family: var(--font-mono);
        }

        .eyebrow {
            font-family: var(--font-mono);
            letter-spacing: .18em;
            text-transform: uppercase;
            font-size: .72rem;
            font-weight: 600;
        }

        /* --- Signature element: terasering (rice-terrace) divider --- */
        .terrace-divider {
            display: block;
            width: 100%;
            height: 64px;
            line-height: 0;
        }

        .terrace-divider svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* Hero */
        .hero-quote {
            border-left: 3px solid var(--clr-gold);
            padding-left: 1.1rem;
        }

        .hero-cta {
            background: var(--clr-gold);
            color: var(--clr-forest-deep);
            font-weight: 700;
            transition: transform .18s ease, background .18s ease;
        }

        .hero-cta:hover {
            background: var(--clr-gold-soft);
            transform: translateY(-1px);
        }

        /* Feature cards */
        .feature-card {
            background: #fff;
            border: 1px solid rgba(31, 75, 59, 0.08);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 32px -18px rgba(31, 75, 59, 0.35);
            border-color: rgba(217, 164, 65, 0.5);
        }

        .feature-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stat rings (data-accurate donut, not decorative circles) */
        .stat-ring {
            width: 84px;
            height: 84px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(var(--ring-color) calc(var(--pct) * 1%), rgba(28, 42, 34, 0.08) 0);
            flex-shrink: 0;
        }

        .stat-ring-inner {
            width: 62px;
            height: 62px;
            border-radius: 9999px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-mono);
            font-weight: 600;
            font-size: .72rem;
            color: var(--clr-ink);
        }

        /* Berita cards */
        .berita-card {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            box-shadow: 0 14px 30px -18px rgba(28, 42, 34, 0.4);
        }

        .berita-card img {
            transition: transform .5s ease;
        }

        .berita-card:hover img {
            transform: scale(1.07);
        }

        .berita-overlay {
            background: linear-gradient(180deg, rgba(18, 48, 39, 0) 30%, rgba(18, 48, 39, 0.92) 100%);
        }

        .berita-date-badge {
            font-family: var(--font-mono);
            background: rgba(251, 246, 234, 0.92);
            color: var(--clr-forest-deep);
        }

        .read-more-link {
            position: relative;
            display: inline-block;
        }

        .read-more-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: var(--clr-gold);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform .25s ease;
        }

        .read-more-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
    </style>

    <body class="beranda-wrap">

        <!-- ============ HERO ============ -->
        <section class="relative bg-cover bg-center min-h-screen pt-32" style="background-image: url('/assets/img/bg.jpeg');">
            <!-- Layer gelap: gradasi hutan, bukan hitam datar -->
            <div class="absolute inset-0"
                style="background: linear-gradient(180deg, rgba(18,48,39,0.55) 0%, rgba(18,48,39,0.72) 65%, var(--clr-forest-deep) 100%);">
            </div>

            <div
                class="relative z-10 max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center min-h-[calc(100vh-8rem)]">
                <!-- Teks -->
                <div class="md:w-1/2 text-white">
                    <p class="eyebrow text-[var(--clr-gold-soft)] mb-5">Profil Digital &middot; Desa Galesong Timur</p>
                    <h1 class="text-4xl md:text-6xl font-semibold leading-[1.08] mb-6">
                        Selamat datang di<br />
                        <span style="color: var(--clr-gold-soft);">Galesong Timur</span>
                    </h1>
                    <p class="text-lg mb-7 max-w-xl text-white/90 leading-relaxed">
                        "Selamat datang di website resmi Desa Galesong Timur. Website ini menjadi sarana informasi dan
                        pelayanan publik guna mendukung pemerintahan desa yang transparan dan akuntabel. Danu Adriansyah
                        Kepala Desa Galesong Timur".
                    </p>
                    <p class="hero-quote italic mb-8 text-white/90 font-display text-lg">
                        &ndash; Danu Adriansyah
                    </p>
                    {{-- <a href="#kontak" class="hero-cta inline-block px-7 py-3.5 rounded-full">
                        HUBUNGI KAMI
                    </a> --}}
                </div>

                <!-- Gambar Kepala Desa -->
                <div class="md:w-1/2 mt-10 md:mt-0 flex justify-end items-end">
                    <img src="/assets/img/kepdess.png" alt="Kepala Desa"
                        class="w-80 md:w-[400px] object-contain drop-shadow-2xl" />
                </div>
            </div>

            <!-- Signature terrace divider -->
            <div class="terrace-divider absolute bottom-0 left-0">
                <svg viewBox="0 0 1200 64" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0,64 L0,40 L200,40 L200,26 L400,26 L400,14 L600,14 L600,4 L800,4 L800,14 L1000,14 L1000,26 L1200,26 L1200,64 Z"
                        fill="var(--clr-cream)" />
                </svg>
            </div>
        </section>

        <!-- ============ TENTANG DESA ============ -->
        <section class="py-20" style="background: var(--clr-cream);">
            <div class="max-w-6xl mx-auto px-4 text-center">
                <p class="eyebrow mb-3" style="color: var(--clr-clay);">Kolaborasi Layanan Digital</p>
                <h2 class="text-3xl md:text-4xl font-semibold mb-5" style="color: var(--clr-forest-deep);">Lebih Lanjut
                    Tentang Desa</h2>
                <p class="text-[15px] md:text-base leading-relaxed mb-14 max-w-3xl mx-auto"
                    style="color: rgba(28,42,34,0.75);">
                    Desa Galesong Timur berkomitmen untuk meningkatkan kualitas pelayanan kepada masyarakat. Dalam upaya
                    ini,
                    kami menjalin kerja sama dengan <b>growdesa</b> untuk menghadirkan layanan digital yang menyediakan
                    berbagai fitur administrasi. Sistem ini dirancang guna mempermudah perangkat desa dan warga dalam
                    mengakses serta mengelola layanan administrasi secara lebih efisien.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">

                    <!-- Struktur Pemerintahan -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(31,75,59,0.1);">
                            <svg class="w-6 h-6" style="color: var(--clr-forest);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 3v3.5M12 6.5a2 2 0 100 4 2 2 0 000-4zM6 20v-3a2 2 0 012-2h8a2 2 0 012 2v3M8.5 20v-2M15.5 20v-2M4 20h16" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Struktur Pemerintahan
                        </h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Susunan lengkap perangkat desa beserta tugas
                            dan wewenangnya.</p>
                    </div>

                    <!-- Visi & Misi -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(217,164,65,0.16);">
                            <svg class="w-6 h-6" style="color: var(--clr-clay);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 21a9 9 0 100-18 9 9 0 000 18zM12 17a5 5 0 100-10 5 5 0 000 10zM12 13.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Visi & Misi</h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Arah pembangunan jangka panjang yang menjadi
                            pedoman desa.</p>
                    </div>

                    <!-- Cek Bansos -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(31,75,59,0.1);">
                            <svg class="w-6 h-6" style="color: var(--clr-forest);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-9 0h10a1 1 0 011 1v11a2 2 0 01-2 2H8a2 2 0 01-2-2V8a1 1 0 011-1zM9.5 13l2 2 3.5-3.5" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Cek Bansos</h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Periksa status penerima bantuan sosial secara
                            mandiri dan cepat.</p>
                    </div>

                    <!-- Program Pembangunan -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(217,164,65,0.16);">
                            <svg class="w-6 h-6" style="color: var(--clr-clay);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 21h16M6 21V10l4-3v14M14 21V6l4 2v13M10 13h.01M10 16h.01" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Program Pembangunan
                            Desa</h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Progres proyek dan program pembangunan yang
                            sedang berjalan.</p>
                    </div>

                    <!-- Laporan Dana -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(31,75,59,0.1);">
                            <svg class="w-6 h-6" style="color: var(--clr-forest);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M7 3h7l4 4v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1zM14 3v4h4M9 17v-3M12 17v-5M15 17v-2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Laporan Dana Desa
                        </h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Transparansi penggunaan anggaran desa yang
                            dapat diakses publik.</p>
                    </div>

                    <!-- Lembaga Kemasyarakatan -->
                    <div class="feature-card rounded-2xl p-7">
                        <div class="feature-icon-badge mb-5" style="background: rgba(217,164,65,0.16);">
                            <svg class="w-6 h-6" style="color: var(--clr-clay);" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9 11a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM16.5 11a2.2 2.2 0 100-4.4 2.2 2.2 0 000 4.4zM3.5 19.5c.4-2.6 2.4-4.5 5.5-4.5s5.1 1.9 5.5 4.5M14 15.3c2.4.3 4 1.9 4.3 4.2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: var(--clr-forest-deep);">Lembaga
                            Kemasyarakatan</h3>
                        <p class="text-sm" style="color: rgba(28,42,34,0.65);">Organisasi warga yang aktif mendukung
                            kegiatan desa.</p>
                    </div>

                </div>

                <style>
                    /* Sentuhan tambahan agar badge & kartu terasa lebih hidup - tempel sekali di CSS global, boleh dihapus jika sudah ada style serupa */
                    .feature-icon-badge {
                        width: 52px;
                        height: 52px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 14px;
                        transition: transform 0.25s ease;
                    }

                    .feature-card {
                        transition: transform 0.25s ease, box-shadow 0.25s ease;
                    }

                    .feature-card:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 12px 24px -8px rgba(28, 42, 34, 0.15);
                    }

                    .feature-card:hover .feature-icon-badge {
                        transform: scale(1.08);
                    }
                </style>
            </div>
        </section>

        <div class="terrace-divider" style="transform: scaleY(-1);">
            <svg viewBox="0 0 1200 64" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0,64 L0,40 L200,40 L200,26 L400,26 L400,14 L600,14 L600,4 L800,4 L800,14 L1000,14 L1000,26 L1200,26 L1200,64 Z"
                    fill="var(--clr-forest-deep)" />
            </svg>
        </div>


        <!-- ============ INFOGRAFIS ============ -->
        <section class="py-16 px-4" style="background: var(--clr-forest-deep);">
            <div class="max-w-6xl mx-auto">

                <!-- Heading -->
                <p class="eyebrow mb-3 text-center" style="color: var(--clr-gold-soft);">
                    Data Kependudukan
                </p>

                <h2 class="text-3xl font-semibold text-center mb-12 text-white">
                    Infografis Desa
                </h2>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- ===================================== -->
                    <!-- STATISTIK PENDUDUK -->
                    <!-- ===================================== -->
                    <div class="space-y-5">

                        <!-- ============================== -->
                        <!-- TOTAL PENDUDUK -->
                        <!-- ============================== -->
                        <div class="flex items-center p-6 rounded-2xl"
                            style="
                        background: rgba(251,246,234,0.06);
                        border: 1px solid rgba(251,246,234,0.12);
                    ">

                            <div class="stat-ring"
                                style="
                            --pct: 100;
                            --ring-color: var(--clr-gold);
                        ">

                                <div class="stat-ring-inner">
                                    100%
                                </div>

                            </div>

                            <div class="ml-6">

                                <p class="text-3xl font-mono font-semibold text-white">
                                    {{ number_format($totalPenduduk, 0, ',', '.') }}
                                </p>

                                <p class="text-base text-white/70">
                                    Total Penduduk
                                </p>

                            </div>

                        </div>


                        <!-- ============================== -->
                        <!-- PENDUDUK PRIA -->
                        <!-- ============================== -->
                        <div class="flex items-center p-6 rounded-2xl"
                            style="
                        background: rgba(251,246,234,0.06);
                        border: 1px solid rgba(251,246,234,0.12);
                    ">

                            <div class="stat-ring"
                                style="
                            --pct: {{ $persentasePria }};
                            --ring-color: #6FA9D8;
                        ">

                                <div class="stat-ring-inner">
                                    {{ $persentasePria }}%
                                </div>

                            </div>

                            <div class="ml-6">

                                <p class="text-3xl font-mono font-semibold text-white">
                                    {{ number_format($totalPria, 0, ',', '.') }}
                                </p>

                                <p class="text-base text-white/70">
                                    Penduduk Pria
                                </p>

                            </div>

                        </div>


                        <!-- ============================== -->
                        <!-- PENDUDUK WANITA -->
                        <!-- ============================== -->
                        <div class="flex items-center p-6 rounded-2xl"
                            style="
                        background: rgba(251,246,234,0.06);
                        border: 1px solid rgba(251,246,234,0.12);
                    ">

                            <div class="stat-ring"
                                style="
                            --pct: {{ $persentaseWanita }};
                            --ring-color: #E08FA6;
                        ">

                                <div class="stat-ring-inner">
                                    {{ $persentaseWanita }}%
                                </div>

                            </div>

                            <div class="ml-6">

                                <p class="text-3xl font-mono font-semibold text-white">
                                    {{ number_format($totalWanita, 0, ',', '.') }}
                                </p>

                                <p class="text-base text-white/70">
                                    Penduduk Wanita
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- ===================================== -->
                    <!-- GRAFIK PEKERJAAN -->
                    <!-- ===================================== -->
                    <div class="rounded-2xl p-5" style="background: var(--clr-cream);">

                        <div id="chart-pekerjaan" class="w-full h-[400px]">
                        </div>

                    </div>

                </div>


                <!-- ===================================== -->
                <!-- BUTTON STATISTIK -->
                <!-- ===================================== -->
                <div class="mt-12 flex justify-center">

                    <a href="{{ route('landing.statistik.index') }}" class="hero-cta py-3.5 px-7 rounded-full shadow-lg">

                        Lihat Selengkapnya

                    </a>

                </div>

            </div>
        </section>


        <!-- ============ BERITA ============ -->
        <section class="py-20" style="background: var(--clr-cream);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="eyebrow mb-3 text-center" style="color: var(--clr-clay);">Kabar Terbaru</p>
                <h2 class="text-3xl font-semibold text-center mb-12" style="color: var(--clr-forest-deep);">Berita Desa
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($berita as $item)
                        <div class="berita-card group">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}"
                                class="w-full h-64 object-cover">

                            <span
                                class="berita-date-badge absolute top-4 left-4 text-xs font-medium px-3 py-1 rounded-full">
                                {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}
                            </span>

                            <div class="berita-overlay absolute inset-0 flex flex-col justify-end p-5">
                                <h3 class="font-display font-semibold text-lg leading-snug text-white">{{ $item->judul }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('landing.berita.index') }}" class="read-more-link font-semibold text-lg"
                        style="color: var(--clr-forest);">
                        Lihat berita lainnya
                    </a>
                </div>
            </div>
        </section>

    </body>

    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // DATA PEKERJAAN DARI BACKEND / DATABASE
            // ==========================================

            const dataPekerjaan = @json(
                $dataPekerjaan->map(function ($item) {
                        return [
                            'name' => $item->jenis_pekerjaan,
                            'y' => (int) $item->total,
                        ];
                    })->values());

            console.log('Data pekerjaan:', dataPekerjaan);


            // ==========================================
            // HIGHCHARTS
            // ==========================================

            Highcharts.chart('chart-pekerjaan', {

                chart: {
                    type: 'bar',
                    style: {
                        fontFamily: 'Plus Jakarta Sans, sans-serif'
                    }
                },

                title: {
                    text: 'Pekerjaan Warga Desa',
                    style: {
                        fontFamily: 'Fraunces, serif',
                        fontSize: '18px',
                        color: '#1C2A22'
                    }
                },

                colors: ['#1F4B3B'],

                // ======================================
                // KATEGORI DIAMBIL DARI DATABASE
                // ======================================

                xAxis: {
                    type: 'category',
                    title: {
                        text: null
                    }
                },

                yAxis: {
                    min: 0,
                    allowDecimals: false,
                    title: {
                        text: 'Jumlah Warga',
                        align: 'high'
                    }
                },

                tooltip: {
                    valueSuffix: ' orang'
                },

                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        pointPadding: 0.15,
                        groupPadding: 0.1
                    }
                },

                legend: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },

                // ======================================
                // DATA DARI DATABASE
                // ======================================

                series: [{
                    name: 'Jumlah Warga',
                    data: dataPekerjaan,
                    color: '#1F4B3B',
                    negativeColor: '#D9A441'
                }]

            });

        });
    </script>
@endsection
