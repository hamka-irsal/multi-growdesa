@extends('landing.layouts.app')

@section('content')
    <section class="pt-[100px] pb-16 px-4 md:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- Gambar Utama -->
            <div class="mb-6">
                <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}"
                    class="w-full h-[400px] object-cover rounded-xl shadow-md">
            </div>

            <!-- Tanggal & Judul -->
            <div class="mb-4">
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y') }}
                </p>
                <p class="text-sm text-gray-500">
                    Penulis: {{ $berita->penulis }}
                </p>
                <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $berita->judul }}</h1>
            </div>

            <!-- Isi Konten -->
            <div class="prose max-w-none text-gray-800">
                {!! nl2br(e($berita->deskripsi)) !!}
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-10">
                <a href="{{ route('landing.berita.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg transition">
                    ← Kembali ke Berita
                </a>
            </div>
        </div>
    </section>
@endsection
