@extends('admin.layouts.app')

@section('page-title', 'Data-Penduduk Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-users" style="color:#2E7D32;"></i> Data Penduduk
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.penduduk.index') }}">Data Penduduk</a></div>
                    <div class="breadcrumb-item">Penduduk</div>
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
                                List Data Penduduk
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahPenduduk"
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
                                <table class="table mb-0" id="pendudukTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Lengkap</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                NIK</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Tempat & Tgl Lahir</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Alamat</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Pekerjaan</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penduduk as $index => $data)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1; letter-spacing:0.1px;">
                                                    {{ $data->nama_lengkap }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->nik }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                                    {{ $data->tempat_lahir }},
                                                    {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y') }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    {{ $data->alamat }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                                    {{ $data->jenis_pekerjaan }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        <a href="#" data-id="{{ $data->id }}" title="Detail"
                                                            class="btn-detail"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #93C5FD; background:#EFF6FF; color:#1D4ED8; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                                            onmouseover="this.style.background='#3B82F6';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#EFF6FF';this.style.color='#1D4ED8'">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
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
                                        @empty
                                            <tr>
                                                <td colspan="7"
                                                    style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                                    <i class="fas fa-user-slash fa-2x mb-3"
                                                        style="opacity:0.3; display:block;"></i>
                                                    <span style="font-size:15px; font-weight:500;">Belum ada data
                                                        penduduk</span>
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
                                    <!-- Link pagination akan dimuat di sini -->
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        #paginationLinks .page-link {
            border: 1.5px solid #E2E8F0 !important;
            border-radius: 8px !important;
            margin: 0 3px;
            color: #2E7D32;
            font-weight: 600;
            font-size: .9rem;
        }

        #paginationLinks .page-item.active .page-link {
            background: #2E7D32 !important;
            border-color: #2E7D32 !important;
            color: #fff !important;
        }

        #paginationLinks .page-link:hover {
            background: #EEF2FF;
        }
    </style>


    {{-- Modal Tambah Penduduk --}}
    <div class="modal fade" id="modalTambahPenduduk" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahPendudukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahPendudukLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-plus"></i> Tambah Penduduk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="padding:28px; background:#F8FAFC;">
                    <form enctype="multipart/form-data" id="formPenduduk">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#2E7D32; margin:4px 0 16px; padding-bottom:10px; border-bottom:2px solid #DCFCE7;">
                                    Identitas
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">NIK</label>
                                    <input type="text" id="nik" name="nik" pattern="\d{16}" maxlength="16"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                        Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Jenis
                                        Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Pendidikan</label>
                                    <select id="pendidikan" name="pendidikan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="Strata 1">Strata 1</option>
                                        <option value="Strata 2">Strata 2</option>
                                        <option value="Strata 3">Strata 3</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tempat
                                        Lahir</label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tanggal
                                        Lahir</label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Golongan
                                        Darah (Opsional)</label>
                                    <select id="golongan_darah" name="golongan_darah"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="Tidak Tahu">Tidak Tahu</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Jenis
                                        Pekerjaan</label>
                                    <input type="text" id="jenis_pekerjaan" name="jenis_pekerjaan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Agama</label>
                                    <select id="agama" name="agama" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Status
                                        Perkawinan</label>
                                    <select id="status_perkawinan" name="status_perkawinan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Status Perkawinan</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                    </select>
                                </div>

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#2E7D32; margin:26px 0 16px; padding-bottom:10px; border-bottom:2px solid #DCFCE7;">
                                    Data Keluarga
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6" style="margin-bottom:18px;">
                                        <label
                                            style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                            Ibu</label>
                                        <input type="text" id="ibu" name="ibu" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">
                                    </div>
                                    <div class="form-group col-md-6" style="margin-bottom:18px;">
                                        <label
                                            style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                            Ayah</label>
                                        <input type="text" id="ayah" name="ayah" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#2E7D32; margin:4px 0 16px; padding-bottom:10px; border-bottom:2px solid #DCFCE7;">
                                    Status &amp; Foto
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Status
                                        Hubungan Keluarga</label>
                                    <select id="status_hubungan_dalam_keluarga" name="status_hubungan_dalam_keluarga"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Status Hubungan</option>
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Mertua">Mertua</option>
                                        <option value="Cucu">Cucu</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tanggal
                                        Perkawinan (Opsional)</label>
                                    <input type="date" id="tanggal_perkawinan" name="tanggal_perkawinan"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Foto
                                        (Opsional)</label>
                                    <input type="file" id="foto" name="foto"
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
                                        style="width:100%; padding:9px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#2E7D32; margin:26px 0 16px; padding-bottom:10px; border-bottom:2px solid #DCFCE7;">
                                    Alamat
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Alamat</label>
                                    <input type="text" id="alamat" name="alamat" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Dusun
                                        (Opsional)</label>
                                    <input type="text" id="dusun" name="dusun"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Desa/Kelurahan</label>
                                    <input type="text" id="desa_kelurahan" name="desa_kelurahan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kecamatan</label>
                                    <input type="text" id="kecamatan" name="kecamatan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kabupaten/Kota</label>
                                    <input type="text" id="kabupaten_kota" name="kabupaten_kota" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Provinsi</label>
                                    <input type="text" id="provinsi" name="provinsi" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kewarganegaraan</label>
                                    <select id="kewarganegaraan" name="kewarganegaraan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Kewarganegaraan</option>
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer"
                            style="background:#fff; border-top:1.5px solid #F1F5F9; padding:18px 0 0; margin-top:10px; gap:10px;">
                            <button type="button" data-dismiss="modal"
                                style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                                onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit"
                                style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                                onmouseover="this.style.background='#256528'"
                                onmouseout="this.style.background='#2E7D32'">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Edit Penduduk --}}
    <div class="modal fade" id="modalEditPenduduk" tabindex="-1" role="dialog"
        aria-labelledby="modalEditPendudukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditPendudukLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-edit"></i> Edit Penduduk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="padding:28px; background:#FFFBEB;">
                    <form action="{{ route('admin.penduduk.update', $penduduk->id ?? '') }}" method="POST"
                        enctype="multipart/form-data" id="formEditPenduduk">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id"
                            value="{{ old('id', $penduduk->id ?? '') }}">
                        <div class="row">
                            <div class="col-md-6">

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#B45309; margin:4px 0 16px; padding-bottom:10px; border-bottom:2px solid #FDE68A;">
                                    Identitas
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">NIK</label>
                                    <input type="text" id="edit_nik" name="nik" pattern="\d{16}" maxlength="16"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                        Lengkap</label>
                                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Jenis
                                        Kelamin</label>
                                    <select id="edit_jenis_kelamin" name="jenis_kelamin" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Pendidikan</label>
                                    <select id="edit_pendidikan" name="pendidikan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="Strata 1">Strata 1</option>
                                        <option value="Strata 2">Strata 2</option>
                                        <option value="Strata 3">Strata 3</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tempat
                                        Lahir</label>
                                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tanggal
                                        Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Golongan
                                        Darah (Opsional)</label>
                                    <select id="edit_golongan_darah" name="golongan_darah"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="Tidak Tahu">Tidak Tahu</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Jenis
                                        Pekerjaan</label>
                                    <input type="text" id="edit_jenis_pekerjaan" name="jenis_pekerjaan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Agama</label>
                                    <select id="edit_agama" name="agama" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Status
                                        Perkawinan</label>
                                    <select id="edit_status_perkawinan" name="status_perkawinan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                    </select>
                                </div>

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#B45309; margin:26px 0 16px; padding-bottom:10px; border-bottom:2px solid #FDE68A;">
                                    Data Keluarga
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6" style="margin-bottom:18px;">
                                        <label
                                            style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                            Ibu</label>
                                        <input type="text" id="edit_ibu" name="ibu" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">
                                    </div>
                                    <div class="form-group col-md-6" style="margin-bottom:18px;">
                                        <label
                                            style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Nama
                                            Ayah</label>
                                        <input type="text" id="edit_ayah" name="ayah" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#B45309; margin:4px 0 16px; padding-bottom:10px; border-bottom:2px solid #FDE68A;">
                                    Status &amp; Foto
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Status
                                        Hubungan Keluarga</label>
                                    <select id="edit_status_hubungan_dalam_keluarga" name="status_hubungan_dalam_keluarga"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Mertua">Mertua</option>
                                        <option value="Cucu">Cucu</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Tanggal
                                        Perkawinan</label>
                                    <input type="date" id="edit_tanggal_perkawinan" name="tanggal_perkawinan"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Foto</label>
                                    <input type="file" id="edit_foto" name="foto"
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
                                        style="width:100%; padding:9px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                    <small
                                        style="display:block; margin-top:6px; font-size:13.5px; color:#64748B;">Kosongkan
                                        jika tidak ingin mengubah foto.</small>
                                </div>

                                <div
                                    style="font-size:13.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#B45309; margin:26px 0 16px; padding-bottom:10px; border-bottom:2px solid #FDE68A;">
                                    Alamat
                                </div>

                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Alamat</label>
                                    <input type="text" id="edit_alamat" name="alamat" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Dusun
                                        (Opsional)</label>
                                    <input type="text" id="edit_dusun" name="dusun"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Desa/Kelurahan</label>
                                    <input type="text" id="edit_desa_kelurahan" name="desa_kelurahan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kecamatan</label>
                                    <input type="text" id="edit_kecamatan" name="kecamatan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kabupaten/Kota</label>
                                    <input type="text" id="edit_kabupaten_kota" name="kabupaten_kota" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Provinsi</label>
                                    <input type="text" id="edit_provinsi" name="provinsi" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                                <div class="form-group" style="margin-bottom:18px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:block; margin-bottom:8px;">Kewarganegaraan</label>
                                    <select id="edit_kewarganegaraan" name="kewarganegaraan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:46px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer"
                            style="background:#fff; border-top:1.5px solid #F1F5F9; padding:18px 0 0; margin-top:10px; gap:10px;">
                            <button type="button" data-dismiss="modal"
                                style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                                onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit"
                                style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#F59E0B; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                                onmouseover="this.style.background='#D97706'"
                                onmouseout="this.style.background='#F59E0B'">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Detail Penduduk --}}
    <div class="modal fade" id="modalDetailPenduduk" tabindex="-1" role="dialog"
        aria-labelledby="modalDetailPendudukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border:none; border-radius:16px; overflow:hidden;">

                <div class="modal-header" style="background:#0EA5E9; border:none; padding:22px 28px;">
                    <h5 class="modal-title" id="modalDetailPendudukLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user"></i> Detail Penduduk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="background:#F1F5F9; padding:24px 28px;">

                    {{-- Header profil --}}
                    <div class="d-flex align-items-center"
                        style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; margin-bottom:20px;">
                        <img id="detail_foto" src="{{ asset('images/default-avatar.png') }}" alt="Foto Penduduk"
                            class="rounded-circle"
                            style="width:92px; height:92px; object-fit:cover; border:3px solid #0EA5E9; box-shadow:0 4px 12px rgba(14,165,233,0.25);">
                        <div class="ml-3">
                            <h4 id="detail_nama"
                                style="font-size:23px; font-weight:800; color:#0F172A; margin-bottom:4px;"></h4>
                            <span id="detail_status_keluarga"
                                style="font-size:13.5px; font-weight:700; padding:6px 14px; border-radius:999px; background:#E0F2FE; color:#0369A1; display:inline-block;"></span>
                            <span
                                style="display:inline-flex; align-items:center; gap:6px; font-size:15px; font-weight:600; color:#475569; margin-top:6px;">
                                <i class="fas fa-id-card"></i> <span id="detail_nik"></span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Data Pribadi --}}
                        <div class="col-md-6 mb-3">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; height:100%;">
                                <div
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-user"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Data Pribadi
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-venus-mars" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Jenis
                                            Kelamin</span>
                                        <span id="detail_kelamin"
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
                                        <span id="detail_tempat_lahir"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-calendar" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Tanggal
                                            Lahir</span>
                                        <span id="detail_tanggal_lahir"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-tint" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Golongan
                                            Darah</span>
                                        <span id="detail_golongan_darah"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-school" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Pendidikan</span>
                                        <span id="detail_pendidikan"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-briefcase" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Pekerjaan</span>
                                        <span id="detail_pekerjaan"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-praying-hands"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Agama</span>
                                        <span id="detail_agama"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0;">
                                    <i class="fas fa-flag" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Kewarganegaraan</span>
                                        <span id="detail_kewarganegaraan"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Data Keluarga --}}
                        <div class="col-md-6 mb-3">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px; height:100%;">
                                <div
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-users"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Data Keluarga
                                </div>

                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-ring" style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Status
                                            Perkawinan</span>
                                        <span id="detail_status_perkawinan"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-calendar-day"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Tanggal
                                            Perkawinan</span>
                                        <span id="detail_tanggal_perkawinan"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                    <i class="fas fa-user-friends"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Nama
                                            Ayah</span>
                                        <span id="detail_ayah"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                                <div style="display:flex; gap:12px; padding:9px 0;">
                                    <i class="fas fa-user-friends"
                                        style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                    <div>
                                        <span
                                            style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Nama
                                            Ibu</span>
                                        <span id="detail_ibu"
                                            style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-12">
                            <div
                                style="background:#fff; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,0.06); padding:20px;">
                                <div
                                    style="display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0369A1; padding-bottom:12px; margin-bottom:16px; border-bottom:2px solid #E0F2FE;">
                                    <i class="fas fa-home"
                                        style="width:32px; height:32px; border-radius:50%; background:#E0F2FE; display:inline-flex; align-items:center; justify-content:center; font-size:14px;"></i>
                                    Alamat
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                            <i class="fas fa-location-dot"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Alamat</span>
                                                <span id="detail_alamat"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                        <div
                                            style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                            <i class="fas fa-house"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Dusun</span>
                                                <span id="detail_dusun"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                        <div style="display:flex; gap:12px; padding:9px 0;">
                                            <i class="fas fa-signs-post"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Desa/Kelurahan</span>
                                                <span id="detail_desa"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                            <i class="fas fa-building"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Kecamatan</span>
                                                <span id="detail_kecamatan"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                        <div
                                            style="display:flex; gap:12px; padding:9px 0; border-bottom:1px dashed #EEF2F6;">
                                            <i class="fas fa-city"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Kabupaten/Kota</span>
                                                <span id="detail_kabupaten"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                        <div style="display:flex; gap:12px; padding:9px 0;">
                                            <i class="fas fa-earth-asia"
                                                style="width:20px; padding-top:3px; color:#94A3B8;"></i>
                                            <div>
                                                <span
                                                    style="display:block; font-size:12.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:#94A3B8;">Provinsi</span>
                                                <span id="detail_provinsi"
                                                    style="display:block; font-size:16px; font-weight:600; color:#1E293B;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        // Ajax modal tambah penduduk
        $(document).ready(function() {
            $("#formPenduduk").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.penduduk.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang memproses data penduduk',
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
                                    'Penduduk berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href =
                                    "{{ route('admin.penduduk.index') }}";
                            });
                        } else {
                            // Tangani error dari controller yang mengembalikan success: false
                            let errorMessage = 'Terjadi kesalahan saat menambahkan penduduk.';

                            if (response.errors && response.errors.general) {
                                errorMessage = response.errors.general[0];
                            } else if (response.errors) {
                                // Jika ada error validasi lainnya, ambil pesan error pertama
                                const firstErrorField = Object.keys(response.errors)[0];
                                errorMessage = response.errors[firstErrorField][0];
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
                        let errorMessage = 'Terjadi kesalahan saat mengirim data.';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors && xhr.responseJSON.errors.general) {
                                errorMessage = xhr.responseJSON.errors.general[0];
                            } else if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                const firstErrorField = Object.keys(xhr.responseJSON.errors)[0];
                                errorMessage = xhr.responseJSON.errors[firstErrorField][0];
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: errorMessage,
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
            });
        });

        //Ajax hapus data
        $(document).ready(function() {
            // Gunakan delegasi event agar tombol tetap bisa digunakan meski render dinamis
            $(document).on("click", ".btn-hapus", function(e) {
                e.preventDefault(); // cegah default link/button

                let id = $(this).data("id");
                let url = `/admin/penduduk/${id}`;

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
                            type: "POST", // Laravel butuh POST jika pakai method spoofing
                            data: {
                                _method: "DELETE", // spoof method DELETE
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // ambil CSRF dari meta tag
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: response.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // refresh halaman setelah sukses
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
        });

        //Ajax Modal Edit Penduduk
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/penduduk/${id}/edit`, // Sesuaikan route edit penduduk
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data;

                        // Isi form modal edit penduduk
                        $("#formEditPenduduk").attr("action", `/admin/penduduk/${id}`);
                        $("#edit_id").val(data.id);
                        $("#edit_nik").val(data.nik);
                        $("#edit_nama_lengkap").val(data.nama_lengkap);
                        $("#edit_jenis_kelamin").val(data.jenis_kelamin);
                        $("#edit_pendidikan").val(data.pendidikan);
                        $("#edit_tempat_lahir").val(data.tempat_lahir);
                        $("#edit_tanggal_lahir").val(data.tanggal_lahir);
                        $("#edit_jenis_pekerjaan").val(data.jenis_pekerjaan);
                        $("#edit_agama").val(data.agama);
                        $("#edit_status_perkawinan").val(data.status_perkawinan);
                        $("#edit_ibu").val(data.ibu);
                        $("#edit_ayah").val(data.ayah);
                        $("#edit_status_hubungan_dalam_keluarga").val(data
                            .status_hubungan_dalam_keluarga);
                        $("#edit_tanggal_perkawinan").val(data.tanggal_perkawinan);
                        $("#edit_alamat").val(data.alamat);
                        $("#edit_dusun").val(data.dusun);
                        $("#edit_desa_kelurahan").val(data.desa_kelurahan);
                        $("#edit_kecamatan").val(data.kecamatan);
                        $("#edit_kabupaten_kota").val(data.kabupaten_kota);
                        $("#edit_provinsi").val(data.provinsi);
                        $("#edit_kewarganegaraan").val(data.kewarganegaraan);

                        // Tampilkan modal
                        $("#modalEditPenduduk").modal("show");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data penduduk tidak ditemukan.",
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


        // Handle Form Submit untuk Update
        $("#formEditPenduduk").submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let id = $("#edit_id").val();

            $.ajax({
                url: `/admin/penduduk/${id}`, // Sesuaikan dengan route update
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Data penduduk berhasil diperbarui.",
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        $("#modalEditPenduduk").modal("hide");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data gagal diperbarui. Silakan coba lagi!",
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
                        icon: "error",
                        title: "Validasi Gagal!",
                        html: `<ul style="text-align:left;">${errorMessages}</ul>`,
                    });
                },
            });
        });

        //Ajax Detail Penduduk
        $(document).ready(function() {
            // Gunakan delegasi event agar tetap bisa diklik walau tombol muncul belakangan
            $(document).on('click', '.btn-detail', function(e) {
                e.preventDefault(); // cegah aksi default href

                var id = $(this).data('id');

                $.ajax({
                    url: '/admin/penduduk/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#detail_nik').text(response.data.nik);
                            $('#detail_nama').text(response.data.nama_lengkap);
                            $('#detail_kelamin').text(response.data.jenis_kelamin);
                            $('#detail_pendidikan').text(response.data.pendidikan);
                            $('#detail_tempat_lahir').text(response.data.tempat_lahir);
                            $('#detail_tanggal_lahir').text(response.data.tanggal_lahir);
                            $('#detail_pekerjaan').text(response.data.jenis_pekerjaan);
                            $('#detail_agama').text(response.data.agama);
                            $('#detail_status_perkawinan').text(response.data
                                .status_perkawinan);
                            $('#detail_ibu').text(response.data.ibu);
                            $('#detail_ayah').text(response.data.ayah);
                            $('#detail_status_keluarga').text(response.data
                                .status_hubungan_dalam_keluarga);
                            $('#detail_tanggal_perkawinan').text(response.data
                                .tanggal_perkawinan || '-');
                            $('#detail_alamat').text(response.data.alamat);
                            $('#detail_dusun').text(response.data.dusun);
                            $('#detail_desa').text(response.data.desa_kelurahan);
                            $('#detail_kecamatan').text(response.data.kecamatan);
                            $('#detail_kabupaten').text(response.data.kabupaten_kota);
                            $('#detail_provinsi').text(response.data.provinsi);
                            $('#detail_kewarganegaraan').text(response.data.kewarganegaraan);

                            if (response.data.foto) {
                                $('#detail_foto').attr('src', '/storage/' + response.data.foto);
                            } else {
                                $('#detail_foto').attr('src', '/images/default-user.png');
                            }

                            $('#modalDetailPenduduk').modal('show');
                        } else {
                            alert('Data penduduk tidak ditemukan!');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan, coba lagi nanti.');
                    }
                });
            });
        });

        //Ajax Cari Penduduk
        $(document).ready(function() {
            // Tangani pencarian saat mengetik
            $('#searchInput').on('keyup', function() {
                var searchQuery = $(this).val();

                // Kirimkan permintaan pencarian melalui Ajax
                $.ajax({
                    url: '/admin/search-penduduk', // Ganti dengan URL yang sesuai untuk pencarian penduduk
                    method: 'GET',
                    data: {
                        query: searchQuery
                    },
                    success: function(response) {
                        // Jika pencarian berhasil, tampilkan hasilnya di tabel
                        var tbody = $('#pendudukTable tbody');
                        tbody.empty(); // Kosongkan tabel sebelumnya

                        if (response.data.length > 0) {
                            response.data.forEach(function(penduduk, index) {
                                var rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                                var row = `
                            <tr style="background:${rowBg}; transition:background .15s;"
                                onmouseover="this.style.background='#EEF2FF'"
                                onmouseout="this.style.background='${rowBg}'">

                                <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                    ${index + 1}
                                </td>

                                <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1; letter-spacing:0.1px;">
                                    ${penduduk.nama_lengkap}
                                </td>

                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                    <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                        ${penduduk.nik}
                                    </span>
                                </td>

                                <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                    ${penduduk.tempat_lahir}, ${moment(penduduk.tanggal_lahir).format('DD-MM-YYYY')}
                                </td>

                                <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                    ${penduduk.alamat}
                                </td>

                                <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                    ${penduduk.jenis_pekerjaan}
                                </td>

                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                    <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                        <a href="#" data-id="${penduduk.id}" title="Detail" class="btn-detail"
                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #93C5FD; background:#EFF6FF; color:#1D4ED8; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                            onmouseover="this.style.background='#3B82F6';this.style.color='#fff'"
                                            onmouseout="this.style.background='#EFF6FF';this.style.color='#1D4ED8'">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="edit-button" data-toggle="modal" data-target="#modalEditPenduduk" data-id="${penduduk.id}" title="Edit"
                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                            onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                            onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-hapus" data-id="${penduduk.id}" title="Hapus"
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

                        } else {
                            tbody.append(`
                        <tr>
                            <td colspan="7" style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-user-slash fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });
        });

        //Ajax Pagination Penduduk
        $(document).ready(function() {

            function formatTanggal(dateStr) {
                if (!dateStr) return '-';

                // Ambil bagian tanggal saja jika berupa datetime (mis. "2001-05-14 00:00:00")
                let datePart = dateStr.split(' ')[0];
                let parts = datePart.split('-');

                if (parts.length !== 3) return dateStr;

                let [year, month, day] = parts;
                return `${day}-${month}-${year}`;
            }

            function loadPenduduk(page = 1) {
                $.ajax({
                    url: "{{ route('admin.penduduk.paginate') }}?page=" + page,
                    type: "GET",
                    success: function(response) {
                        let tbody = $('#pendudukTable tbody');
                        tbody.empty(); // Hapus data lama

                        // Jika tidak ada data
                        if (response.data.length === 0) {
                            tbody.append(`
                        <tr>
                            <td colspan="7" style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-user-slash fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                            return;
                        }

                        response.data.forEach(function(penduduk, index) {
                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1; letter-spacing:0.1px;">
                                ${penduduk.nama_lengkap}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${penduduk.nik}
                                </span>
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1; white-space:nowrap;">
                                ${penduduk.tempat_lahir}, ${formatTanggal(penduduk.tanggal_lahir)}
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                ${penduduk.alamat}
                            </td>

                            <td style="padding:14px 18px; font-size:14px; font-weight:500; color:#334155; border:1.5px solid #CBD5E1;">
                                ${penduduk.jenis_pekerjaan}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <a href="#" data-id="${penduduk.id}" title="Detail" class="btn-detail"
                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #93C5FD; background:#EFF6FF; color:#1D4ED8; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                        onmouseover="this.style.background='#3B82F6';this.style.color='#fff'"
                                        onmouseout="this.style.background='#EFF6FF';this.style.color='#1D4ED8'">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn-edit" data-id="${penduduk.id}" title="Edit"
                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                        onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                        onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-hapus" data-id="${penduduk.id}" title="Hapus"
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

                        // Buat pagination
                        let paginationLinks = $('#paginationLinks');
                        paginationLinks.empty();

                        if (response.last_page > 1) {
                            if (response.current_page > 1) {
                                paginationLinks.append(`<li class="page-item">
                    <a class="page-link pagination-link" href="#" data-page="${response.current_page - 1}">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>`);
                            }

                            for (let i = 1; i <= response.last_page; i++) {
                                let activeClass = response.current_page === i ? 'active' : '';
                                paginationLinks.append(`<li class="page-item ${activeClass}">
                    <a class="page-link pagination-link" href="#" data-page="${i}">${i}</a>
                </li>`);
                            }

                            if (response.current_page < response.last_page) {
                                paginationLinks.append(`<li class="page-item">
                    <a class="page-link pagination-link" href="#" data-page="${response.current_page + 1}">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>`);
                            }
                        }
                    }
                });
            }

            // Panggil fungsi pertama kali
            loadPenduduk();

            // Event untuk tombol pagination
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadPenduduk(page);
            });
        });
    </script>
@endsection
