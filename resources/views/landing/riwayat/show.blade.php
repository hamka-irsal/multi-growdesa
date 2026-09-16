<!-- resources/views/riwayat/show.blade.php -->
@extends('landing.layouts.app')
@section('content')
    <section class="py-10 px-4 md:px-10 bg-gray-50 min-h-screen pt-[100px]">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📄 Riwayat Surat untuk NIK: {{ $nik }}</h2>

            <div class="overflow-x-auto bg-white shadow-md rounded-2xl">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-3 py-2">No</th>
                            <th class="px-6 py-4">Jenis Surat</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($surat as $index => $s)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $s->jenisSurat->nama_jenis ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    {{ isset($s->tanggal_pengajuan) ? \Carbon\Carbon::parse($s->tanggal_pengajuan)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($s->status_surat == 'selesai')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 text-xs rounded-full">✅
                                            Selesai</span>
                                    @elseif($s->status_surat == 'proses')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 text-xs rounded-full">⏳
                                            Diproses</span>
                                    @elseif($s->status_surat == 'tolak')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 text-xs rounded-full">❌
                                            Ditolak</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 text-xs rounded-full">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{-- <a href="{{ route('surat.lihat', $s->id) }}"
                                        class="text-blue-600 hover:underline">Lihat</a> --}}

                                    @if ($s->status_surat == 'selesai')
                                        <a href="{{ route('landing.riwayat.cetak', ['id' => $s->id]) }}" target="_blank"
                                            class="ml-4 text-green-600 hover:underline">
                                            🖨️ Cetak
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat surat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
