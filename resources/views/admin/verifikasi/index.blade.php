@extends('layouts.app')

@section('page-title', 'Data-Verifikasi Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-user-check" style="color:#2E7D32;"></i> Data Verifikasi Penduduk
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.verifikasi.index') }}">Data Verifikasi</a></div>
                    <div class="breadcrumb-item">Data Verifikasi Penduduk</div>
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
                                <i class="fas fa-users" style="color:#2E7D32; margin-right:6px;"></i>
                                List Verifikasi Pengguna
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahVerifikasi"
                                    style="display:flex; align-items:center; gap:7px; padding:9px 18px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; transition:background .2s; white-space:nowrap;"
                                    onmouseover="this.style.background='#256628'"
                                    onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="verifikasiTable"
                                    style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Email</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Role</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Tanggal Daftar</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Status</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $data)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $users->firstItem() + $index }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                                    {{ $data->penduduk->nama_lengkap ?? ($data->name ?? '-') }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    {{ $data->email ?? '-' }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    @if ($data->role === 'aparat')
                                                        <span
                                                            style="display:inline-flex; align-items:center; gap:6px; background:#E0F2FE; color:#0369A1; border:1.5px solid #BAE6FD; font-size:13px; font-weight:600; padding:5px 10px; border-radius:8px;">
                                                            <i class="fas fa-user-tie"></i> Aparat
                                                        </span>
                                                    @elseif ($data->role === 'penduduk')
                                                        <span
                                                            style="display:inline-flex; align-items:center; gap:6px; background:#F1F5F9; color:#475569; border:1.5px solid #CBD5E1; font-size:13px; font-weight:600; padding:5px 10px; border-radius:8px;">
                                                            <i class="fas fa-user"></i> Penduduk
                                                        </span>
                                                    @else
                                                        <span
                                                            style="display:inline-flex; align-items:center; background:#F1F5F9; color:#334155; border:1.5px solid #CBD5E1; font-size:13px; font-weight:600; padding:5px 10px; border-radius:8px;">
                                                            {{ ucfirst($data->role ?? '-') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                                    {{ $data->created_at ? $data->created_at->format('d-m-Y H:i') : '-' }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <select class="select-status-verifikasi" data-id="{{ $data->id }}"
                                                        data-old-status="{{ $data->status_verifikasi }}"
                                                        style="width:130px; padding:8px 10px; font-size:13.5px; font-weight:600; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:8px; background:#F8FAFC; outline:none; transition:border-color .15s;"
                                                        onfocus="this.style.borderColor='#2E7D32'"
                                                        onblur="this.style.borderColor='#E2E8F0'">
                                                        <option value="pending"
                                                            {{ $data->status_verifikasi == 'pending' ? 'selected' : '' }}>⏳
                                                            Menunggu</option>
                                                        <option value="disetujui"
                                                            {{ $data->status_verifikasi == 'disetujui' ? 'selected' : '' }}>
                                                            ✅ Disetujui</option>
                                                        <option value="ditolak"
                                                            {{ $data->status_verifikasi == 'ditolak' ? 'selected' : '' }}>❌
                                                            Ditolak</option>
                                                    </select>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">

                                                        <button type="button" class="btn-detail-verifikasi"
                                                            data-id="{{ $data->id }}" title="Lihat Detail"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #93C5FD; background:#EFF6FF; color:#2563EB; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#3B82F6';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#EFF6FF';this.style.color='#2563EB'">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <button type="button" class="btn-hapus"
                                                            data-id="{{ $data->id }}" title="Hapus"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #EF4444; background:#FFF0F0; color:#B91C1C; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#EF4444';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF0F0';this.style.color='#B91C1C'">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7"
                                                    style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                                    <i class="fas fa-users fa-2x mb-3"
                                                        style="opacity:0.3; display:block;"></i>
                                                    <span style="font-size:15px; font-weight:500;">Data pengguna belum
                                                        tersedia</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Footer Pagination --}}
                        <div class="card-footer"
                            style="background:#F8FAFC; border-top:1.5px solid #F1F5F9; padding:14px 20px; display:flex; align-items:center; justify-content:flex-end; border-radius:0 0 14px 14px;">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0" id="paginationLinks" style="gap:4px;">
                                    {{ $users->withQueryString()->links() }}
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    </div>


    {{-- Modal Tambah Verifikasi Penduduk --}}
    <div class="modal fade" id="modalTambahVerifikasi" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahVerifikasiLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border-radius:16px; border:none; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahVerifikasiLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna Verifikasi
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Form --}}
                <form method="POST" id="formTambahVerifikasi">

                    @csrf

                    <div class="modal-body" style="background:#F8FAFC; padding:28px;">

                        <div class="row">

                            {{-- Nama --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="tambah_name"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#2E7D32;"></i> Nama Lengkap
                                    </label>
                                    <input type="text" name="name" id="tambah_name"
                                        placeholder="Masukkan nama lengkap" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                    <div class="invalid-feedback" id="error_name"></div>
                                </div>
                            </div>

                            {{-- NIK --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="tambah_nik"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-id-card" style="color:#2E7D32;"></i> NIK
                                    </label>
                                    <input type="text" name="nik" id="tambah_nik" placeholder="Masukkan NIK"
                                        maxlength="50" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                    <div class="invalid-feedback" id="error_nik"></div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="tambah_email"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-envelope" style="color:#2E7D32;"></i> Email
                                    </label>
                                    <input type="email" name="email" id="tambah_email" placeholder="Masukkan email"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                    <div class="invalid-feedback" id="error_email"></div>
                                </div>
                            </div>

                            {{-- Level --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="tambah_level"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user-tag" style="color:#2E7D32;"></i> Level
                                    </label>
                                    <select name="level" id="tambah_level" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Level --</option>
                                        <option value="penduduk">Penduduk</option>
                                        <option value="aparat">Aparat</option>
                                    </select>
                                    <div class="invalid-feedback" id="error_level"></div>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="tambah_password"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-lock" style="color:#2E7D32;"></i> Password
                                    </label>
                                    <input type="password" name="password" id="tambah_password"
                                        placeholder="Minimal 8 karakter" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                    <div class="invalid-feedback" id="error_password"></div>
                                </div>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label for="tambah_password_confirmation"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-lock" style="color:#2E7D32;"></i> Konfirmasi Password
                                    </label>
                                    <input type="password" name="password_confirmation" id="tambah_password_confirmation"
                                        placeholder="Ulangi password" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                            </div>

                            {{-- Informasi --}}
                            <div class="col-md-12">
                                <div
                                    style="background:#EFF6FF; border:1.5px solid #BFDBFE; border-radius:10px; padding:14px 16px; color:#1D4ED8; font-size:14px; display:flex; align-items:flex-start; gap:10px;">
                                    <i class="fas fa-info-circle" style="margin-top:2px;"></i>
                                    <span>
                                        <strong>Informasi:</strong>
                                        Pengguna baru akan otomatis memiliki role
                                        <strong>penduduk</strong> dan status verifikasi
                                        <strong>pending</strong>.
                                    </span>
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
                        <button type="submit" id="btnSimpanVerifikasi"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#256528'" onmouseout="this.style.background='#2E7D32'">
                            <i class="fas fa-save"></i> Tambah Pengguna
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Modal Detail Verifikasi Penduduk --}}
    <div class="modal fade" id="modalDetailVerifikasi" tabindex="-1" role="dialog"
        aria-labelledby="modalDetailVerifikasiLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">

                {{-- Header --}}
                <div class="modal-header" style="background:#0EA5E9; border:none; padding:22px 28px;">
                    <h5 class="modal-title" id="modalDetailVerifikasiLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-check"></i> Detail Verifikasi Penduduk
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body" style="background:#F1F5F9; padding:24px 28px;">

                    {{-- Header Profil --}}
                    <div class="d-flex align-items-center"
                        style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; margin-bottom:20px;">

                        <img id="verifikasi_foto" src="{{ asset('images/default-avatar.png') }}" alt="Foto Penduduk"
                            class="rounded-circle"
                            style="width:92px; height:92px; object-fit:cover; border:3px solid #0EA5E9; box-shadow:0 4px 12px rgba(14,165,233,0.25);">

                        <div class="ml-3">
                            <h4 id="verifikasi_nama"
                                style="font-size:23px; font-weight:800; color:#0F172A; margin-bottom:4px;"></h4>

                            <span id="verifikasi_status"
                                style="font-size:13.5px; font-weight:700; padding:6px 14px; border-radius:999px; display:inline-block;"></span>

                            <div
                                style="margin-top:8px; font-size:15px; font-weight:600; color:#475569; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-id-card"></i>
                                NIK: <span id="verifikasi_nik" style="font-weight:700; color:#1E293B;"></span>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        {{-- Data Akun --}}
                        <div class="col-md-6 mb-3">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; height:100%;">

                                <h6
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-user-circle"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Data Akun
                                </h6>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-user" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Nama
                                            Akun</span>
                                        <span id="verifikasi_name"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-envelope" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Email</span>
                                        <span id="verifikasi_email"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-user-tag" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Role</span>
                                        <span id="verifikasi_role"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0;">
                                    <i class="fas fa-calendar-plus"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Tanggal
                                            Daftar</span>
                                        <span id="verifikasi_tanggal_daftar"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Data Penduduk --}}
                        <div class="col-md-6 mb-3">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; height:100%;">

                                <h6
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-address-card"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Data Penduduk
                                </h6>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-phone" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Nomor
                                            HP</span>
                                        <span id="verifikasi_no_hp"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-venus-mars" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Jenis
                                            Kelamin</span>
                                        <span id="verifikasi_kelamin"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-map-marker-alt"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Tempat
                                            Lahir</span>
                                        <span id="verifikasi_tempat_lahir"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0;">
                                    <i class="fas fa-calendar" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Tanggal
                                            Lahir</span>
                                        <span id="verifikasi_tanggal_lahir"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Informasi Verifikasi --}}
                        <div class="col-md-12">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px;">

                                <h6
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-user-check"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Informasi Verifikasi
                                </h6>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div style="display:flex; gap:12px; padding:9px 0;">
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8; margin-bottom:4px;">Status
                                                    Saat Ini</span>
                                                <span id="verifikasi_status_detail"
                                                    style="font-size:13.5px; font-weight:700; padding:5px 12px; border-radius:8px; display:inline-block;"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div style="display:flex; gap:12px; padding:9px 0;">
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8; margin-bottom:4px;">Email
                                                    Terverifikasi</span>
                                                <span id="verifikasi_email_verified"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer" style="background:#fff; border-top:1.5px solid #EEF1F6; padding:16px 28px;">
                    <button type="button" data-dismiss="modal"
                        style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#F1F5F9; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                        onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>

            </div>

        </div>

    </div>


    <script>
        // AJAX Modal Tambah Verifikasi Penduduk
        $(document).ready(function() {

            $("#formTambahVerifikasi").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Reset error sebelumnya
                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback").text("");

                $.ajax({
                    url: "{{ route('admin.verifikasi.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang menambahkan pengguna verifikasi',
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
                                    'Pengguna berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                // Tutup modal
                                $("#modalTambahVerifikasi").modal("hide");

                                // Reset form
                                $("#formTambahVerifikasi")[0].reset();

                                // Reload halaman
                                location.reload();

                            });

                        } else {

                            let errorMessage =
                                'Terjadi kesalahan saat menambahkan pengguna.';

                            if (response.errors) {

                                if (response.errors.general) {
                                    errorMessage = response.errors.general[0];
                                }

                            } else if (response.message) {

                                errorMessage = response.message;

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

                        // Hapus error sebelumnya
                        $(form).find(".is-invalid")
                            .removeClass("is-invalid");

                        $(form).find(".invalid-feedback")
                            .text("");

                        try {

                            const response = xhr.responseJSON;

                            if (response) {

                                /*
                                 * Error validasi Laravel
                                 *
                                 * Contoh:
                                 * {
                                 *   "message": "Validasi gagal.",
                                 *   "errors": {
                                 *      "name": ["Nama wajib diisi."],
                                 *      "email": ["Email sudah terdaftar."]
                                 *   }
                                 * }
                                 */

                                if (response.errors) {

                                    $.each(response.errors, function(field, messages) {

                                        let input = $("#tambah_" + field);
                                        let errorElement = $("#error_" + field);

                                        if (input.length) {
                                            input.addClass("is-invalid");
                                        }

                                        if (errorElement.length) {
                                            errorElement.text(messages[0]);
                                        }

                                    });

                                    // Ambil pesan error pertama
                                    let firstError = Object.values(
                                        response.errors
                                    )[0];

                                    if (firstError && firstError.length > 0) {
                                        errorMessage = firstError[0];
                                    }

                                } else if (response.message) {

                                    errorMessage = response.message;

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
            $("#formTambahVerifikasi").on("submit", function(event) {

                let isValid = true;
                let form = this;

                // Reset error
                $(form).find(".is-invalid")
                    .removeClass("is-invalid");

                $(form).find(".invalid-feedback")
                    .text("");


                // Validasi input wajib
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


                // Validasi password
                let password = $("#tambah_password").val();
                let passwordConfirmation =
                    $("#tambah_password_confirmation").val();


                if (password !== "" && password.length < 8) {

                    isValid = false;

                    $("#tambah_password")
                        .addClass("is-invalid");

                    $("#error_password")
                        .text("Password minimal 8 karakter.");

                }


                // Validasi konfirmasi password
                if (
                    password !== "" &&
                    passwordConfirmation !== "" &&
                    password !== passwordConfirmation
                ) {

                    isValid = false;

                    $("#tambah_password_confirmation")
                        .addClass("is-invalid");

                    $("#error_password_confirmation")
                        .text("Konfirmasi password tidak cocok.");

                }


                if (!isValid) {

                    event.preventDefault();

                    return false;

                }

            });


            // Hilangkan error ketika user mulai memperbaiki input
            $("#formTambahVerifikasi input, #formTambahVerifikasi select")
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
            let url = `/admin/verifikasi/${id}`;

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


        // Ajax Update Status Verifikasi Penduduk
        $(document).on('change', '.select-status-verifikasi', function() {

            let selectElement = $(this);
            let id = selectElement.data('id');
            let status = selectElement.val();
            let oldStatus = selectElement.data('old-status');

            Swal.fire({
                title: "Konfirmasi Verifikasi",
                text: "Yakin ingin mengubah status verifikasi penduduk?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, ubah!",
                cancelButtonText: "Batal"

            }).then((swalResult) => {

                // Jika admin membatalkan
                if (!swalResult.isConfirmed) {
                    selectElement.val(oldStatus);
                    return;
                }

                fetch(`/admin/verifikasi/${id}/status`, {
                        method: "PUT",

                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",

                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },

                        body: JSON.stringify({
                            status_verifikasi: status
                        })
                    })

                    .then(async response => {

                        let responseText = await response.text();

                        console.log(
                            'Status HTTP:',
                            response.status
                        );

                        console.log(
                            'Respons server:',
                            responseText
                        );

                        let result;

                        try {
                            result = JSON.parse(responseText);
                        } catch (error) {
                            throw new Error(
                                'Respons server bukan JSON: ' +
                                responseText
                            );
                        }

                        if (!response.ok) {
                            throw new Error(
                                result.message ||
                                'Gagal mengubah status verifikasi.'
                            );
                        }

                        return result;
                    })

                    .then(result => {

                        if (result.success) {

                            // Simpan status terbaru
                            selectElement.data(
                                'old-status',
                                status
                            );

                            Swal.fire({
                                title: 'Berhasil!',
                                text: result.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {

                                // Reload halaman agar data terbaru ditampilkan
                                window.location.reload();

                            });

                        } else {

                            // Kembalikan dropdown ke status sebelumnya
                            selectElement.val(oldStatus);

                            Swal.fire(
                                'Gagal!',
                                result.message ||
                                'Status verifikasi gagal diperbarui.',
                                'error'
                            );
                        }

                    })

                    .catch(error => {

                        console.error(
                            'Error update status verifikasi:',
                            error
                        );

                        // Kembalikan dropdown ke status sebelumnya
                        selectElement.val(oldStatus);

                        Swal.fire(
                            'Gagal!',
                            error.message ||
                            'Terjadi kesalahan pada server.',
                            'error'
                        );

                    });

            });

        });

        // =====================================================
        // AJAX DETAIL VERIFIKASI PENDUDUK
        // =====================================================

        $(document).on(
            'click',
            '.btn-detail-verifikasi',
            function() {

                let id = $(this).data('id');


                // Reset data sebelum request
                $('#verifikasi_nama').text('Memuat...');
                $('#verifikasi_name').text('-');
                $('#verifikasi_nik').text('-');
                $('#verifikasi_email').text('-');
                $('#verifikasi_role').text('-');
                $('#verifikasi_no_hp').text('-');
                $('#verifikasi_kelamin').text('-');
                $('#verifikasi_tempat_lahir').text('-');
                $('#verifikasi_tanggal_lahir').text('-');
                $('#verifikasi_tanggal_daftar').text('-');


                // Tampilkan modal
                $('#modalDetailVerifikasi').modal('show');


                // Request detail
                $.ajax({

                    url: `/admin/verifikasi/${id}`,

                    type: 'GET',

                    dataType: 'json',


                    success: function(response) {

                        if (!response.success) {

                            Swal.fire(
                                'Gagal!',
                                response.message ||
                                'Data verifikasi tidak ditemukan.',
                                'error'
                            );

                            $('#modalDetailVerifikasi').modal('hide');

                            return;

                        }


                        // Data user
                        let user = response.data;

                        // Data penduduk dari relasi
                        let penduduk =
                            user.penduduk || {};


                        // =================================================
                        // FOTO
                        // =================================================

                        let foto =
                            penduduk.foto ?
                            `/storage/${penduduk.foto}` :
                            "{{ asset('images/default-avatar.png') }}";


                        $('#verifikasi_foto')
                            .attr('src', foto);


                        // =================================================
                        // DATA UTAMA
                        // =================================================

                        $('#verifikasi_nama')
                            .text(
                                penduduk.nama_lengkap ||
                                user.name ||
                                '-'
                            );


                        $('#verifikasi_name')
                            .text(
                                user.name ||
                                '-'
                            );


                        $('#verifikasi_nik')
                            .text(
                                penduduk.nik ||
                                user.nik ||
                                '-'
                            );


                        $('#verifikasi_email')
                            .text(
                                user.email ||
                                '-'
                            );


                        $('#verifikasi_role')
                            .text(
                                user.role ||
                                '-'
                            );


                        $('#verifikasi_no_hp')
                            .text(
                                penduduk.no_hp ||
                                '-'
                            );


                        $('#verifikasi_kelamin')
                            .text(
                                penduduk.jenis_kelamin ||
                                '-'
                            );


                        $('#verifikasi_tempat_lahir')
                            .text(
                                penduduk.tempat_lahir ||
                                '-'
                            );


                        // =================================================
                        // FORMAT TANGGAL LAHIR
                        // =================================================

                        let tanggalLahir = '-';

                        if (
                            penduduk.tanggal_lahir
                        ) {

                            tanggalLahir =
                                moment(
                                    penduduk.tanggal_lahir
                                ).format(
                                    'DD-MM-YYYY'
                                );

                        }


                        $('#verifikasi_tanggal_lahir')
                            .text(
                                tanggalLahir
                            );


                        // =================================================
                        // FORMAT TANGGAL DAFTAR
                        // =================================================

                        let tanggalDaftar = '-';

                        if (
                            user.created_at
                        ) {

                            tanggalDaftar =
                                moment(
                                    user.created_at
                                ).format(
                                    'DD-MM-YYYY HH:mm'
                                );

                        }


                        $('#verifikasi_tanggal_daftar')
                            .text(
                                tanggalDaftar
                            );


                        // =================================================
                        // STATUS VERIFIKASI
                        // =================================================

                        let status =
                            user.status_verifikasi ||
                            'pending';


                        let statusText =
                            'Menunggu';


                        let statusClass =
                            'badge-warning';


                        if (
                            status ===
                            'disetujui'
                        ) {

                            statusText =
                                '✓ Disetujui';

                            statusClass =
                                'badge-success';

                        }


                        if (
                            status ===
                            'ditolak'
                        ) {

                            statusText =
                                '✕ Ditolak';

                            statusClass =
                                'badge-danger';

                        }


                        // Badge header
                        $('#verifikasi_status')

                            .removeClass(
                                'badge-warning ' +
                                'badge-success ' +
                                'badge-danger'
                            )

                            .addClass(
                                statusClass
                            )

                            .text(
                                statusText
                            );


                        // Badge informasi verifikasi
                        $('#verifikasi_status_detail')

                            .removeClass(
                                'badge-warning ' +
                                'badge-success ' +
                                'badge-danger'
                            )

                            .addClass(
                                statusClass
                            )

                            .text(
                                statusText
                            );


                        // =================================================
                        // STATUS EMAIL
                        // =================================================

                        let emailVerified =
                            user.email_verified_at ?
                            '✓ Sudah terverifikasi' :
                            'Belum terverifikasi';


                        $('#verifikasi_email_verified')

                            .text(
                                emailVerified
                            );

                    },


                    error: function(xhr) {

                        console.error(
                            'Gagal mengambil detail verifikasi:',
                            xhr.responseText
                        );


                        $('#modalDetailVerifikasi')
                            .modal('hide');


                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat mengambil detail penduduk.',
                            'error'
                        );

                    }

                });

            }
        );

        $(document).ready(function() {

            // =========================================================
            // AJAX SEARCH, FILTER & PAGINATION VERIFIKASI
            // =========================================================

            function loadVerifikasi(page = 1, query = '', status = '', role = '') {

                $.ajax({
                    url: "{{ route('admin.verifikasi.paginate') }}",
                    type: "GET",

                    data: {
                        page: page,
                        search: query,
                        status: status,
                        role: role
                    },

                    beforeSend: function() {

                        $('#verifikasiTable tbody').html(`
                    <tr>
                        <td colspan="8"
                            style="
                                padding:30px;
                                text-align:center;
                                color:#64748B;
                                font-size:14px;
                                border:1.5px solid #CBD5E1;
                            ">

                            <i class="fas fa-spinner fa-spin"
                                style="font-size:20px; margin-right:6px;">
                            </i>

                            Memuat data...

                        </td>
                    </tr>
                `);

                    },

                    success: function(response) {

                        console.log('Response verifikasi:', response);

                        let tbody = $('#verifikasiTable tbody');

                        tbody.empty();


                        // =====================================================
                        // CEK DATA
                        // =====================================================

                        if (!response.data || response.data.length === 0) {

                            tbody.html(`
                        <tr>
                            <td colspan="8"
                                style="
                                    padding:30px;
                                    text-align:center;
                                    color:#64748B;
                                    font-size:14px;
                                    border:1.5px solid #CBD5E1;
                                ">

                                <i class="fas fa-users"
                                    style="
                                        font-size:25px;
                                        color:#94A3B8;
                                        margin-bottom:8px;
                                    ">
                                </i>

                                <br>

                                Data pengguna belum tersedia.

                            </td>
                        </tr>
                    `);

                            $('#paginationLinks').empty();

                            return;
                        }


                        // =====================================================
                        // TAMPILKAN DATA
                        // =====================================================

                        response.data.forEach(function(data, index) {

                            // -----------------------------------------------
                            // DATA PENDUDUK
                            // -----------------------------------------------

                            let penduduk = data.penduduk || {};


                            // -----------------------------------------------
                            // NAMA
                            // -----------------------------------------------

                            let nama =
                                penduduk.nama_lengkap ||
                                data.name ||
                                '-';


                            // -----------------------------------------------
                            // EMAIL
                            // -----------------------------------------------

                            let email =
                                data.email ||
                                '-';


                            // -----------------------------------------------
                            // ROLE
                            // -----------------------------------------------

                            let role = data.role || '';

                            let roleBadge = '';


                            if (role === 'aparat') {

                                roleBadge = `
                            <span
                                style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:6px;
                                    background:#E0F2FE;
                                    color:#0369A1;
                                    border:1.5px solid #BAE6FD;
                                    font-size:13px;
                                    font-weight:600;
                                    padding:5px 10px;
                                    border-radius:8px;
                                ">

                                <i class="fas fa-user-tie"></i>
                                Aparat

                            </span>
                        `;

                            } else if (role === 'penduduk') {

                                roleBadge = `
                            <span
                                style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:6px;
                                    background:#F1F5F9;
                                    color:#475569;
                                    border:1.5px solid #CBD5E1;
                                    font-size:13px;
                                    font-weight:600;
                                    padding:5px 10px;
                                    border-radius:8px;
                                ">

                                <i class="fas fa-user"></i>
                                Penduduk

                            </span>
                        `;

                            } else {

                                roleBadge = `
                            <span
                                style="
                                    display:inline-flex;
                                    align-items:center;
                                    background:#F1F5F9;
                                    color:#334155;
                                    border:1.5px solid #CBD5E1;
                                    font-size:13px;
                                    font-weight:600;
                                    padding:5px 10px;
                                    border-radius:8px;
                                ">

                                ${role || '-'}

                            </span>
                        `;
                            }


                            // -----------------------------------------------
                            // TANGGAL DAFTAR
                            // -----------------------------------------------

                            let tanggalDaftar = '-';

                            if (data.created_at) {

                                let tanggal = new Date(data.created_at);

                                if (!isNaN(tanggal.getTime())) {

                                    let hari =
                                        String(tanggal.getDate()).padStart(2, '0');

                                    let bulan =
                                        String(tanggal.getMonth() + 1).padStart(2, '0');

                                    let tahun =
                                        tanggal.getFullYear();

                                    let jam =
                                        String(tanggal.getHours()).padStart(2, '0');

                                    let menit =
                                        String(tanggal.getMinutes()).padStart(2, '0');

                                    tanggalDaftar =
                                        `${hari}-${bulan}-${tahun} ${jam}:${menit}`;
                                }
                            }


                            // -----------------------------------------------
                            // STATUS VERIFIKASI
                            // -----------------------------------------------

                            let statusVerifikasi =
                                data.status_verifikasi || 'pending';


                            // -----------------------------------------------
                            // NOMOR
                            // -----------------------------------------------

                            let nomor =
                                (response.from || 1) + index;


                            // -----------------------------------------------
                            // ROW BACKGROUND
                            // -----------------------------------------------

                            let rowBg =
                                index % 2 === 1 ?
                                '#F8FAFC' :
                                '#fff';


                            // =================================================
                            // ROW
                            // =================================================

                            let row = `
                        <tr
                            style="
                                background:${rowBg};
                                transition:background .15s;
                            "
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            {{-- Nomor --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    font-size:15px;
                                    font-weight:700;
                                    color:#334155;
                                    border:1.5px solid #CBD5E1;
                                    text-align:center;
                                ">

                                ${nomor}

                            </td>


                            {{-- Nama --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    font-size:15px;
                                    font-weight:600;
                                    color:#0F172A;
                                    border:1.5px solid #CBD5E1;
                                ">

                                ${nama}

                            </td>


                            {{-- Email --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    font-size:14px;
                                    font-weight:500;
                                    color:#334155;
                                    border:1.5px solid #CBD5E1;
                                ">

                                ${email}

                            </td>


                            {{-- Role --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    border:1.5px solid #CBD5E1;
                                ">

                                ${roleBadge}

                            </td>


                            {{-- Tanggal --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    font-size:14px;
                                    font-weight:500;
                                    color:#334155;
                                    border:1.5px solid #CBD5E1;
                                    white-space:nowrap;
                                ">

                                ${tanggalDaftar}

                            </td>


                            {{-- Status --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    border:1.5px solid #CBD5E1;
                                    text-align:center;
                                ">

                                <select
                                    class="select-status-verifikasi"
                                    data-id="${data.id}"
                                    data-old-status="${statusVerifikasi}"
                                    style="
                                        width:130px;
                                        padding:8px 10px;
                                        font-size:13.5px;
                                        font-weight:600;
                                        color:#1E293B;
                                        border:1.5px solid #E2E8F0;
                                        border-radius:8px;
                                        background:#F8FAFC;
                                        outline:none;
                                        transition:border-color .15s;
                                    "
                                    onfocus="this.style.borderColor='#2E7D32'"
                                    onblur="this.style.borderColor='#E2E8F0'">

                                    <option
                                        value="pending"
                                        ${statusVerifikasi === 'pending' ? 'selected' : ''}>
                                        ⏳ Menunggu
                                    </option>

                                    <option
                                        value="disetujui"
                                        ${statusVerifikasi === 'disetujui' ? 'selected' : ''}>
                                        ✅ Disetujui
                                    </option>

                                    <option
                                        value="ditolak"
                                        ${statusVerifikasi === 'ditolak' ? 'selected' : ''}>
                                        ❌ Ditolak
                                    </option>

                                </select>

                            </td>


                            {{-- Aksi --}}
                            <td
                                style="
                                    padding:14px 18px;
                                    border:1.5px solid #CBD5E1;
                                    text-align:center;
                                ">

                                <div
                                    style="
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        gap:6px;
                                    ">

                                    {{-- Detail --}}
                                    <button
                                        type="button"
                                        class="btn-detail-verifikasi"
                                        data-id="${data.id}"
                                        title="Lihat Detail"
                                        style="
                                            width:36px;
                                            height:36px;
                                            border-radius:8px;
                                            border:1.5px solid #93C5FD;
                                            background:#EFF6FF;
                                            color:#2563EB;
                                            font-size:15px;
                                            cursor:pointer;
                                            transition:all .15s;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        "
                                        onmouseover="this.style.background='#3B82F6';this.style.color='#fff'"
                                        onmouseout="this.style.background='#EFF6FF';this.style.color='#2563EB'">

                                        <i class="fas fa-eye"></i>

                                    </button>


                                    {{-- Hapus --}}
                                    <button
                                        type="button"
                                        class="btn-hapus"
                                        data-id="${data.id}"
                                        title="Hapus"
                                        style="
                                            width:36px;
                                            height:36px;
                                            border-radius:8px;
                                            border:1.5px solid #EF4444;
                                            background:#FFF0F0;
                                            color:#B91C1C;
                                            font-size:15px;
                                            cursor:pointer;
                                            transition:all .15s;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        "
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


                        // =====================================================
                        // PAGINATION
                        // =====================================================

                        let paginationLinks =
                            $('#paginationLinks');

                        paginationLinks.empty();


                        if (
                            response.last_page &&
                            response.last_page > 1
                        ) {


                            // =================================================
                            // PREVIOUS
                            // =================================================

                            if (response.current_page > 1) {

                                paginationLinks.append(`
                            <li class="page-item">

                                <a
                                    href="#"
                                    class="page-link pagination-link"
                                    data-page="${response.current_page - 1}"
                                    style="
                                        width:36px;
                                        height:36px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border:1px solid #E2E8F0;
                                        border-radius:8px;
                                        color:#475569;
                                        background:#fff;
                                        font-size:13px;
                                        text-decoration:none;
                                    "
                                    onmouseover="this.style.background='#F1F5F9'"
                                    onmouseout="this.style.background='#fff'">

                                    <i class="fas fa-chevron-left"></i>

                                </a>

                            </li>
                        `);

                            }


                            // =================================================
                            // NOMOR HALAMAN
                            // =================================================

                            for (
                                let i = 1; i <= response.last_page; i++
                            ) {

                                let isActive =
                                    response.current_page == i;


                                let activeStyle = isActive ?
                                    `
                                background:#2E7D32;
                                color:#fff;
                                border-color:#2E7D32;
                            ` :
                                    `
                                background:#fff;
                                color:#475569;
                                border-color:#E2E8F0;
                            `;


                                paginationLinks.append(`
                            <li class="page-item">

                                <a
                                    href="#"
                                    class="page-link pagination-link"
                                    data-page="${i}"
                                    style="
                                        width:36px;
                                        height:36px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border:1px solid;
                                        border-radius:8px;
                                        font-size:13px;
                                        font-weight:${isActive ? '600' : '500'};
                                        text-decoration:none;
                                        ${activeStyle}
                                    "
                                    onmouseover="
                                        if (!${isActive}) {
                                            this.style.background='#F1F5F9';
                                        }
                                    "
                                    onmouseout="
                                        if (!${isActive}) {
                                            this.style.background='#fff';
                                        }
                                    ">

                                    ${i}

                                </a>

                            </li>
                        `);

                            }


                            // =================================================
                            // NEXT
                            // =================================================

                            if (
                                response.current_page <
                                response.last_page
                            ) {

                                paginationLinks.append(`
                            <li class="page-item">

                                <a
                                    href="#"
                                    class="page-link pagination-link"
                                    data-page="${response.current_page + 1}"
                                    style="
                                        width:36px;
                                        height:36px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border:1px solid #E2E8F0;
                                        border-radius:8px;
                                        color:#475569;
                                        background:#fff;
                                        font-size:13px;
                                        text-decoration:none;
                                    "
                                    onmouseover="this.style.background='#F1F5F9'"
                                    onmouseout="this.style.background='#fff'">

                                    <i class="fas fa-chevron-right"></i>

                                </a>

                            </li>
                        `);

                            }

                        }

                    },


                    // =========================================================
                    // ERROR
                    // =========================================================

                    error: function(xhr) {

                        console.error(
                            'Error AJAX verifikasi:',
                            xhr.responseText
                        );


                        $('#verifikasiTable tbody').html(`
                    <tr>
                        <td colspan="8"
                            style="
                                padding:30px;
                                text-align:center;
                                color:#DC2626;
                                font-size:14px;
                                border:1.5px solid #CBD5E1;
                            ">

                            <i class="fas fa-exclamation-circle"
                                style="
                                    font-size:24px;
                                    margin-bottom:8px;
                                ">
                            </i>

                            <br>

                            Gagal memuat data pengguna.

                        </td>
                    </tr>
                `);


                        $('#paginationLinks').empty();


                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat data verifikasi.'
                        });

                    }

                });

            }


            // =========================================================
            // LOAD PERTAMA
            // =========================================================

            loadVerifikasi();


            // =========================================================
            // SEARCH
            // =========================================================

            $('#searchInput').on('keyup', function() {

                let query =
                    $(this).val();

                let status =
                    $('#filterStatus').val() || '';

                let role =
                    $('#filterRole').val() || '';


                loadVerifikasi(
                    1,
                    query,
                    status,
                    role
                );

            });


            // =========================================================
            // FILTER STATUS
            // =========================================================

            $('#filterStatus').on('change', function() {

                let status =
                    $(this).val();

                let query =
                    $('#searchInput').val() || '';

                let role =
                    $('#filterRole').val() || '';


                loadVerifikasi(
                    1,
                    query,
                    status,
                    role
                );

            });


            // =========================================================
            // FILTER ROLE
            // =========================================================

            $('#filterRole').on('change', function() {

                let role =
                    $(this).val();

                let query =
                    $('#searchInput').val() || '';

                let status =
                    $('#filterStatus').val() || '';


                loadVerifikasi(
                    1,
                    query,
                    status,
                    role
                );

            });


            // =========================================================
            // PAGINATION
            // =========================================================

            $(document).on(
                'click',
                '.pagination-link',
                function(e) {

                    e.preventDefault();


                    let page =
                        $(this).data('page');

                    let query =
                        $('#searchInput').val() || '';

                    let status =
                        $('#filterStatus').val() || '';

                    let role =
                        $('#filterRole').val() || '';


                    loadVerifikasi(
                        page,
                        query,
                        status,
                        role
                    );

                }
            );

        });
    </script>
@endsection
