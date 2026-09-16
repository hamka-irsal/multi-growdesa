@extends('landing.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-semibold mb-4">Buat Surat Keterangan Kehilangan</h2>

        <div class="mb-4">
            <p><strong>Nama:</strong> {{ $penduduk->nama_lengkap }}</p>
            <p><strong>NIK:</strong> {{ $penduduk->nik }}</p>   
            <p><strong>Alamat:</strong> {{ $penduduk->alamat }}</p>
        </div>

        <form action="{{ route('surat.kehilangan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nik" value="{{ $penduduk->nik }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Barang yang Hilang</label>
                <input type="text" name="barang_hilang" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Waktu Kehilangan</label>
                <input type="datetime-local" name="waktu_hilang" class="mt-1 block w-full border rounded-lg px-4 py-2"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tempat Kehilangan</label>
                <input type="text" name="tempat_hilang" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
                Permohonan</button>
        </form>
    </div>
@endsection