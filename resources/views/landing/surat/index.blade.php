@extends('landing.layouts.app')

@section('content')
    <!-- HERO SECTION -->
    <section class="py-10 px-4 md:px-8 bg-gray-50 pt-[50px]">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">📄 List Surat</h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Card Surat Keterangan Kehilangan -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Keterangan Kehilangan</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Digunakan untuk warga yang kehilangan barang dan memerlukan surat.
                    </p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="kehilangan">
                        Buat Surat
                    </button>
                </div>

                <!-- Card Surat Keterangan Kematian -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Keterangan Kematian</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Digunakan untuk konfirmasi data kematian warga untuk keperluan
                        administrasi.</p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="kematian">
                        Buat Surat
                    </button>
                </div>

                <!-- Card Surat Keterangan Usaha -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Keterangan Usaha</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Diperlukan sebagai bukti legalitas usaha untuk pengajuan izin
                        atau bantuan.</p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="usaha">
                        Buat Surat
                    </button>
                </div>

                <!-- Card Surat Keterangan Tidak Mampu -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Keterangan Tidak Mampu</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Digunakan untuk pengajuan bantuan atau keringanan biaya
                        pendidikan/kesehatan.</p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="tidak_mampu">
                        Buat Surat
                    </button>
                </div>

                <!-- Card Surat Izin Potong -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Izin Potong</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Surat izin untuk melakukan pemotongan hewan ternak sesuai dengan
                        ketentuan yang berlaku.</p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="izin_potong">
                        Buat Surat
                    </button>
                </div>

                <!-- Card Surat Izin Pesta -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="bg-blue-100 text-blue-600 p-2 rounded-full flex items-center justify-center shadow-inner">
                            <!-- Icon Surat -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 4h16v16H4z" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M4 4l8 8 8-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Surat Izin Pesta</h3>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">Izin untuk menyelenggarakan acara/pesta di lingkungan desa.</p>

                    <button class="w-full text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl"
                        data-surat="izin_pesta">
                        Buat Surat
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal NIK (sekarang digunakan untuk semua jenis surat) -->
        <div id="modalNIK" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <!-- Modal box -->
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Masukkan NIK</h2>
                <p id="modalSubtitle" class="text-sm text-gray-600 mb-4">Silakan masukkan NIK untuk membuat surat</p>

                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK:</label>
                    <input type="text" id="nik"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 320101XXXXXXXXXX">
                </div>

                <div class="flex justify-end space-x-2">
                    <button id="btnCloseModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">Batal</button>
                    <button id="cekNIK"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">Cek
                        NIK</button>
                </div>

                <p id="statusNIK" class="text-sm text-red-500 mt-3"></p>
                <input type="hidden" id="jenisSurat" value="">
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Tombol Buka Modal untuk semua jenis surat
                $('button[data-surat]').click(function() {
                    const jenisSurat = $(this).data('surat');
                    $('#jenisSurat').val(jenisSurat);

                    // Update subtitle based on letter type
                    const titles = {
                        'kehilangan': 'Surat Keterangan Kehilangan',
                        'kematian': 'Surat Keterangan Kematian',
                        'usaha': 'Surat Keterangan Usaha',
                        'tidak_mampu': 'Surat Keterangan Tidak Mampu',
                        'izin_potong': 'Surat Izin Potong',
                        'izin_pesta': 'Surat Izin Pesta'
                    };

                    $('#modalSubtitle').text(`Silakan masukkan NIK untuk membuat ${titles[jenisSurat]}`);
                    $('#modalNIK').removeClass('hidden');
                });

                // Tombol Tutup Modal
                $('#btnCloseModal').click(function() {
                    $('#modalNIK').addClass('hidden');
                    $('#statusNIK').text('');
                    $('#nik').val('');
                });

                // Tombol Cek NIK
                $('#cekNIK').click(function() {
                    const nik = $('#nik').val();
                    const jenisSurat = $('#jenisSurat').val();

                    if (!nik) {
                        $('#statusNIK').text('Silakan isi NIK terlebih dahulu.');
                        return;
                    }

                    $.ajax({
                        url: '/cek-nik', // Gunakan URL langsung
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            nik: nik
                        },
                        success: function(res) {
                            if (res.status === 'valid') {
                                // Arahkan ke halaman form buat surat dengan NIK sebagai query param
                                window.location.href = `/surat/${jenisSurat}?nik=${nik}`;
                            } else {
                                $('#statusNIK').text('NIK tidak ditemukan.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            $('#statusNIK').text('Terjadi kesalahan saat memproses.');
                        }
                    });
                });
            });

            //Sweet Alert
            $(document).ready(function() {
                // Check for flash messages
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>

    </section>
@endsection
