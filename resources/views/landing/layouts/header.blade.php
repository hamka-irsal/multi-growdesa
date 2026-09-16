<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full z-20 bg-black bg-opacity-60 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.5)]" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center text-white">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <img src="/assets/img/logo_takalar.png" alt="Logo" class="w-12 h-12" />
            <div class="text-sm leading-tight">
                <p class="font-bold text-lg">DESA GALESONG TIMUR</p>
                <p class="hidden sm:block">Kecamatan Galesong, Kabupaten Takalar</p>
            </div>
        </div>

        <!-- Hamburger button -->
        <button @click="open = !open" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" :class="{'hidden': open, 'block': !open}" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{'block': open, 'hidden': !open}" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Menu items (desktop) -->
        <ul class="hidden md:flex space-x-6 font-semibold">
            <li><a href="{{ route('landing.home') }}" class="hover:text-yellow-400">Beranda</a></li>
            <li><a href="{{ route('landing.profil.index') }}" class="hover:text-yellow-400">Profil</a></li>
            <li><a href="{{ route('landing.statistik.index') }}" class="hover:text-yellow-400">Statistik</a></li>
            <li><a href="{{ route('landing.belanja.index') }}" class="hover:text-yellow-400">Belanja</a></li>
            <li><a href="{{ route('landing.berita.index') }}" class="hover:text-yellow-400">Berita</a></li>
            {{-- <li>
                <a href="{{ route('landing.surat.index') }}" class="bg-green-500 px-4 py-2 rounded-full hover:bg-green-600 text-white">
                    📑 Buat Surat
                </a>
            </li>
            <li>
                <a href="{{ route('landing.riwayat.form') }}" class="bg-blue-500 px-4 py-2 rounded-full hover:bg-blue-600 text-white">
                    🔍 Cek Status Surat
                </a>
            </li> --}}
        </ul>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="md:hidden bg-black bg-opacity-90 text-white px-4 pb-4 space-y-4 font-semibold">
        <a href="{{ route('landing.home') }}" class="block hover:text-yellow-400">Beranda</a>
        <a href="{{ route('landing.profil.index') }}" class="block hover:text-yellow-400">Profil</a>
        <a href="{{ route('landing.statistik.index') }}" class="block hover:text-yellow-400">Statistik</a>
        <a href="{{ route('landing.belanja.index') }}" class="block hover:text-yellow-400">Belanja</a>
        <a href="{{ route('landing.berita.index') }}" class="block hover:text-yellow-400">Berita</a>
        {{-- <a href="{{ route('landing.surat.index') }}" class="block bg-green-500 px-4 py-2 rounded-full hover:bg-green-600 text-white" id="btnCekStatus">📑 Buat Surat</a>
        <a href="{{ route('landing.riwayat.form') }}" class="block bg-blue-500 px-4 py-2 rounded-full hover:bg-blue-600 text-white">🔍 Cek Status Surat</a> --}}
    </div>
</nav>
