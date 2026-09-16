@extends('landing.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-semibold mb-4">Buat Surat Keterangan Izin Potong</h2>

        <div class="mb-4">
            <p><strong>Nama:</strong> {{ $penduduk->nama_lengkap }}</p>
            <p><strong>NIK:</strong> {{ $penduduk->nik }}</p>   
            <p><strong>Alamat:</strong> {{ $penduduk->alamat }}</p>
        </div>

        <form action="{{ route('surat.potong_hewan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nik" value="{{ $penduduk->nik }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Untuk</label>
                <input type="text" name="untuk" class="mt-1 block w-full border rounded-lg px-4 py-2" placeholder="Contoh: Acara Qurban, Syukuran, dll" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jenis Hewan</label>
                <input type="text" name="jenis_hewan" class="mt-1 block w-full border rounded-lg px-4 py-2" placeholder="Contoh: Sapi, Kambing, dll" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Warna Bulu</label>
                <input type="text" name="warna_bulu" class="mt-1 block w-full border rounded-lg px-4 py-2" placeholder="Contoh: Hitam, Coklat, Putih, dll" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanduk</label>
                <select name="tanduk" class="mt-1 block w-full border rounded-lg px-4 py-2" required>
                    <option value="">Pilih status tanduk</option>
                    <option value="Bertanduk">Bertanduk</option>
                    <option value="Tidak Bertanduk">Tidak Bertanduk</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
                Permohonan</button>
        </form>
    </div>
@endsection