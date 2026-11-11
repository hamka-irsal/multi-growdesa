@extends('layouts.app')

@section('page-title', 'Data-Pengajuan-Surat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-file-alt" style="color:#2E7D32;"></i> Data Pengajuan Surat
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.surat.pengajuan') }}">Data Pengajuan</a></div>
                    <div class="breadcrumb-item">Data Pengajuan Surat</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="border-radius:14px; border:0.5px solid #E2E8F0; box-shadow:0 2px 12px rgba(0,0,0,0.06);">

                        {{-- Card Header --}}
                        <div class="card-header"
                            style="padding:18px 20px; border-bottom:1.5px solid #F1F5F9; flex-wrap:wrap; gap:12px;">
                            <h4 style="font-size:16px; font-weight:600; color:#1E293B; margin:0;">
                                <i class="fas fa-list" style="color:#2E7D32; margin-right:6px;"></i>
                                List Data Pengajuan Surat
                            </h4>

                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">

                                {{-- Search --}}
                                <div style="position:relative;">
                                    <i class="fas fa-search"
                                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; font-size:13px;"></i>
                                    <input type="text" id="searchInput" autocomplete="off" placeholder="Search"
                                        style="padding:9px 14px 9px 34px; border:1.5px solid #E2E8F0; border-radius:10px; font-size:14px; color:#1E293B; background:#F8FAFC; width:200px; outline:none; transition:border .2s;"
                                        onfocus="this.style.borderColor='#6777ef';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#E2E8F0';this.style.background='#F8FAFC'">
                                </div>

                                {{-- Tambah --}}
                                <button type="button" data-toggle="modal" data-target="#modalTambahSurat"
                                    style="display:flex; align-items:center; gap:7px; padding:9px 18px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; transition:background .2s; white-space:nowrap;"
                                    onmouseover="this.style.background='#2E7D32'"
                                    onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="suratTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            {{-- <th>Nomor Pengajuan</th> --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nomor Surat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Jenis Surat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Tgl Pengajuan</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Status</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($surat as $index => $data)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $index + 1 }}
                                                </td>

                                                {{-- <td>{{ $data->kode_unik ?? '-' }}</td> --}}
                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->no_surat ?? '-' }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    {{ $data->jenisSurat->nama_jenis ?? '-' }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                                    {{ $data->penduduk->nama_lengkap ?? '-' }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                                    {{ isset($data->tanggal_pengajuan) ? \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d-m-Y') : '-' }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <select class="select-status-surat" data-id="{{ $data->id }}"
                                                        style="width:130px; padding:8px 10px; font-size:13.5px; font-weight:600; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:8px; background:#F8FAFC; outline:none; transition:border-color .15s;"
                                                        onfocus="this.style.borderColor='#2E7D32'"
                                                        onblur="this.style.borderColor='#E2E8F0'">
                                                        <option value="proses"
                                                            {{ $data->status_surat == 'proses' ? 'selected' : '' }}>🔵
                                                            Proses</option>
                                                        <option value="selesai"
                                                            {{ $data->status_surat == 'selesai' ? 'selected' : '' }}>✅
                                                            Selesai</option>
                                                        <option value="tolak"
                                                            {{ $data->status_surat == 'tolak' ? 'selected' : '' }}>❌
                                                            Tolak</option>
                                                    </select>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        @if (strtolower($data->status_surat ?? ''))
                                                            <a href="{{ route('admin.surat.cetak', $data->id) }}"
                                                                target="_blank" title="Cetak"
                                                                style="width:36px; height:36px; border-radius:8px; border:1.5px solid #86EFAC; background:#DCFCE7; color:#15803D; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                                                onmouseover="this.style.background='#22C55E';this.style.color='#fff'"
                                                                onmouseout="this.style.background='#DCFCE7';this.style.color='#15803D'">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                        @endif
                                                        <button class="btn-hapus" data-id="{{ $data->id }}"
                                                            title="Hapus"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #EF4444; background:#FFF0F0; color:#B91C1C; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#EF4444';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF0F0';this.style.color='#B91C1C'">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Footer Pagination --}}
                        <div class="card-footer"
                            style="background:#F8FAFC; border-top:1.5px solid #F1F5F9; padding:14px 20px; display:flex; align-items:center; justify-content:flex-end; border-radius:0 0 14px 14px;">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0" id="paginationLinks" style="gap:4px;">
                                    <!-- Link pagination akan dimuat di sini -->
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Tambah Surat --}}
    <div class="modal fade" id="modalTambahSurat" tabindex="-1" role="dialog" aria-labelledby="modalTambahSuratLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:20px 24px; border:none;">
                    <h5 class="modal-title" id="modalTambahSuratLabel"
                        style="font-size:20px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-envelope"></i> Tambah Surat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:24px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formTambahSurat" enctype="multipart/form-data" action="{{ route('admin.surat.store') }}"
                    method="POST">
                    @csrf

                    <div class="modal-body" style="padding:24px; background:#F8FAFC; max-height:70vh; overflow-y:auto;">

                        {{-- Pilih NIK (Penduduk) --}}
                        <div class="form-group" style="margin-bottom:18px;">
                            <label for="penduduk_id"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                <i class="fas fa-id-card" style="color:#2E7D32;"></i> Pilih NIK
                            </label>
                            <select name="penduduk_id" id="penduduk_id" required
                                style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">-- Pilih NIK --</option>
                                @foreach ($penduduk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nik }} - {{ $item->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Jenis Surat --}}
                        <div class="form-group" style="margin-bottom:18px;">
                            <label for="jenis_surat_id"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                <i class="fas fa-file-alt" style="color:#2E7D32;"></i> Jenis Surat
                            </label>
                            <select name="jenis_surat_id" id="jenis_surat_id" required
                                style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach ($jenisSurat as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Field Tambahan untuk Surat Kehilangan --}}
                        <div id="fieldKehilangan" style="display:none;">
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom:18px;">
                                    <label for="barang_hilang"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-box-open" style="color:#2E7D32;"></i> Barang yang Hilang
                                    </label>
                                    <input type="text" id="barang_hilang" name="barang_hilang"
                                        placeholder="Contoh: KTP, SIM, STNK, Buku Nikah"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                <div class="col-md-12" style="margin-bottom:18px;">
                                    <label for="keperluan_kepengurusan"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-file-alt" style="color:#2E7D32;"></i> Keperluan Pengurusan
                                    </label>
                                    <textarea id="keperluan_kepengurusan" name="keperluan_kepengurusan" rows="3"
                                        placeholder="Contoh: Digunakan sebagai persyaratan pengurusan dokumen pengganti di instansi terkait"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Field Tambahan untuk Surat Pengantar --}}
                        <div id="fieldPengantar" style="display:none;">
                            <div class="row">

                                <div class="col-md-12" style="margin-bottom:18px;">
                                    <label for="keperluan_antar"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-file-signature" style="color:#2E7D32;"></i> Keperluan Surat
                                        Pengantar
                                    </label>
                                    <input type="text" id="keperluan_antar" name="keperluan_antar"
                                        placeholder="Contoh: Pengantar Pembuatan KTP, KK, SKCK, BPJS, dll"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                <div class="col-md-12" style="margin-bottom:18px;">
                                    <label for="keterangan_antar"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-align-left" style="color:#2E7D32;"></i> Keterangan
                                    </label>
                                    <textarea id="keterangan_antar" name="keterangan_antar" rows="3"
                                        placeholder="Masukkan keterangan atau tujuan surat pengantar"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>

                            </div>
                        </div>

                        {{-- Field Tambahan untuk Surat Keterangan Kematian --}}
                        <div id="fieldKematian" style="display:none;">
                            <div class="row">

                                <div class="col-md-6" style="margin-bottom:18px;">
                                    <label for="tanggal_kematian"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-calendar-times" style="color:#2E7D32;"></i> Tanggal Kematian
                                    </label>
                                    <input type="date" id="tanggal_kematian" name="tanggal_kematian"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>
                        </div>

                        {{-- Field Tambahan untuk Surat Keterangan Usaha --}}
                        <div id="fieldUsaha" style="display:none;">
                            <div class="row">

                                <div class="col-md-6" style="margin-bottom:18px;">
                                    <label for="nama_usaha"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-store" style="color:#2E7D32;"></i> Nama Usaha
                                    </label>
                                    <input type="text" id="nama_usaha" name="nama_usaha"
                                        placeholder="Contoh: Toko Sembako Berkah"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                <div class="col-md-6" style="margin-bottom:18px;">
                                    <label for="jenis_usaha"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-briefcase" style="color:#2E7D32;"></i> Jenis Usaha
                                    </label>
                                    <input type="text" id="jenis_usaha" name="jenis_usaha"
                                        placeholder="Contoh: Perdagangan Sembako"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                <div class="col-md-12" style="margin-bottom:18px;">
                                    <label for="alamat_usaha"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-map-marker-alt" style="color:#2E7D32;"></i> Alamat Usaha
                                    </label>
                                    <textarea id="alamat_usaha" name="alamat_usaha" rows="3" placeholder="Masukkan alamat lengkap usaha"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>

                                <div class="col-md-4" style="margin-bottom:18px;">
                                    <label for="tahun_berdiri"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <i class="fas fa-calendar-alt" style="color:#2E7D32;"></i> Tahun Berdiri
                                    </label>
                                    <input type="number" id="tahun_berdiri" name="tahun_berdiri" min="1900"
                                        max="{{ date('Y') }}" placeholder="{{ date('Y') }}"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>
                        </div>

                        {{-- Field Tambahan untuk Surat Keterangan Tidak Mampu --}}
                        <div id="fieldTidakMampu" style="display:none;">
                            {{-- Tidak ada input tambahan.
                        Data surat diambil dari data penduduk yang bersangkutan. --}}
                        </div>

                        {{-- Field Tambahan untuk Surat Keterangan Domisili --}}
                        <div id="fieldDomisili" style="display:none;">
                            {{-- Tidak ada input tambahan.
                        Seluruh data diambil dari data penduduk yang bersangkutan. --}}
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer d-flex justify-content-between"
                        style="background:#fff; border-top:1.5px solid #F1F5F9; padding:16px 24px;">
                        <button type="button" data-dismiss="modal"
                            style="display:flex; align-items:center; gap:8px; padding:10px 20px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:10px 22px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#256528'" onmouseout="this.style.background='#2E7D32'">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        // Ajax modal tambah surat
        $(document).ready(function() {

            // Tampilkan field sesuai jenis surat
            $('#jenis_surat_id').on('change', function() {

                let selectedText = $(this).find('option:selected').text().toLowerCase();

                // Sembunyikan semua field tambahan
                $('.surat-field').hide();

                if (selectedText.includes('kehilangan')) {
                    $('#fieldKehilangan').slideDown();
                }

                if (selectedText.includes('pengantar')) {
                    $('#fieldPengantar').slideDown();
                }

                if (selectedText.includes('kematian')) {
                    $('#fieldKematian').slideDown();
                }

                if (selectedText.includes('tidak_mampu')) {
                    $('#fieldTidakMampu').slideDown();
                }

                if (selectedText.includes('usaha')) {
                    $('#fieldUsaha').slideDown();
                }

                if (selectedText.includes('domisili')) {
                    $('#fieldDomisili').slideDown();
                }

            });

            // Submit Form
            $('#formTambahSurat').submit(function(e) {

                e.preventDefault();

                $('.text-danger').remove();

                let isValid = true;

                $(this).find('[required]').each(function() {

                    if ($(this).val() === '') {

                        isValid = false;

                        $(this).after(
                            '<small class="text-danger">Field ini wajib diisi.</small>'
                        );

                    }

                });

                if (!isValid) {
                    return;
                }

                let formData = new FormData(this);

                $.ajax({

                    url: "{{ route('admin.surat.store') }}",

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    cache: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function() {

                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang menyimpan data surat.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                    },

                    success: function(response) {

                        Swal.close();

                        if (response.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {

                                $('#formTambahSurat')[0].reset();

                                $('.surat-field').hide();

                                $('#modalTambahSurat').modal('hide');

                                location.reload();

                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });

                        }

                    },

                    error: function(xhr) {

                        Swal.close();

                        let message = 'Terjadi kesalahan.';

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            let html = '';

                            $.each(errors, function(key, value) {

                                html += value[0] + '<br>';

                            });

                            message = html;

                        } else if (xhr.responseJSON && xhr.responseJSON.message) {

                            message = xhr.responseJSON.message;

                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: message
                        });

                        console.log(xhr.responseText);

                    }

                });

            });

        });

        //Ajax Update Status Surat
        $(document).on('change', '.select-status-surat', function() {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Konfirmasi",
                text: "Yakin ingin mengubah status surat?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, ubah!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/update-status-surat/${id}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content")
                            },
                            body: JSON.stringify({
                                status_surat: status
                            })
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: result.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Refresh halaman penuh agar status terbaru muncul
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', result.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        });
                }
            });
        });


        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/surat/${id}`;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menghapus data.",
                                icon: "error",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });

        // 🟡 AJAX Edit Jenis Surat
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/jenis-surat/${id}/edit`, // Ganti sesuai route edit jenis surat
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data;

                        // Isi form modal
                        $("#formEditJenisSurat").attr("action", `/admin/jenis-surat/${id}`);
                        $("#edit_id_jenis_surat").val(data.id);
                        $("#edit_nama_jenis").val(data.nama_jenis);
                        $("#edit_format_nomor").val(data.format_nomor);
                        $("#edit_nama_tabel").val(data.nama_tabel);

                        $("#modalEditJenisSurat").modal("show");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data jenis surat tidak ditemukan.",
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data dari server.",
                    });
                },
            });
        });

        // 🟡 AJAX Submit Edit Jenis Surat
        $("#formEditJenisSurat").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let id = $("#edit_id_jenis_surat").val();

            $.ajax({
                url: `/admin/jenis-surat/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-HTTP-Method-Override": "PUT", // spoofing PUT
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Jenis surat berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            $("#modalEditJenisSurat").modal("hide");
                            $("#formEditJenisSurat")[0].reset();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: response.message || "Data gagal diperbarui!",
                            icon: "error",
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = "";
                    $.each(errors, function(key, value) {
                        errorMessages += `<li>${value[0]}</li>`;
                    });

                    Swal.fire({
                        title: "Terjadi Kesalahan!",
                        html: `<ul style='text-align: left;'>${errorMessages}</ul>`,
                        icon: "error",
                    });
                },
            });
        });


        // Ajax Cari Aparat
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let query = $(this).val();
                loadAparat(1, query);

                $.ajax({
                    url: '/admin/search-aparat', // Sesuaikan dengan route pencarian aparat kamu
                    method: 'GET',
                    data: {
                        query: searchQuery
                    },
                    success: function(response) {
                        var tbody = $('#aparatTable tbody');
                        tbody.empty();

                        if (response.data.length > 0) {
                            response.data.forEach(function(aparat, index) {
                                var foto = aparat.foto ? `/storage/${aparat.foto}` :
                                    '/images/default-user.png';

                                var row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${aparat.nama}</td>
                                <td>${aparat.jabatan}</td>
                                <td><img src="${foto}" alt="Foto Aparat" width="80"></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="${aparat.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-hapus" data-id="${aparat.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            tbody.append(
                                '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });
        });

        //Ajax Paginate Surat
        $(document).ready(function() {

            let searchTimer = null;

            function loadSurat(page = 1, query = '') {

                $.ajax({
                    url: "{{ route('admin.surat.paginate') }}",
                    type: "GET",
                    data: {
                        page: page,
                        query: query
                    },
                    success: function(response) {

                        let tbody = $('#suratTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        tbody.empty();
                        paginationLinks.empty();

                        if (response.data.length === 0) {
                            tbody.append(`
                        <tr>
                            <td colspan="7"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-file-circle-xmark fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data surat tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                            return;
                        }

                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let tanggal = data.tanggal_pengajuan ?
                                moment(data.tanggal_pengajuan).format('DD-MM-YYYY') : '-';

                            let cetakBtn = data.status_surat ? `
                        <a href="/admin/pengajuan-surat/cetak/${data.id}" target="_blank" title="Cetak"
                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #86EFAC; background:#DCFCE7; color:#15803D; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                            onmouseover="this.style.background='#22C55E';this.style.color='#fff'"
                            onmouseout="this.style.background='#DCFCE7';this.style.color='#15803D'">
                            <i class="fas fa-print"></i>
                        </a>
                    ` : '';

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${data.no_surat ?? '-'}
                                </span>
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.penduduk?.nama_lengkap ?? '-'}
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                ${data.jenis_surat?.nama_jenis ?? '-'}
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                ${tanggal}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                <select class="select-status-surat" data-id="${data.id}"
                                    style="width:130px; padding:8px 10px; font-size:13.5px; font-weight:600; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:8px; background:#F8FAFC; outline:none; transition:border-color .15s;"
                                    onfocus="this.style.borderColor='#2E7D32'"
                                    onblur="this.style.borderColor='#E2E8F0'">
                                    <option value="proses" ${data.status_surat === 'proses' ? 'selected' : ''}>🔵 Proses</option>
                                    <option value="selesai" ${data.status_surat === 'selesai' ? 'selected' : ''}>✅ Selesai</option>
                                    <option value="tolak" ${data.status_surat === 'tolak' ? 'selected' : ''}>❌ Tolak</option>
                                </select>
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                    ${cetakBtn}
                                    <button class="btn-hapus" data-id="${data.id}" title="Hapus"
                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #EF4444; background:#FFF0F0; color:#B91C1C; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                        onmouseover="this.style.background='#EF4444';this.style.color='#fff'"
                                        onmouseout="this.style.background='#FFF0F0';this.style.color='#B91C1C'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;

                            tbody.append(row);
                        });

                        // Pagination
                        if (response.last_page > 1) {

                            if (response.current_page > 1) {
                                paginationLinks.append(`
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" data-page="${response.current_page - 1}" data-query="${query}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        `);
                            }

                            for (let i = 1; i <= response.last_page; i++) {
                                let activeClass = response.current_page === i ? 'active' : '';
                                paginationLinks.append(`
                            <li class="page-item ${activeClass}">
                                <a class="page-link pagination-link" href="#" data-page="${i}" data-query="${query}">${i}</a>
                            </li>
                        `);
                            }

                            if (response.current_page < response.last_page) {
                                paginationLinks.append(`
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" data-page="${response.current_page + 1}" data-query="${query}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        `);
                            }
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat data surat.'
                        });
                    }
                });
            }

            // Load awal
            loadSurat();

            // Fitur pencarian surat (dengan debounce, tetap lewat loadSurat yang sama)
            $('#searchInput').on('keyup', function() {

                let query = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    loadSurat(1, query);
                }, 400);
            });

            // Navigasi halaman
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                let query = $('#searchInput').val();
                loadSurat(page, query);
            });
        });

        //cetak surat
        $(document).ready(function() {
            $('.btn-cetak').click(function() {
                const id = $(this).data('id');
                window.open('/admin/pengajuan-surat/cetak/' + id, '_blank');
            });
        });

        //Ajax tampil inputan jenis surat
        document.addEventListener('DOMContentLoaded', function() {

            const jenisSurat = document.getElementById('jenis_surat_id');

            jenisSurat.addEventListener('change', function() {

                document.querySelectorAll('.surat-field').forEach(function(field) {
                    field.style.display = 'none';
                });

                const nama = this.options[this.selectedIndex].text;

                switch (nama) {
                    case 'Surat Kehilangan':
                        document.getElementById('fieldKehilangan').style.display = 'block';
                        break;

                    case 'Surat Domisili':
                        document.getElementById('fieldDomisili').style.display = 'block';
                        break;

                    case 'Surat Usaha':
                        document.getElementById('fieldUsaha').style.display = 'block';
                        break;
                }

            });

        });
    </script>
@endsection
