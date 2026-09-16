@extends('landing.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-semibold mb-4">Buat Surat Keterangan Kematian</h2>

        <div class="mb-4">
            <p><strong>Nama:</strong> {{ $penduduk->nama_lengkap }}</p>
            <p><strong>NIK:</strong> {{ $penduduk->nik }}</p>   
            <p><strong>Alamat:</strong> {{ $penduduk->alamat }}</p>
        </div>

        <form action="{{ route('surat.kematian.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nik" value="{{ $penduduk->nik }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Kematian</label>
                <input type="date" name="tanggal" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Penyebab Kematian</label>
                <input type="text" name="penyebab" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tempat Kematian</label>
                <input type="text" name="tempat" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
                Permohonan</button>
        </form>
    </div>
@endsection