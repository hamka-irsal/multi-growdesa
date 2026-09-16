@extends('landing.layouts.app')

@section('content')
<section class="bg-gray-50 py-16 px-4 md:px-8 pt-[80px]">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Produk Unggulan Desa</h2>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($produk as $product)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_produk }}" class="w-full h-56 object-cover">
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product->nama_produk }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->deskripsi }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-primary font-bold text-lg">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <a href="{{ route('landing.belanja.show', $product->id) }}"
                               class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-md transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection