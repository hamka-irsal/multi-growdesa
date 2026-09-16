<style>
    /* =========================================================
   PROFIL DESA - PENINGKATAN TEKS FORM
   ========================================================= */

    /* Label input */
    #formProfilDesa .form-label {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #1E293B !important;
        margin-bottom: 8px;
    }

    /* Input, textarea, select */
    #formProfilDesa .form-control,
    #formProfilDesa select.form-control {
        font-size: 16px !important;
        font-weight: 500 !important;
        color: #172033 !important;
        min-height: 46px;
        padding: 10px 14px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
    }

    /* Khusus textarea */
    #formProfilDesa textarea.form-control {
        min-height: auto;
        line-height: 1.6;
        resize: vertical;
    }

    /* Placeholder */
    #formProfilDesa .form-control::placeholder {
        color: #64748B !important;
        opacity: 1;
        font-size: 15px;
        font-weight: 400;
    }

    /* Saat input diklik */
    #formProfilDesa .form-control:focus {
        color: #172033 !important;
        font-weight: 500 !important;
        border-color: #47B765 !important;
        box-shadow: 0 0 0 3px rgba(71, 183, 101, 0.12) !important;
    }

    /* File input */
    #formProfilDesa input[type="file"] {
        font-size: 15px !important;
        font-weight: 500 !important;
        color: #172033 !important;
    }

    /* Keterangan kecil */
    #formProfilDesa small {
        font-size: 13px;
        color: #64748B !important;
    }

    /* Input group icon */
    #formProfilDesa .input-group-text {
        font-size: 17px;
        color: #334155;
        background: #F8FAFC;
        border-color: #CBD5E1;
    }

    /* Teks di dalam input group */
    #formProfilDesa .input-group .form-control {
        font-size: 16px !important;
    }

    /* Judul section */
    #formProfilDesa h5 {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #172033 !important;
    }

    /* Deskripsi section */
    #formProfilDesa h5+small {
        font-size: 13px !important;
        color: #64748B !important;
    }

    /* Tombol simpan */
    #btnSimpanProfil {
        font-size: 15px !important;
        font-weight: 700 !important;
        padding: 12px 26px !important;
    }
</style>
@extends('admin.layouts.app')

