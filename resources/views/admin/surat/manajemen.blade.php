@extends('layouts.app')

@section('page-title', 'Data-Manajemen-Surat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-folder-open" style="color:#2E7D32;"></i> Data Manajemen Surat
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.surat.manajemen') }}">Data Manajemen</a></div>
                    <div class="breadcrumb-item">Mata Manajemen</div>
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
                                List Data Manajemen Surat
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahJenisSurat"
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
                                <table class="table mb-0" id="beritaTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Jenis Surat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Format Surat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Tgl Dibuat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Dibuat Oleh</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jenisSurat as $index => $data)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                                    {{ $data->nama_jenis ?? '-' }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->format_nomor ?? '-' }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                                    {{ isset($data->tanggal_dibuat)
                                                        ? \Carbon\Carbon::parse($data->tanggal_dibuat)->format('d-m-Y')
                                                        : \Carbon\Carbon::now()->format('d-m-Y') }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    Admin / Leader
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        <button type="button" class="btn-edit"
                                                            data-id="{{ $data->id }}" title="Edit"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
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

    {{-- Style khusus modal Jenis Surat --}}
    <style>
        .js-modal .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .15);
        }

        .js-modal .modal-header {
            padding: 22px 28px;
            border: none;
        }

        .js-modal .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .js-modal .close {
            color: #fff;
            opacity: .9;
            font-size: 26px;
            text-shadow: none;
        }

        .js-modal .modal-body {
            padding: 28px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .js-modal .form-group {
            margin-bottom: 20px;
        }

        .js-modal .form-group label {
            font-size: 15px;
            font-weight: 600;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .js-modal .js-input {
            width: 100%;
            padding: 12px 14px;
            font-size: 15px;
            color: #1E293B;
            min-height: 48px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            background: #fff;
            outline: none;
            transition: border-color .15s;
        }

        .js-modal textarea.js-input {
            resize: vertical;
        }

        .js-modal .js-hint {
            display: block;
            margin-top: 6px;
            font-size: 12.5px;
            color: #64748B;
        }

        .js-modal .js-error {
            display: block;
            margin-top: 6px;
            font-size: 12.5px;
            color: #DC2626;
        }

        .js-modal .modal-footer {
            background: #fff;
            border-top: 1.5px solid #F1F5F9;
            padding: 18px 28px;
            gap: 10px;
        }

        .js-modal .js-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .js-modal .js-btn-cancel {
            background: #fff;
            color: #475569;
            border: 1.5px solid #E2E8F0;
        }

        .js-modal .js-btn-cancel:hover {
            background: #F1F5F9;
        }

        /* Tema hijau (tambah) */
        .js-modal-add .modal-header {
            background: #2E7D32;
        }

        .js-modal-add .modal-body {
            background: #F8FAFC;
        }

        .js-modal-add .form-group label i {
            color: #2E7D32;
        }

        .js-modal-add .js-input:focus {
            border-color: #2E7D32;
        }

        .js-modal-add .js-btn-save {
            background: #2E7D32;
            color: #fff;
            border: none;
        }

        .js-modal-add .js-btn-save:hover {
            background: #256528;
        }

        /* Tema kuning (edit) */
        .js-modal-edit .modal-header {
            background: #F59E0B;
        }

        .js-modal-edit .modal-body {
            background: #FFFBEB;
        }

        .js-modal-edit .form-group label i {
            color: #F59E0B;
        }

        .js-modal-edit .js-input:focus {
            border-color: #F59E0B;
        }

        .js-modal-edit .js-btn-save {
            background: #F59E0B;
            color: #fff;
            border: none;
        }

        .js-modal-edit .js-btn-save:hover {
            background: #D97706;
        }
    </style>

    {{-- ===================== Modal Tambah Jenis Surat ===================== --}}
    <div class="modal fade js-modal js-modal-add" id="modalTambahJenisSurat" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahJenisSuratLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJenisSuratLabel">
                        <i class="fas fa-envelope"></i> Tambah Jenis Surat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.jenis-surat.store') }}" method="POST" id="formTambahJenisSurat">
                    @csrf

                    <div class="modal-body">

                        <div class="row">
                            {{-- Kode --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode"><i class="fas fa-barcode"></i> Kode</label>
                                    <input type="text" name="kode" id="kode" class="js-input" maxlength="50"
                                        placeholder="Contoh: SKU" style="text-transform:uppercase;">
                                    <span class="js-error" data-error-for="kode"></span>
                                </div>
                            </div>

                            {{-- Nama Jenis --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_jenis"><i class="fas fa-file-alt"></i> Nama Jenis Surat</label>
                                    <input type="text" name="nama_jenis" id="nama_jenis" class="js-input"
                                        maxlength="150" placeholder="Contoh: Surat Keterangan Usaha" required>
                                    <span class="js-error" data-error-for="nama_jenis"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="form-group">
                            <label for="slug"><i class="fas fa-link"></i> Slug</label>
                            <input type="text" name="slug" id="slug" class="js-input" maxlength="100"
                                placeholder="Contoh: surat-keterangan-usaha">
                            <small class="js-hint">Opsional. Kosongkan untuk dibuat otomatis dari nama jenis surat.</small>
                            <span class="js-error" data-error-for="slug"></span>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label for="deskripsi"><i class="fas fa-align-left"></i> Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="js-input"
                                placeholder="Keterangan singkat tentang jenis surat ini (opsional)"></textarea>
                            <span class="js-error" data-error-for="deskripsi"></span>
                        </div>

                        {{-- Format Nomor --}}
                        <div class="form-group">
                            <label for="format_nomor"><i class="fas fa-code"></i> Format Nomor Surat</label>
                            <input type="text" name="format_nomor" id="format_nomor" class="js-input"
                                maxlength="100" placeholder="Contoh: {nomor}/BRN/{bulan}/{tahun}" required>
                            <span class="js-error" data-error-for="format_nomor"></span>
                        </div>

                        <div class="row">
                            {{-- Sumber Pengajuan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sumber_pengajuan"><i class="fas fa-users"></i> Sumber Pengajuan</label>
                                    <select name="sumber_pengajuan" id="sumber_pengajuan" class="js-input" required>
                                        <option value="keduanya" selected>Warga &amp; Admin</option>
                                        <option value="warga">Hanya Warga</option>
                                        <option value="admin">Hanya Admin</option>
                                    </select>
                                    <span class="js-error" data-error-for="sumber_pengajuan"></span>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status"><i class="fas fa-toggle-on"></i> Status</label>
                                    <select name="status" id="status" class="js-input" required>
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    <span class="js-error" data-error-for="status"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Nama Tabel (legacy) --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label for="nama_tabel"><i class="fas fa-database"></i> Nama Tabel</label>
                            <input type="text" name="nama_tabel" id="nama_tabel" class="js-input" maxlength="255"
                                placeholder="Contoh: surat_keterangan_usaha">
                            <small class="js-hint">Opsional (kompatibilitas data lama). Jika diisi, tabel harus ada di
                                database.</small>
                            <span class="js-error" data-error-for="nama_tabel"></span>
                        </div>

                        <span class="js-error" data-error-for="general"></span>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="js-btn js-btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="js-btn js-btn-save">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- ===================== Modal Edit Jenis Surat ===================== --}}
    <div class="modal fade js-modal js-modal-edit" id="modalEditJenisSurat" tabindex="-1" role="dialog"
        aria-labelledby="modalEditJenisSuratLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditJenisSuratLabel">
                        <i class="fas fa-envelope"></i> Edit Jenis Surat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" id="formEditJenisSurat">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id_jenis_surat">

                    <div class="modal-body">

                        <div class="row">
                            {{-- Kode --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_kode"><i class="fas fa-barcode"></i> Kode</label>
                                    <input type="text" name="kode" id="edit_kode" class="js-input" maxlength="50"
                                        style="text-transform:uppercase;">
                                    <span class="js-error" data-error-for="kode"></span>
                                </div>
                            </div>

                            {{-- Nama Jenis --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="edit_nama_jenis"><i class="fas fa-file-alt"></i> Nama Jenis Surat</label>
                                    <input type="text" name="nama_jenis" id="edit_nama_jenis" class="js-input"
                                        maxlength="150" required>
                                    <span class="js-error" data-error-for="nama_jenis"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="form-group">
                            <label for="edit_slug"><i class="fas fa-link"></i> Slug</label>
                            <input type="text" name="slug" id="edit_slug" class="js-input" maxlength="100">
                            <small class="js-hint">Kosongkan untuk mempertahankan slug saat ini (atau dibuat otomatis jika
                                belum ada).</small>
                            <span class="js-error" data-error-for="slug"></span>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label for="edit_deskripsi"><i class="fas fa-align-left"></i> Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="js-input"></textarea>
                            <span class="js-error" data-error-for="deskripsi"></span>
                        </div>

                        {{-- Format Nomor --}}
                        <div class="form-group">
                            <label for="edit_format_nomor"><i class="fas fa-hashtag"></i> Format Nomor</label>
                            <input type="text" name="format_nomor" id="edit_format_nomor" class="js-input"
                                maxlength="100" required>
                            <span class="js-error" data-error-for="format_nomor"></span>
                        </div>

                        <div class="row">
                            {{-- Sumber Pengajuan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_sumber_pengajuan"><i class="fas fa-users"></i> Sumber
                                        Pengajuan</label>
                                    <select name="sumber_pengajuan" id="edit_sumber_pengajuan" class="js-input" required>
                                        <option value="keduanya">Warga &amp; Admin</option>
                                        <option value="warga">Hanya Warga</option>
                                        <option value="admin">Hanya Admin</option>
                                    </select>
                                    <span class="js-error" data-error-for="sumber_pengajuan"></span>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_status"><i class="fas fa-toggle-on"></i> Status</label>
                                    <select name="status" id="edit_status" class="js-input" required>
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    <span class="js-error" data-error-for="status"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Nama Tabel (legacy) --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label for="edit_nama_tabel"><i class="fas fa-database"></i> Nama Tabel</label>
                            <input type="text" name="nama_tabel" id="edit_nama_tabel" class="js-input"
                                maxlength="255">
                            <small class="js-hint">Opsional (kompatibilitas data lama). Jika diisi, tabel harus ada di
                                database.</small>
                            <span class="js-error" data-error-for="nama_tabel"></span>
                        </div>

                        <span class="js-error" data-error-for="general"></span>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="js-btn js-btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="js-btn js-btn-save">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        // Ajax modal tambah jenis surat
        $(document).ready(function() {
            $("#formTambahJenisSurat").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.jenis-surat.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang memproses data jenis surat',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Jenis surat berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh halaman setelah sukses
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message ||
                                    'Terjadi kesalahan saat menambahkan jenis surat.',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Terjadi kesalahan saat mengirim data.',
                        });
                    }
                });
            });

            // Validasi input sebelum submit
            $("#formTambahJenisSurat").on("submit", function(event) {
                let isValid = true;

                // Reset pesan error
                $(".text-danger").text("");

                $(this).find("input, select, textarea").each(function() {
                    if ($(this).prop("required") && $(this).val().trim() === "") {
                        isValid = false;
                        if (!$(this).next(".text-danger").length) {
                            $(this).after('<div class="text-danger">Kolom ini wajib diisi.</div>');
                        }
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });

        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/manajemen/${id}`;

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


        // ===================== Edit Jenis Surat (ambil data) =====================
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/jenis-surat/${id}/edit`, // Ganti sesuai route edit jenis surat
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        let $form = $("#formEditJenisSurat");

                        clearJenisSuratErrors($form);

                        // Isi form modal
                        $form.attr("action", `/admin/jenis-surat/${id}`);
                        $("#edit_id_jenis_surat").val(data.id);
                        $("#edit_kode").val(data.kode || "");
                        $("#edit_nama_jenis").val(data.nama_jenis);
                        $("#edit_slug").val(data.slug || "");
                        $("#edit_deskripsi").val(data.deskripsi || "");
                        $("#edit_format_nomor").val(data.format_nomor);
                        $("#edit_sumber_pengajuan").val(data.sumber_pengajuan || "keduanya");
                        $("#edit_status").val(data.status || "aktif");
                        $("#edit_nama_tabel").val(data.nama_tabel || "");

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

        // ===================== Update Jenis Surat (simpan perubahan) =====================
        $("#formEditJenisSurat").on("submit", function(e) {
            e.preventDefault();

            let $form = $(this);
            let $btn = $form.find('button[type="submit"]');

            clearJenisSuratErrors($form);
            $btn.prop("disabled", true);

            $.ajax({
                url: $form.attr("action"),
                type: "POST", // method spoofing lewat input _method=PUT
                data: $form.serialize(),
                dataType: "json",
                success: function(response) {
                    $("#modalEditJenisSurat").modal("hide");

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    handleJenisSuratAjaxError($form, xhr, "Gagal memperbarui data.");
                },
                complete: function() {
                    $btn.prop("disabled", false);
                },
            });
        });

        // Bersihkan pesan error saat modal edit ditutup
        $("#modalEditJenisSurat").on("hidden.bs.modal", function() {
            clearJenisSuratErrors($("#formEditJenisSurat"));
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

        // Ajax Manajemen Surat (Search + Paginate digabung)
        $(document).ready(function() {

            let searchTimer = null;

            function loadJenisSurat(page = 1, query = '') {

                $.ajax({
                    url: "{{ route('admin.surat.manajemen.paginate') }}", // Sesuaikan dengan route paginate manajemen surat kamu
                    type: "GET",
                    data: {
                        page: page,
                        query: query
                    },
                    success: function(response) {

                        let tbody = $('#beritaTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        tbody.empty();
                        paginationLinks.empty();

                        if (response.data.length === 0) {
                            tbody.append(`
                        <tr>
                            <td colspan="6"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-folder-open fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                            return;
                        }

                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let tanggal = data.tanggal_dibuat ?
                                moment(data.tanggal_dibuat).format('DD-MM-YYYY') :
                                moment().format('DD-MM-YYYY');

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.nama_jenis ?? '-'}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${data.format_nomor ?? '-'}
                                </span>
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                ${tanggal}
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                Admin / Leader
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <button type="button" class="btn-edit" data-id="${data.id}" title="Edit"
                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                        onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                        onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                        <i class="fas fa-edit"></i>
                                    </button>
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
                            text: 'Terjadi kesalahan saat memuat data manajemen surat.'
                        });
                    }
                });
            }

            // Load awal
            loadJenisSurat();

            // Pencarian (debounce, tetap lewat loadJenisSurat yang sama)
            $('#searchInput').on('keyup', function() {

                let query = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    loadJenisSurat(1, query);
                }, 400);
            });

            // Klik pagination
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                let query = $('#searchInput').val();
                loadJenisSurat(page, query);
            });
        });
    </script>
@endsection
