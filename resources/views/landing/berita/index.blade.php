@extends('landing.layouts.app')

@section('content')
    <section class="py-12 bg-white px-4 md:px-8 pt-[60px]">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Berita Desa Barana</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach ($berita as $beritas)
                    <div class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition">
                        <div class="space-y-3">
                            <img src="{{ asset('storage/' . $beritas->foto) }}" alt="{{ $beritas->judul }}"
                                class="rounded-xl w-full h-52 object-cover">

                            <p class="text-sm font-semibold text-gray-600">
                                {{ \Carbon\Carbon::parse($beritas->tanggal_publish)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-sm font-semibold text-gray-600">
                                Penulis: {{ $beritas->penulis }}
                            </p>
                            <h3 class="font-semibold text-lg text-gray-800 leading-snug">
                                {{ $beritas->judul }}
                            </h3>

                            <a href="{{ route('landing.berita.show', $beritas->id) }}"
                                class="inline-block mt-2 text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