@section('page-title', 'Data-Aparat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- =========================================================
            HEADER
        ========================================================== --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">

                <h1 style="font-size:clamp(18px,4vw,24px); margin:0; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-landmark" style="color:#2E7D32;"></i>
                    Profil Desa
                </h1>

                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard.index') }}">
                            Dashboard
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        Profil Desa
                    </div>
                </div>

            </div>


            {{-- =========================================================
            FORM PROFIL DESA
        ========================================================== --}}
            <div class="row">

                <div class="col-12">

                    <div class="card"
                        style="
                        border-radius:16px;
                        border:1px solid #E2E8F0;
                        box-shadow:0 4px 20px rgba(0,0,0,0.06);
                        overflow:hidden;
                    ">

                        {{-- =================================================
                        CARD HEADER
                    ================================================== --}}
                        <div class="card-header"
                            style="
                            padding:22px 24px;
                            border-bottom:1px solid #E2E8F0;
                            background:linear-gradient(135deg,#F8FAFC,#FFFFFF);
                            display:flex;
                            align-items:center;
                            gap:14px;
                        ">

                            <div
                                style="
                                width:46px;
                                height:46px;
                                border-radius:12px;
                                background:#E8F5E9;
                                color:#2E7D32;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:20px;
                            ">
                                <i class="fas fa-building"></i>
                            </div>

                            <div>
                                <h4
                                    style="
                                    margin:0;
                                    font-size:17px;
                                    font-weight:700;
                                    color:#1E293B;
                                ">
                                    Informasi Profil Desa
                                </h4>

                                <p
                                    style="
                                    margin:4px 0 0;
                                    font-size:13px;
                                    color:#64748B;
                                ">
                                    Kelola informasi dan identitas desa Anda.
                                </p>
                            </div>

                        </div>


                        {{-- =================================================
                        FORM BODY
                    ================================================== --}}
                        <div class="card-body" style="padding:28px;">

                            <form id="formProfilDesa" enctype="multipart/form-data">

                                @csrf

                                {{-- ID PROFIL --}}
                                <input type="hidden" id="profil_desa_id" value="{{ $profilDesa->id ?? '' }}">


                                {{-- =================================================
                                SECTION 1 - PROFIL UTAMA
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#E8F5E9;
                                            color:#2E7D32;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-home"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Profil Utama
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Informasi utama yang ditampilkan kepada masyarakat.
                                            </small>
                                        </div>

                                    </div>

                                    <div class="row">

                                        {{-- Selamat Datang --}}
                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Selamat Datang
                                            </label>

                                            <textarea name="selamat_datang" class="form-control" rows="4"
                                                placeholder="Tuliskan ucapan selamat datang kepada masyarakat...">{{ old('selamat_datang', $profilDesa->selamat_datang ?? '') }}</textarea>

                                        </div>


                                        {{-- Nama Kepala Desa --}}
                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Nama Kepala Desa
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="nama_kepdes" class="form-control"
                                                value="{{ old('nama_kepdes', $profilDesa->nama_kepdes ?? '') }}"
                                                placeholder="Masukkan nama kepala desa">

                                        </div>


                                        {{-- Tentang Desa --}}
                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Tentang Desa
                                            </label>

                                            <textarea name="tentang_desa" class="form-control" rows="5"
                                                placeholder="Tuliskan informasi singkat mengenai desa...">{{ old('tentang_desa', $profilDesa->tentang_desa ?? '') }}</textarea>

                                        </div>

                                    </div>

                                </div>


                                <hr style="border-top:1px solid #E2E8F0;">


                                {{-- =================================================
                                SECTION 2 - FOTO & LOGO
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#FFF7ED;
                                            color:#EA580C;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-image"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Foto & Logo Desa
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Upload foto kepala desa dan logo resmi desa.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="row">

                                        {{-- Foto Kepala Desa --}}
                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Foto Kepala Desa
                                            </label>

                                            <div
                                                style="
                                                border:1.5px dashed #CBD5E1;
                                                border-radius:12px;
                                                padding:18px;
                                                background:#F8FAFC;
                                            ">

                                                <div class="text-center mb-3">

                                                    @if (!empty($profilDesa->foto_kepdes))
                                                        <img id="previewFotoKepdes"
                                                            src="{{ asset('storage/' . $profilDesa->foto_kepdes) }}"
                                                            alt="Foto Kepala Desa"
                                                            style="
                                                            width:120px;
                                                            height:120px;
                                                            object-fit:cover;
                                                            border-radius:12px;
                                                            border:3px solid #fff;
                                                            box-shadow:0 3px 12px rgba(0,0,0,.12);
                                                        ">
                                                    @else
                                                        <div id="previewFotoKepdes"
                                                            style="
                                                            width:120px;
                                                            height:120px;
                                                            margin:auto;
                                                            border-radius:12px;
                                                            background:#E2E8F0;
                                                            display:flex;
                                                            align-items:center;
                                                            justify-content:center;
                                                            color:#94A3B8;
                                                            font-size:40px;
                                                        ">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif

                                                </div>


                                                <input type="file" name="foto_kepdes" id="fotoKepdes"
                                                    class="form-control" accept="image/jpeg,image/png,image/jpg">

                                                <small class="text-muted d-block mt-2">
                                                    JPG, JPEG atau PNG. Maksimal 2 MB.
                                                </small>

                                            </div>

                                        </div>


                                        {{-- Logo Desa --}}
                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Logo Desa
                                            </label>

                                            <div
                                                style="
                                                border:1.5px dashed #CBD5E1;
                                                border-radius:12px;
                                                padding:18px;
                                                background:#F8FAFC;
                                            ">

                                                <div class="text-center mb-3">

                                                    @if (!empty($profilDesa->logo_desa))
                                                        <img id="previewLogoDesa"
                                                            src="{{ asset('storage/' . $profilDesa->logo_desa) }}"
                                                            alt="Logo Desa"
                                                            style="
                                                            width:120px;
                                                            height:120px;
                                                            object-fit:contain;
                                                            border-radius:12px;
                                                            border:3px solid #fff;
                                                            background:#fff;
                                                            box-shadow:0 3px 12px rgba(0,0,0,.12);
                                                        ">
                                                    @else
                                                        <div id="previewLogoDesa"
                                                            style="
                                                            width:120px;
                                                            height:120px;
                                                            margin:auto;
                                                            border-radius:12px;
                                                            background:#E2E8F0;
                                                            display:flex;
                                                            align-items:center;
                                                            justify-content:center;
                                                            color:#94A3B8;
                                                            font-size:40px;
                                                        ">
                                                            <i class="fas fa-landmark"></i>
                                                        </div>
                                                    @endif

                                                </div>


                                                <input type="file" name="logo_desa" id="logoDesa" class="form-control"
                                                    accept="image/jpeg,image/png,image/jpg">

                                                <small class="text-muted d-block mt-2">
                                                    JPG, JPEG atau PNG. Maksimal 2 MB.
                                                </small>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <hr style="border-top:1px solid #E2E8F0;">


                                {{-- =================================================
                                SECTION 3 - IDENTITAS DESA
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#EEF2FF;
                                            color:#4F46E5;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Identitas Desa
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Informasi wilayah administratif desa.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Nama Desa <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="nama_desa" class="form-control"
                                                value="{{ old('nama_desa', $profilDesa->nama_desa ?? '') }}"
                                                placeholder="Nama desa">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Kecamatan <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kecamatan" class="form-control"
                                                value="{{ old('kecamatan', $profilDesa->kecamatan ?? '') }}"
                                                placeholder="Nama kecamatan">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Kabupaten <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kabupaten" class="form-control"
                                                value="{{ old('kabupaten', $profilDesa->kabupaten ?? '') }}"
                                                placeholder="Nama kabupaten">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Provinsi <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="provinsi" class="form-control"
                                                value="{{ old('provinsi', $profilDesa->provinsi ?? '') }}"
                                                placeholder="Nama provinsi">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">
                                                Kode Pos <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kode_pos" class="form-control"
                                                value="{{ old('kode_pos', $profilDesa->kode_pos ?? '') }}"
                                                placeholder="Contoh: 90100">
                                        </div>

                                    </div>

                                </div>


                                <hr style="border-top:1px solid #E2E8F0;">


                                {{-- =================================================
                                SECTION 4 - KONTAK
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#ECFDF5;
                                            color:#059669;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-phone"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Kontak Desa
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Nomor dan kontak perangkat yang dapat dihubungi.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Telepon Desa
                                            </label>

                                            <input type="text" name="tlp_desa" class="form-control"
                                                value="{{ old('tlp_desa', $profilDesa->tlp_desa ?? '') }}"
                                                placeholder="Nomor telepon desa">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Email Desa
                                            </label>

                                            <input type="email" name="email_desa" class="form-control"
                                                value="{{ old('email_desa', $profilDesa->email_desa ?? '') }}"
                                                placeholder="email@desa.id">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">
                                                Kontak Sekdes
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kontak_sekdes" class="form-control"
                                                value="{{ old('kontak_sekdes', $profilDesa->kontak_sekdes ?? '') }}"
                                                placeholder="Nomor Sekdes">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">
                                                Kontak Babinsa
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kontak_babinsa" class="form-control"
                                                value="{{ old('kontak_babinsa', $profilDesa->kontak_babinsa ?? '') }}"
                                                placeholder="Nomor Babinsa">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">
                                                Kontak Bhabinkamtibmas
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="kontak_bhabinkamtibmas" class="form-control"
                                                value="{{ old('kontak_bhabinkamtibmas', $profilDesa->kontak_bhabinkamtibmas ?? '') }}"
                                                placeholder="Nomor Bhabinkamtibmas">
                                        </div>

                                    </div>

                                </div>


                                <hr style="border-top:1px solid #E2E8F0;">


                                {{-- =================================================
                                SECTION 5 - INFORMASI DESA
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#FEF3C7;
                                            color:#D97706;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-book-open"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Informasi Desa
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Sejarah, visi, misi dan lokasi kantor desa.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Sejarah Desa
                                            </label>

                                            <textarea name="sejarah_desa" class="form-control" rows="6" placeholder="Tuliskan sejarah desa...">{{ old('sejarah_desa', $profilDesa->sejarah_desa ?? '') }}</textarea>

                                        </div>


                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Visi
                                            </label>

                                            <textarea name="visi" class="form-control" rows="4" placeholder="Tuliskan visi desa...">{{ old('visi', $profilDesa->visi ?? '') }}</textarea>

                                        </div>


                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Misi
                                            </label>

                                            <textarea name="misi" class="form-control" rows="5" placeholder="Tuliskan misi desa...">{{ old('misi', $profilDesa->misi ?? '') }}</textarea>

                                        </div>


                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Alamat Kantor Desa
                                            </label>

                                            <textarea name="alamat_kantor" class="form-control" rows="3" placeholder="Alamat lengkap kantor desa...">{{ old('alamat_kantor', $profilDesa->alamat_kantor ?? '') }}</textarea>

                                        </div>


                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Alamat / Link Peta
                                            </label>

                                            <textarea name="alamat_peta" class="form-control" rows="3"
                                                placeholder="Masukkan alamat atau link Google Maps...">{{ old('alamat_peta', $profilDesa->alamat_peta ?? '') }}</textarea>

                                            <small class="text-muted">
                                                Bisa berupa alamat lokasi atau link Google Maps.
                                            </small>

                                        </div>

                                    </div>

                                </div>


                                <hr style="border-top:1px solid #E2E8F0;">


                                {{-- =================================================
                                SECTION 6 - SOSIAL MEDIA
                            ================================================== --}}
                                <div class="mb-4">

                                    <div class="d-flex align-items-center mb-3" style="gap:10px;">

                                        <div
                                            style="
                                            width:34px;
                                            height:34px;
                                            border-radius:9px;
                                            background:#FCE7F3;
                                            color:#DB2777;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                            <i class="fas fa-share-alt"></i>
                                        </div>

                                        <div>
                                            <h5
                                                style="
                                                margin:0;
                                                font-size:15px;
                                                font-weight:700;
                                                color:#1E293B;
                                            ">
                                                Media Sosial Desa
                                            </h5>

                                            <small style="color:#94A3B8;">
                                                Tambahkan akun media sosial resmi desa.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Instagram
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    <i class="fab fa-instagram"></i>
                                                </span>

                                                <input type="text" name="sosmed_ig" class="form-control"
                                                    value="{{ old('sosmed_ig', $profilDesa->sosmed_ig ?? '') }}"
                                                    placeholder="https://instagram.com/...">

                                            </div>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Facebook
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    <i class="fab fa-facebook"></i>
                                                </span>

                                                <input type="text" name="sosmed_fb" class="form-control"
                                                    value="{{ old('sosmed_fb', $profilDesa->sosmed_fb ?? '') }}"
                                                    placeholder="https://facebook.com/...">

                                            </div>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                YouTube
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    <i class="fab fa-youtube"></i>
                                                </span>

                                                <input type="text" name="sosmed_yt" class="form-control"
                                                    value="{{ old('sosmed_yt', $profilDesa->sosmed_yt ?? '') }}"
                                                    placeholder="https://youtube.com/...">

                                            </div>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                TikTok
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    <i class="fab fa-tiktok"></i>
                                                </span>

                                                <input type="text" name="sosmed_tiktok" class="form-control"
                                                    value="{{ old('sosmed_tiktok', $profilDesa->sosmed_tiktok ?? '') }}"
                                                    placeholder="https://tiktok.com/@...">

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- =================================================
                                BUTTON SIMPAN
                            ================================================== --}}
                                <div
                                    style="
                                    margin-top:30px;
                                    padding-top:22px;
                                    border-top:1px solid #E2E8F0;
                                    display:flex;
                                    justify-content:flex-end;
                                    align-items:center;
                                    gap:10px;
                                ">

                                    <button type="submit" id="btnSimpanProfil"
                                        style="
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        gap:8px;
                                        padding:11px 24px;
                                        background:#2E7D32;
                                        color:#fff;
                                        border:none;
                                        border-radius:10px;
                                        font-size:14px;
                                        font-weight:600;
                                        cursor:pointer;
                                        box-shadow:0 3px 8px rgba(46,125,50,.20);
                                        transition:all .2s;
                                    "
                                        onmouseover="this.style.background='#256B2A'"
                                        onmouseout="this.style.background='#2E7D32'">

                                        <i class="fas fa-save"></i>

                                        <span>Simpan Perubahan</span>

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>
    </div>


    {{-- =========================================================
    PREVIEW FOTO
========================================================= --}}
    <script>
        document.getElementById('fotoKepdes')?.addEventListener('change', function(event) {

            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {

                const preview = document.getElementById('previewFotoKepdes');

                if (preview.tagName === 'IMG') {

                    preview.src = e.target.result;

                } else {

                    preview.outerHTML = `
                    <img
                        id="previewFotoKepdes"
                        src="${e.target.result}"
                        alt="Preview Foto Kepala Desa"
                        style="
                            width:120px;
                            height:120px;
                            object-fit:cover;
                            border-radius:12px;
                            border:3px solid #fff;
                            box-shadow:0 3px 12px rgba(0,0,0,.12);
                        "
                    >
                `;
                }
            };

            reader.readAsDataURL(file);
        });


        document.getElementById('logoDesa')?.addEventListener('change', function(event) {

            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {

                const preview = document.getElementById('previewLogoDesa');

                if (preview.tagName === 'IMG') {

                    preview.src = e.target.result;

                } else {

                    preview.outerHTML = `
                    <img
                        id="previewLogoDesa"
                        src="${e.target.result}"
                        alt="Preview Logo Desa"
                        style="
                            width:120px;
                            height:120px;
                            object-fit:contain;
                            border-radius:12px;
                            border:3px solid #fff;
                            background:#fff;
                            box-shadow:0 3px 12px rgba(0,0,0,.12);
                        "
                    />
                `;
                }
            };

            reader.readAsDataURL(file);
        });
    </script>

    <script>
        // =========================================================
        // AJAX EDIT PROFIL DESA
        // Tanpa Modal
        // =========================================================

        $(document).on("click", ".btn-edit-profil-desa", function(e) {
            e.preventDefault();

            let id = $(this).data("id");

            if (!id) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "ID profil desa tidak ditemukan."
                });

                return;
            }

            // Loading
            Swal.fire({
                title: "Memuat data...",
                text: "Mohon tunggu",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/admin/profil-desa/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    Swal.close();

                    if (response.success) {

                        let data = response.data;

                        // =================================================
                        // SET ACTION FORM
                        // =================================================

                        $("#formProfilDesa").attr(
                            "action",
                            `/admin/profil-desa/${id}`
                        );

                        // =================================================
                        // SET ID PROFIL DESA
                        // =================================================

                        $("#profil_desa_id").val(data.id);

                        // =================================================
                        // PROFIL UTAMA
                        // =================================================

                        $("textarea[name='selamat_datang']")
                            .val(data.selamat_datang ?? "");

                        $("input[name='nama_kepdes']")
                            .val(data.nama_kepdes ?? "");

                        $("textarea[name='tentang_desa']")
                            .val(data.tentang_desa ?? "");


                        // =================================================
                        // IDENTITAS DESA
                        // =================================================

                        $("input[name='nama_desa']")
                            .val(data.nama_desa ?? "");

                        $("input[name='kecamatan']")
                            .val(data.kecamatan ?? "");

                        $("input[name='kabupaten']")
                            .val(data.kabupaten ?? "");

                        $("input[name='provinsi']")
                            .val(data.provinsi ?? "");

                        $("input[name='kode_pos']")
                            .val(data.kode_pos ?? "");


                        // =================================================
                        // KONTAK DESA
                        // =================================================

                        $("input[name='tlp_desa']")
                            .val(data.tlp_desa ?? "");

                        $("input[name='email_desa']")
                            .val(data.email_desa ?? "");

                        $("input[name='kontak_sekdes']")
                            .val(data.kontak_sekdes ?? "");

                        $("input[name='kontak_babinsa']")
                            .val(data.kontak_babinsa ?? "");

                        $("input[name='kontak_bhabinkamtibmas']")
                            .val(data.kontak_bhabinkamtibmas ?? "");


                        // =================================================
                        // INFORMASI DESA
                        // =================================================

                        $("textarea[name='sejarah_desa']")
                            .val(data.sejarah_desa ?? "");

                        $("textarea[name='visi']")
                            .val(data.visi ?? "");

                        $("textarea[name='misi']")
                            .val(data.misi ?? "");

                        $("textarea[name='alamat_kantor']")
                            .val(data.alamat_kantor ?? "");

                        $("textarea[name='alamat_peta']")
                            .val(data.alamat_peta ?? "");


                        // =================================================
                        // SOSIAL MEDIA
                        // =================================================

                        $("input[name='sosmed_ig']")
                            .val(data.sosmed_ig ?? "");

                        $("input[name='sosmed_fb']")
                            .val(data.sosmed_fb ?? "");

                        $("input[name='sosmed_yt']")
                            .val(data.sosmed_yt ?? "");

                        $("input[name='sosmed_tiktok']")
                            .val(data.sosmed_tiktok ?? "");


                        // =================================================
                        // PREVIEW FOTO KEPALA DESA
                        // =================================================

                        if (data.foto_kepdes_url) {

                            $("#previewFotoKepdes")
                                .replaceWith(`
                                <img
                                    id="previewFotoKepdes"
                                    src="${data.foto_kepdes_url}"
                                    alt="Foto Kepala Desa"
                                    style="
                                        width:120px;
                                        height:120px;
                                        object-fit:cover;
                                        border-radius:12px;
                                        border:3px solid #fff;
                                        box-shadow:0 3px 12px rgba(0,0,0,.12);
                                    "
                                >
                            `);

                        } else {

                            $("#previewFotoKepdes").replaceWith(`
                            <div
                                id="previewFotoKepdes"
                                style="
                                    width:120px;
                                    height:120px;
                                    margin:auto;
                                    border-radius:12px;
                                    background:#E2E8F0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#94A3B8;
                                    font-size:40px;
                                "
                            >
                                <i class="fas fa-user"></i>
                            </div>
                        `);

                        }


                        // =================================================
                        // PREVIEW LOGO DESA
                        // =================================================

                        if (data.logo_desa_url) {

                            $("#previewLogoDesa")
                                .replaceWith(`
                                <img
                                    id="previewLogoDesa"
                                    src="${data.logo_desa_url}"
                                    alt="Logo Desa"
                                    style="
                                        width:120px;
                                        height:120px;
                                        object-fit:contain;
                                        border-radius:12px;
                                        border:3px solid #fff;
                                        background:#fff;
                                        box-shadow:0 3px 12px rgba(0,0,0,.12);
                                    "
                                >
                            `);

                        } else {

                            $("#previewLogoDesa").replaceWith(`
                            <div
                                id="previewLogoDesa"
                                style="
                                    width:120px;
                                    height:120px;
                                    margin:auto;
                                    border-radius:12px;
                                    background:#E2E8F0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#94A3B8;
                                    font-size:40px;
                                "
                            >
                                <i class="fas fa-landmark"></i>
                            </div>
                        `);

                        }


                        // =================================================
                        // KOSONGKAN INPUT FILE
                        // Browser tidak mengizinkan value file diisi AJAX
                        // =================================================

                        $("#fotoKepdes").val("");
                        $("#logoDesa").val("");


                        // =================================================
                        // SCROLL KE FORM
                        // =================================================

                        $("html, body").animate({
                            scrollTop: $("#formProfilDesa").offset().top - 80
                        }, 500);


                        // =================================================
                        // NOTIFIKASI
                        // =================================================

                        Swal.fire({
                            icon: "success",
                            title: "Data dimuat",
                            text: "Data profil desa siap diedit.",
                            timer: 1500,
                            showConfirmButton: false
                        });

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message ||
                                "Data profil desa tidak ditemukan."
                        });

                    }
                },

                error: function(xhr) {

                    Swal.close();

                    console.error(
                        "Error:",
                        xhr.responseText
                    );

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data profil desa dari server."
                    });

                }
            });
        });


        // =========================================================
        // AJAX SUBMIT UPDATE PROFIL DESA
        // =========================================================

        $("#formProfilDesa").submit(function(e) {

            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            let id = $("#profil_desa_id").val();

            if (!id) {

                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "ID profil desa tidak ditemukan."
                });

                return;
            }


            // =================================================
            // LOADING
            // =================================================

            Swal.fire({
                title: "Menyimpan perubahan...",
                text: "Mohon tunggu",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            $.ajax({

                url: `/admin/profil-desa/${id}`,

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                headers: {
                    "X-HTTP-Method-Override": "PUT"
                },


                // =================================================
                // SUCCESS
                // =================================================

                success: function(response) {

                    Swal.close();

                    if (response.success) {

                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message ||
                                "Profil desa berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire({
                            title: "Gagal!",
                            text: response.message ||
                                "Data gagal diperbarui.",
                            icon: "error"
                        });

                    }
                },


                // =================================================
                // ERROR
                // =================================================

                error: function(xhr) {

                    Swal.close();

                    console.error(
                        "Update error:",
                        xhr.responseText
                    );


                    // ---------------------------------------------
                    // VALIDATION ERROR 422
                    // ---------------------------------------------

                    if (xhr.status === 422 && xhr.responseJSON) {

                        let errors = xhr.responseJSON.errors;

                        let errorMessages = "";

                        $.each(errors, function(key, value) {

                            if (Array.isArray(value)) {

                                errorMessages +=
                                    `<li>${value[0]}</li>`;

                            } else {

                                errorMessages +=
                                    `<li>${value}</li>`;

                            }

                        });


                        Swal.fire({
                            title: "Validasi Gagal!",
                            html: `
                            <ul style="
                                text-align:left;
                                padding-left:20px;
                            ">
                                ${errorMessages}
                            </ul>
                        `,
                            icon: "warning"
                        });

                    } else {

                        // -----------------------------------------
                        // ERROR LAIN
                        // -----------------------------------------

                        Swal.fire({
                            title: "Terjadi Kesalahan!",
                            text: "Terjadi kesalahan saat memperbarui profil desa.",
                            icon: "error"
                        });

                    }

                }

            });

        });
    </script>
@endsection
