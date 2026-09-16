<!-- resources/views/riwayat/index.blade.php -->
@extends('landing.layouts.app')
@section('content')
    <section class="flex items-center justify-center py-20 bg-gray-100">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <form action="{{ route('landing.riwayat.cek') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">Masukkan NIK</label>
                    <input type="text" name="nik" maxlength="16" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Cek Riwayat
                </button>
            </form>
        </div>
    </section>
@endsection
