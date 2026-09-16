@extends('landing.layouts.app')

@section('content')
    <section class="bg-white py-16 px-4 md:px-8 pt-[100px]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">

            <!-- Gambar Produk -->
            <div class="w-full h-[400px] rounded-2xl overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}"
                    class="w-full h-full object-cover">
            </div>

            <!-- Informasi Produk -->
            <div class="space-y-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $produk->nama_produk }}</h1>

                <p class="text-gray-600 leading-relaxed">
                    {{ $produk->deskripsi }}
                </p>

                <div class="text-2xl font-bold text-green-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>

                <div class="flex gap-4 mt-6">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $produk->kontak) }}" target="_blank"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition inline-block">
                        <b>Hubungi Penjual</b>
                    </a>                    
                    <a href="{{ route('landing.belanja.index') }}" class="text-green-600 hover:underline font-semibold mt-2">Kembali ke Produk</a>
                </div>

                <!-- Info tambahan (opsional) -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Detail Produk</h3>
                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                        <li>kategori: {{ $produk->kategori ?? 'Tidak diketahui' }}</li>
                        <li>Stok: {{ $produk->stok ?? 'N/A' }}</li>
                        <li>Asal Desa: {{ $produk->asal_desa ?? 'Desa tidak terdaftar' }}</li>
                        <li>Kondisi: {{ $produk->condition ?? 'Baru' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
