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

        .profil-wrap {
            font-family: var(--font-body);
            color: var(--clr-ink);
            background: var(--clr-cream);
        }

        .profil-wrap h1,
        .profil-wrap h2,
        .profil-wrap h3,
        .profil-wrap .font-display {
            font-family: var(--font-display);
        }

        .profil-wrap .font-mono {
            font-family: var(--font-mono);
        }

        .eyebrow {
            font-family: var(--font-mono);
            letter-spacing: .18em;
            text-transform: uppercase;
            font-size: .72rem;
            font-weight: 600;
        }

        .terrace-divider {
            display: block;
            width: 100%;
            height: 56px;
            line-height: 0;
        }

        .terrace-divider svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .info-chip {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: #fff;
            border: 1px solid rgba(31, 75, 59, 0.1);
            border-radius: 12px;
            padding: .7rem 1rem;
        }

        .info-chip svg {
            width: 18px;
            height: 18px;
            color: var(--clr-forest);
            flex-shrink: 0;
        }

        .visi-card {
            background: var(--clr-forest-deep);
            border-radius: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .visi-card::before {
            content: '\201C';
            position: absolute;
            top: -1.2rem;
            left: 1.2rem;
            font-family: var(--font-display);
            font-size: 8rem;
            color: rgba(217, 164, 65, 0.18);
            line-height: 1;
        }

        .misi-list {
            counter-reset: misi;
        }

        .misi-item {
            counter-increment: misi;
            position: relative;
            padding-left: 3.2rem;
            background: #fff;
            border: 1px solid rgba(31, 75, 59, 0.08);
            border-radius: 1rem;
            padding-top: 1.2rem;
            padding-bottom: 1.2rem;
            padding-right: 1.2rem;
        }

        .misi-item::before {
            content: counter(misi, decimal-leading-zero);
            position: absolute;
            left: 1.2rem;
            top: 1.2rem;
            font-family: var(--font-mono);
            font-weight: 600;
            font-size: .8rem;
            color: var(--clr-gold);
            background: var(--clr-forest-deep);
            width: 1.9rem;
            height: 1.9rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .batas-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .75rem 0;
            border-bottom: 1px solid rgba(28, 42, 34, 0.1);
        }

        .batas-row:last-child {
            border-bottom: none;
        }

        .batas-dir {
            font-family: var(--font-mono);
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--clr-clay);
        }

        .sosmed-pill {
            display: flex;
            align-items: center;
            gap: .85rem;
            background: #fff;
            border: 1px solid rgba(31, 75, 59, 0.1);
            border-radius: 14px;
            padding: .9rem 1.1rem;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .sosmed-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px -16px rgba(28, 42, 34, 0.35);
        }

        .sosmed-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>

    <div class="profil-wrap">

        <!-- HERO SECTION -->
        <section class="pt-[1px]">
            <div class="relative w-full h-64 md:h-[420px]">
                <img src="assets/img/bg-landing.png" alt="Latar Desa" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4"
                    style="background: linear-gradient(180deg, rgba(18,48,39,0.35) 0%, rgba(18,48,39,0.75) 100%);">
                    <p class="eyebrow mb-3" style="color: var(--clr-gold-soft);">Kecamatan Galesong Timur &middot; Kabupaten
                        Takalar</p>
                    <h2 class="text-white text-3xl md:text-5xl font-semibold">Profil Desa Galesong Timur</h2>
                </div>
            </div>
            <div class="terrace-divider">
                <svg viewBox="0 0 1200 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0,56 L0,36 L200,36 L200,24 L400,24 L400,12 L600,12 L600,4 L800,4 L800,12 L1000,12 L1000,24 L1200,24 L1200,56 Z"
                        fill="var(--clr-cream)" />
                </svg>
            </div>
        </section>

        <!-- PROFIL SECTION -->
        <section class="py-16" style="background: var(--clr-cream);">
            <div class="max-w-6xl mx-auto px-6 md:px-12 grid md:grid-cols-2 gap-12 items-center">
                <img src="assets/img/bg-desa.png" alt="Ilustrasi Desa" class="w-full rounded-2xl shadow-lg" />
                <div>
                    <p class="eyebrow mb-2" style="color: var(--clr-clay);">Desa Digital</p>
                    <h2 class="text-4xl font-semibold mb-5" style="color: var(--clr-forest-deep);">Sejarah Desa Galesong
                        Timur</h2>
                    <p class="leading-relaxed mb-7" style="color: rgba(28,42,34,0.75);">
                        Desa Galesong Timur adalah desa definitif baru di Kecamatan Galesong, Takalar, Sulawesi Selatan,
                        yang resmi berdiri pada 22 September 2022 hasil pemekaran dari Galesong Baru dan Galesong Kota,
                        berakar dari wilayah Kesultanan Gowa yang kaya sejarah, terutama terkait sosok Karaeng Galesong yang
                        jadi panglima perang dan tokoh pembentukan Kabupaten Takalar, serta tradisi nelayan kuat dengan
                        upacara adat Islam seperti Songkabala dan Pammaca Doangan.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="info-chip">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm font-medium">Kode POS: 92361</span>
                        </div>
                        <div class="info-chip">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-sm font-medium">+6285xxxxxxx</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VISI MISI -->
        <section class="max-w-5xl mx-auto px-4 py-16">
            <p class="eyebrow text-center mb-3" style="color: var(--clr-clay);">Arah Pembangunan</p>
            <h2 class="text-4xl font-semibold text-center mb-12" style="color: var(--clr-forest-deep);">Visi & Misi Desa
                Galesong Timur</h2>

            <!-- VISI -->
            <div class="visi-card px-8 py-12 mb-14 text-center">
                <p class="eyebrow relative z-10 mb-4" style="color: var(--clr-gold-soft);">Visi</p>
                <p
                    class="relative z-10 text-xl md:text-2xl font-display italic text-white leading-relaxed max-w-2xl mx-auto">
                    Desa Galesong Timur Menuju Era Digitalisasi di Tahun 2026
                </p>
            </div>

            <!-- MISI -->
            <div>
                <h3 class="text-2xl font-semibold text-center mb-8" style="color: var(--clr-forest-deep);">Misi</h3>
                <div class="misi-list space-y-4">
                    <div class="misi-item text-justify leading-relaxed" style="color: rgba(28,42,34,0.8);">
                        Menerapkan sistem pemerintahan berbasis digital untuk pelayanan publik yang lebih cepat dan
                        transparan.
                    </div>
                    <div class="misi-item text-justify leading-relaxed" style="color: rgba(28,42,34,0.8);">
                        Meningkatkan kapasitas sumber daya manusia (SDM) desa dalam memanfaatkan teknologi digital.
                    </div>
                    <div class="misi-item text-justify leading-relaxed" style="color: rgba(28,42,34,0.8);">
                        Mengembangkan potensi ekonomi lokal melalui platform digital (e-commerce, promosi online).
                    </div>
                    <div class="misi-item text-justify leading-relaxed" style="color: rgba(28,42,34,0.8);">
                        Menciptakan tata kelola desa yang profesional, akuntabel, dan partisipatif dengan dukungan teknologi
                        informasi.
                    </div>
                </div>
            </div>
        </section>

        <div class="terrace-divider" style="transform: scaleY(-1);">
            <svg viewBox="0 0 1200 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0,56 L0,36 L200,36 L200,24 L400,24 L400,12 L600,12 L600,4 L800,4 L800,12 L1000,12 L1000,24 L1200,24 L1200,56 Z"
                    fill="var(--clr-forest-deep)" />
            </svg>
        </div>

        <!-- Denah Lokasi -->
        <section class="py-16 px-4" style="background: var(--clr-forest-deep);">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <!-- Peta Lokasi (Leaflet) -->
                <div class="flex justify-center">
                    <div class="w-full">
                        <div id="peta-desa" class="w-full h-96 md:h-[500px] rounded-2xl shadow-lg overflow-hidden"
                            style="border: 3px solid rgba(217,164,65,0.4);">
                        </div>

                        <!-- Legenda Icon -->
                        <div class="flex flex-wrap gap-4 mt-4 px-1">
                            <div class="flex items-center gap-2 text-sm text-white/75">
                                <span class="text-lg">📍</span> Kantor Desa
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/75">
                                <span class="text-lg">🕌</span> Masjid
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/75">
                                <span class="text-lg">🏫</span> Sekolah
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/75">
                                <span class="text-lg">⛽</span> SPBU
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lokasi -->
                <div>
                    <p class="eyebrow mb-3" style="color: var(--clr-gold-soft);">Denah &amp; Batas Wilayah</p>
                    <h2 class="text-4xl font-semibold mb-5 text-white">Peta Lokasi Desa Galesong Timur</h2>
                    <p class="mb-7 text-white/75 leading-relaxed">
                        Desa Galesong Timur terletak di Kecamatan Galesong Timur, Kabupaten Takalar, Provinsi Sulawesi
                        Selatan,
                        Indonesia. Kantor Desa Galesong Timur beralamat di Dusun Erang Baji.
                    </p>
                    <div class="rounded-2xl px-6"
                        style="background: rgba(251,246,234,0.06); border:1px solid rgba(251,246,234,0.12);">
                        <div class="batas-row">
                            <span class="batas-dir">Utara</span>
                            <span class="text-white/85 font-medium">Takalar</span>
                        </div>
                        <div class="batas-row">
                            <span class="batas-dir">Selatan</span>
                            <span class="text-white/85 font-medium">Takalar</span>
                        </div>
                        <div class="batas-row">
                            <span class="batas-dir">Timur</span>
                            <span class="text-white/85 font-medium">Takalar</span>
                        </div>
                        <div class="batas-row">
                            <span class="batas-dir">Barat</span>
                            <span class="text-white/85 font-medium">Takalar</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Koordinat pusat Galesong Timur (sesuai link Google Maps)
                const pusatDesa = [-5.3180698, 119.3738166];

                const map = L.map('peta-desa', {
                    scrollWheelZoom: false,
                }).setView(pusatDesa, 16); // zoom 16 supaya nama jalan tampil jelas

                // Tile OpenStreetMap standar — gratis, tanpa API key, menampilkan jalan + nama jalan
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19,
                }).addTo(map);

                // ===== Pin utama ala Google Maps (teardrop merah) =====
                function pinUtama() {
                    return L.divIcon({
                        html: `
                            <svg width="34" height="46" viewBox="0 0 34 46" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 0C7.6 0 0 7.6 0 17c0 12.7 17 29 17 29s17-16.3 17-29C34 7.6 26.4 0 17 0z"
                                    fill="#EA4335"/>
                                <circle cx="17" cy="17" r="7" fill="#ffffff"/>
                            </svg>`,
                        className: '',
                        iconSize: [34, 46],
                        iconAnchor: [17, 46],
                        popupAnchor: [0, -40],
                    });
                }

                // ===== Icon tempat penting (bulat, gaya khas Google POI) =====
                function iconTempat(emoji, warna) {
                    return L.divIcon({
                        html: `<div style="
                            background: ${warna};
                            border: 2px solid #ffffff;
                            border-radius: 50%;
                            width: 32px; height: 32px;
                            display: flex; align-items: center; justify-content: center;
                            font-size: 16px;
                            box-shadow: 0 2px 5px rgba(0,0,0,0.35);
                        ">${emoji}</div>`,
                        className: '',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16],
                        popupAnchor: [0, -16],
                    });
                }

                // Marker lokasi utama (Kantor Desa / titik Galesong Timur)
                L.marker(pusatDesa, {
                        icon: pinUtama()
                    })
                    .addTo(map)
                    .bindPopup('<strong>Galesong Timur</strong>')
                    .openPopup();

                // Data tempat penting — sesuaikan koordinat & nama sesuai lokasi nyata
                const tempatPenting = [{
                        nama: 'Mesjid Nurul Ikhsan',
                        lat: -5.317600,
                        lng: 119.376500,
                        icon: '🕌',
                        warna: '#1c8f4d'
                    },
                    {
                        nama: 'SPBU Galesong Kota',
                        lat: -5.317900,
                        lng: 119.375900,
                        icon: '⛽',
                        warna: '#4285F4'
                    },
                    {
                        nama: 'SMP Negeri 2 Galesong',
                        lat: -5.319600,
                        lng: 119.371000,
                        icon: '🏫',
                        warna: '#4285F4'
                    },
                    {
                        nama: "Sd Inpres Ta'mala'lang",
                        lat: -5.317400,
                        lng: 119.377800,
                        icon: '🏫',
                        warna: '#4285F4'
                    },
                    {
                        nama: 'Alfamidi Galesong',
                        lat: -5.316200,
                        lng: 119.370500,
                        icon: '🛒',
                        warna: '#e64a19'
                    },
                ];

                tempatPenting.forEach(function(tempat) {
                    L.marker([tempat.lat, tempat.lng], {
                            icon: iconTempat(tempat.icon, tempat.warna)
                        })
                        .addTo(map)
                        .bindPopup(`<strong>${tempat.nama}</strong>`);
                });
            });
        </script>

        <!-- Sosmed -->
        <section class="py-20 px-4 md:px-20" style="background: var(--clr-cream);">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Konten Kiri -->
                <div>
                    <p class="eyebrow mb-3" style="color: var(--clr-clay);">Terhubung Dengan Kami</p>
                    <h2 class="text-4xl font-semibold mb-5" style="color: var(--clr-forest-deep);">Sosial Media</h2>
                    <p class="mb-7" style="color: rgba(28,42,34,0.75);">
                        Berikut adalah link menuju sosial media resmi Desa Kambuno yang dikelola langsung oleh admin Kantor
                        Desa:
                    </p>
                    <div class="space-y-3">
                        <a href="https://www.facebook.com/pemdes.barana" target="_blank" class="sosmed-pill">
                            <div class="sosmed-icon" style="background: rgba(31,75,59,0.1);">
                                <svg class="w-5 h-5" style="color:#1F4B3B;" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 011-1h3v-4h-3a5 5 0 00-5 5v2.01h-2l-.396 3.98h2.396v8.01z" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs uppercase tracking-wide" style="color: rgba(28,42,34,0.5);">Facebook</p>
                                <p class="text-sm font-medium truncate" style="color: var(--clr-ink);">
                                    facebook.com/pemdes.barana</p>
                            </div>
                        </a>
                        <a href="https://www.instagram.com/p/Cl0FjAyrrsu/?igshid=MDJmNzVkMjY=" target="_blank"
                            class="sosmed-pill">
                            <div class="sosmed-icon" style="background: rgba(168,90,52,0.12);">
                                <svg class="w-5 h-5" style="color: var(--clr-clay);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2" />
                                    <circle cx="12" cy="12" r="4" stroke-width="2" />
                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs uppercase tracking-wide" style="color: rgba(28,42,34,0.5);">Instagram
                                </p>
                                <p class="text-sm font-medium truncate" style="color: var(--clr-ink);">Lihat postingan
                                    desa</p>
                            </div>
                        </a>
                        <a href="https://www.youtube.com/watch?v=YqmRjPYHEqo" target="_blank" class="sosmed-pill">
                            <div class="sosmed-icon" style="background: rgba(217,164,65,0.16);">
                                <svg class="w-5 h-5" style="color: var(--clr-clay);" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M21.582 7.203a2.51 2.51 0 00-1.767-1.777C18.254 5 12 5 12 5s-6.254 0-7.815.426A2.51 2.51 0 002.418 7.203 26.19 26.19 0 002 12a26.19 26.19 0 00.418 4.797 2.51 2.51 0 001.767 1.777C5.746 19 12 19 12 19s6.254 0 7.815-.426a2.51 2.51 0 001.767-1.777A26.19 26.19 0 0022 12a26.19 26.19 0 00-.418-4.797zM10 15V9l5.196 3L10 15z" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs uppercase tracking-wide" style="color: rgba(28,42,34,0.5);">Youtube</p>
                                <p class="text-sm font-medium truncate" style="color: var(--clr-ink);">Tonton video profil
                                    desa</p>
                            </div>
                        </a>
                        <a href="mailto:desagalesongtimur@gmail.com" class="sosmed-pill">
                            <div class="sosmed-icon" style="background: rgba(31,75,59,0.1);">
                                <svg class="w-5 h-5" style="color:#1F4B3B;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs uppercase tracking-wide" style="color: rgba(28,42,34,0.5);">Email</p>
                                <p class="text-sm font-medium truncate" style="color: var(--clr-ink);">
                                    desagalesongtimura@gmail.com</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Gambar Kanan -->
                <div class="flex justify-center">
                    <img src="assets/img/sosmed.jpg" alt="Social Media Illustration"
                        class="max-w-md w-full rounded-2xl shadow-lg">
                </div>
            </div>
        </section>

    </div>
@endsection
