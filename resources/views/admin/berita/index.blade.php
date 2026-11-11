@extends('layouts.app')

@section('page-title', 'Data-Berita Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-newspaper" style="color:#2E7D32;"></i> Data Berita
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Data Berita</a></div>
                    <div class="breadcrumb-item">Berita</div>
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
                                List Data Berita
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahBerita"
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
                                                Judul</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Kategori</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Penulis</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Gambar</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($berita as $index => $data)
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
                                                    {{ $data->judul }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->category->name ?? '-' }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    {{ $data->penulis }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="Gambar Berita"
                                                        width="80"
                                                        style="border-radius:8px; border:1.5px solid #E2E8F0;">
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

    {{-- Modal Tambah Berita --}}
    <div class="modal fade" id="modalTambahBerita" tabindex="-1" role="dialog" aria-labelledby="modalTambahBeritaLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahBeritaLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-newspaper"></i> Tambah Berita
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data"
                    id="formTambahBerita">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC; max-height:70vh; overflow-y:auto;">

                        <div class="row">

                            <div class="col-md-6">

                                {{-- Judul --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-heading" style="color:#2E7D32;"></i> Judul
                                    </label>
                                    <input type="text" name="judul" placeholder="Masukkan Judul Berita" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Kategori Berita --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tags" style="color:#2E7D32;"></i> Kategori
                                    </label>
                                    <select name="category_id" id="category_id" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Penulis --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user-edit" style="color:#2E7D32;"></i> Penulis
                                    </label>
                                    <input type="text" name="penulis" placeholder="Nama Penulis" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            <div class="col-md-6">

                                {{-- Tanggal Publish --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-calendar-alt" style="color:#2E7D32;"></i> Tanggal Publish
                                    </label>
                                    <input type="date" name="tanggal_publish" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Foto --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#2E7D32;"></i> Foto
                                    </label>
                                    <input type="file" name="foto" accept="image/*"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <img id="previewFoto" src="#" alt="Preview Foto"
                                        style="display:none; margin-top:12px; max-width:150px; border-radius:10px; border:1.5px solid #E2E8F0; background:#fff; padding:6px;">
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-align-left" style="color:#2E7D32;"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" placeholder="Isi lengkap berita..." rows="4" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer"
                        style="background:#fff; border-top:1.5px solid #F1F5F9; padding:18px 28px; gap:10px;">
                        <button type="button" data-dismiss="modal"
                            style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#256528'" onmouseout="this.style.background='#2E7D32'">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>


    {{-- Modal Edit Berita --}}
    <div class="modal fade" id="modalEditBerita" tabindex="-1" role="dialog" aria-labelledby="modalEditBeritaLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditBeritaLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-newspaper"></i> Edit Berita
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" id="formEditBerita">

                    @csrf

                    {{-- Method spoofing untuk request PUT --}}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB; max-height:70vh; overflow-y:auto;">

                        <div class="row">

                            <div class="col-md-6">

                                {{-- Judul --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-heading" style="color:#F59E0B;"></i> Judul
                                    </label>
                                    <input type="text" name="judul" id="edit_judul" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Kategori Berita --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tags" style="color:#F59E0B;"></i> Kategori
                                    </label>
                                    <select name="category_id" id="edit_category_id" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Penulis --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#F59E0B;"></i> Penulis
                                    </label>
                                    <input type="text" name="penulis" id="edit_penulis" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Tanggal Publish --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-calendar" style="color:#F59E0B;"></i> Tanggal Publish
                                    </label>
                                    <input type="date" name="tanggal_publish" id="edit_tanggal_publish" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            <div class="col-md-6">

                                {{-- Deskripsi --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-align-left" style="color:#F59E0B;"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" id="edit_deskripsi" rows="6" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>

                                {{-- Foto --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#F59E0B;"></i> Foto
                                    </label>
                                    <input type="file" name="foto" id="editFoto" accept="image/*"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <img id="editPreviewFoto" src="#" alt="Preview Foto"
                                        style="display:none; margin-top:12px; max-width:150px; border-radius:10px; border:1.5px solid #E2E8F0; background:#fff; padding:6px;">
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer"
                        style="background:#fff; border-top:1.5px solid #F1F5F9; padding:18px 28px; gap:10px;">
                        <button type="button" data-dismiss="modal"
                            style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#F59E0B; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#D97706'" onmouseout="this.style.background='#F59E0B'">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>
        // AJAX Modal Tambah Berita
        $(document).ready(function() {

            $("#formTambahBerita").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Reset error sebelumnya
                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback").text("");

                $.ajax({
                    url: "{{ route('admin.berita.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang menyimpan berita',
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
                                text: response.message ||
                                    'Berita berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                // Tutup modal
                                $("#modalTambahBerita").modal("hide");

                                // Reset form
                                $("#formTambahBerita")[0].reset();

                                // Reload halaman
                                location.reload();

                            });

                        } else {

                            let errorMessage =
                                'Terjadi kesalahan saat menambahkan berita.';

                            if (response.errors) {

                                if (response.errors.general) {
                                    errorMessage =
                                        response.errors.general[0];
                                }

                            } else if (response.message) {

                                errorMessage =
                                    response.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                                confirmButtonText: 'Coba Lagi'
                            });

                        }

                    },

                    error: function(xhr) {

                        let errorMessage =
                            'Terjadi kesalahan saat mengirim data.';

                        // Reset error sebelumnya
                        $(form).find(".is-invalid")
                            .removeClass("is-invalid");

                        $(form).find(".invalid-feedback")
                            .text("");

                        try {

                            const response = xhr.responseJSON;

                            if (response) {

                                /*
                                |--------------------------------------------------------------------------
                                | Error validasi Laravel
                                |--------------------------------------------------------------------------
                                */

                                if (response.errors) {

                                    $.each(
                                        response.errors,
                                        function(field, messages) {

                                            let input =
                                                $("#tambah_" + field);

                                            let errorElement =
                                                $("#error_" + field);

                                            if (input.length) {

                                                input.addClass(
                                                    "is-invalid"
                                                );

                                            }

                                            if (errorElement.length) {

                                                errorElement.text(
                                                    messages[0]
                                                );

                                            }

                                        }
                                    );

                                    // Ambil error pertama
                                    let firstError =
                                        Object.values(
                                            response.errors
                                        )[0];

                                    if (
                                        firstError &&
                                        firstError.length > 0
                                    ) {

                                        errorMessage =
                                            firstError[0];

                                    }

                                } else if (response.message) {

                                    errorMessage =
                                        response.message;

                                }

                            }

                        } catch (e) {

                            console.error(
                                "Error parsing error response:",
                                e
                            );

                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonText: 'Tutup'
                        });

                    }

                });

            });


            // Validasi input sebelum submit
            $("#formTambahBerita").on("submit", function(event) {

                let isValid = true;
                let form = this;

                // Reset error
                $(form).find(".is-invalid")
                    .removeClass("is-invalid");

                $(form).find(".invalid-feedback")
                    .text("");


                $(form).find("input, select, textarea").each(function() {

                    if (
                        $(this).prop("required") &&
                        $.trim($(this).val()) === ""
                    ) {

                        isValid = false;

                        $(this).addClass("is-invalid");

                        let fieldName = $(this).attr("name");

                        if (fieldName) {

                            $("#error_" + fieldName)
                                .text("Kolom ini wajib diisi.");

                        }

                    }

                });


                if (!isValid) {

                    event.preventDefault();

                    return false;

                }

            });


            // Hilangkan error ketika input diperbaiki
            $("#formTambahBerita input, " +
                    "#formTambahBerita select, " +
                    "#formTambahBerita textarea")
                .on("input change", function() {

                    $(this).removeClass("is-invalid");

                    let fieldName = $(this).attr("name");

                    if (fieldName) {

                        $("#error_" + fieldName).text("");

                    }

                });

        });

        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/berita/${id}`;

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

        // 🟢 AJAX Edit Berita
        $(document).on("click", ".btn-edit", function() {

            let id = $(this).data("id");

            console.log("ID Berita:", id);

            $.ajax({
                url: `/admin/berita/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    console.log("Response Edit:", response);

                    if (response.success === true) {

                        let data = response.data;

                        // Atur URL form untuk proses update
                        $("#formEditBerita").attr(
                            "action",
                            `/admin/berita/${data.id}`
                        );

                        // Isi data ke modal
                        $("#edit_id").val(data.id);
                        $("#edit_judul").val(data.judul);
                        $("#edit_category_id").val(data.category_id);
                        $("#edit_penulis").val(data.penulis);
                        $("#edit_tanggal_publish").val(data.tanggal_publish);
                        $("#edit_deskripsi").val(data.deskripsi);

                        // Kosongkan input file
                        $("#editFoto").val("");

                        // Tampilkan foto lama
                        if (data.foto_url) {

                            $("#editPreviewFoto")
                                .attr("src", data.foto_url)
                                .show();

                        } else {

                            $("#editPreviewFoto")
                                .attr("src", "#")
                                .hide();

                        }

                        // Tampilkan modal
                        $("#modalEditBerita").modal("show");

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message ||
                                "Data berita tidak ditemukan."
                        });

                    }
                },

                error: function(xhr, status, error) {

                    console.error("Status:", xhr.status);
                    console.error("Error:", error);
                    console.error(
                        "Response:",
                        xhr.responseText
                    );

                    let message =
                        "Gagal memuat data dari server.";

                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {
                        message =
                            xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: message
                    });

                }

            });

        });

        // 🟢 AJAX Submit Edit Berita
        $("#formEditBerita").on("submit", function(e) {
            e.preventDefault();

            // Ambil form dan ID berita
            let form = this;
            let formData = new FormData(form);
            let id = $("#edit_id").val();

            console.log("ID Berita yang akan diperbarui:", id);

            // Pastikan ID tersedia
            if (!id) {

                Swal.fire({
                    title: "Gagal!",
                    text: "ID berita tidak ditemukan.",
                    icon: "error"
                });

                return;
            }

            $.ajax({

                // URL update berita
                url: `/admin/berita/${id}`,

                // Tetap POST karena Laravel menggunakan _method=PUT
                type: "POST",

                data: formData,

                // Wajib false saat menggunakan FormData
                processData: false,
                contentType: false,

                beforeSend: function() {

                    // Nonaktifkan tombol saat proses simpan
                    $("#formEditBerita button[type='submit']")
                        .prop("disabled", true)
                        .html(`
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></span>
                Menyimpan...
            `);

                },

                success: function(response) {

                    console.log(
                        "Response Update Berita:",
                        response
                    );

                    if (response.success === true) {

                        Swal.fire({

                            title: "Berhasil!",
                            text: response.message ||
                                "Data berita berhasil diperbarui.",

                            icon: "success",

                            timer: 2000,

                            showConfirmButton: false

                        }).then(function() {

                            // Tutup modal
                            $("#modalEditBerita").modal("hide");

                            // Reset form
                            form.reset();

                            // Refresh halaman
                            location.reload();

                        });

                    } else {

                        Swal.fire({

                            title: "Gagal!",

                            text: response.message ||
                                "Data berita gagal diperbarui.",

                            icon: "error"

                        });

                    }

                },

                error: function(xhr) {

                    console.error(
                        "Status:",
                        xhr.status
                    );

                    console.error(
                        "Response Error:",
                        xhr.responseText
                    );

                    let errorMessages = "";

                    /*
                    |--------------------------------------------------------------------------
                    | Error Validasi Laravel
                    |--------------------------------------------------------------------------
                    */
                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.errors
                    ) {

                        $.each(
                            xhr.responseJSON.errors,
                            function(key, value) {

                                errorMessages += `
                        <li>${value[0]}</li>
                    `;

                            }
                        );

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Error Umum
                    |--------------------------------------------------------------------------
                    */
                    else {

                        let message =
                            xhr.responseJSON &&
                            xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            "Terjadi kesalahan saat memperbarui data.";

                        errorMessages = `
                <li>${message}</li>
            `;

                    }


                    Swal.fire({

                        title: "Terjadi Kesalahan!",

                        html: `
                <ul style="text-align: left;">
                    ${errorMessages}
                </ul>
            `,

                        icon: "error"

                    });

                },

                complete: function() {

                    // Aktifkan kembali tombol
                    $("#formEditBerita button[type='submit']")
                        .prop("disabled", false)
                        .html(`
                <i class="fas fa-save"></i>
                Simpan Perubahan
            `);

                }

            });

        });

        // AJAX Search dan Pagination Berita
        $(document).ready(function() {

            let searchTimer = null;

            // Fungsi untuk memuat data berita
            function loadBerita(page = 1, search = '') {

                $.ajax({
                    url: "{{ route('admin.berita.paginate') }}",
                    type: "GET",
                    data: {
                        page: page,
                        search: search
                    },

                    success: function(response) {

                        let tbody = $('#beritaTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        tbody.empty();
                        paginationLinks.empty();

                        // Jika data berita tidak ditemukan
                        if (!response.data || response.data.length === 0) {

                            tbody.append(`
                        <tr>
                            <td colspan="6"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-newspaper fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data berita tidak ditemukan</span>
                            </td>
                        </tr>
                    `);

                            return;
                        }

                        // Menampilkan data berita
                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            // URL foto
                            let fotoUrl = data.foto ?
                                `/storage/${data.foto}` :
                                '/images/default-image.png';

                            // Nama kategori dari relasi category
                            let kategori = data.category ?
                                data.category.name :
                                '-';

                            // Nomor urut
                            let nomor = response.from + index;

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${nomor}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.judul}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${kategori}
                                </span>
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                ${data.penulis}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <img src="${fotoUrl}" alt="Gambar Berita" width="80"
                                    style="border-radius:8px; border:1.5px solid #E2E8F0;">
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">

                                    <button type="button" class="btn-edit" data-id="${data.id}" title="Edit"
                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                        onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                        onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn-hapus" data-id="${data.id}" title="Hapus"
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

                        // Buat pagination jika halaman lebih dari satu
                        if (response.last_page > 1) {

                            // Tombol previous
                            if (response.current_page > 1) {

                                paginationLinks.append(`
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" data-page="${response.current_page - 1}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        `);
                            }

                            // Nomor halaman
                            for (let i = 1; i <= response.last_page; i++) {

                                let activeClass = response.current_page == i ? 'active' : '';

                                paginationLinks.append(`
                            <li class="page-item ${activeClass}">
                                <a class="page-link pagination-link" href="#" data-page="${i}">
                                    ${i}
                                </a>
                            </li>
                        `);
                            }

                            // Tombol next
                            if (response.current_page < response.last_page) {

                                paginationLinks.append(`
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" data-page="${response.current_page + 1}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        `);
                            }
                        }
                    },

                    error: function(xhr) {

                        console.error('Gagal memuat data berita:', xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat data berita.'
                        });
                    }
                });
            }


            // Load semua berita saat halaman pertama kali dibuka
            loadBerita();


            // Pencarian berita (debounce, tetap lewat loadBerita yang sama)
            $('#searchInput').on('keyup', function() {

                let search = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    // Saat mencari, selalu kembali ke halaman pertama
                    loadBerita(1, search);
                }, 400);
            });


            // Klik pagination
            $(document).on('click', '.pagination-link', function(e) {

                e.preventDefault();

                let page = $(this).data('page');
                let search = $('#searchInput').val();

                loadBerita(page, search);
            });
        });
    </script>
@endsection
