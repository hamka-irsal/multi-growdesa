@extends('layouts.app')

@section('page-title', 'Data-Aparat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">

                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-building" style="color:#2E7D32;"></i>
                    Daftar Desa
                </h1>

                <div class="section-header-breadcrumb" style="font-size:13px;">

                    <div class="breadcrumb-item active">
                        <a href="{{ route('superadmin.dashboard.index') }}">
                            Dashboard
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        <a href="{{ route('superadmin.desa.index') }}">
                            Daftar Desa
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        Desa
                    </div>

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

                                List Data Desa

                            </h4>


                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">

                                {{-- Search --}}
                                <div style="position:relative;">

                                    <i class="fas fa-search"
                                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; font-size:13px;">
                                    </i>

                                    <input type="text" id="searchInput" autocomplete="off" placeholder="Cari desa..."
                                        style="padding:9px 14px 9px 34px; border:1.5px solid #E2E8F0; border-radius:10px; font-size:14px; color:#1E293B; background:#F8FAFC; width:220px; outline:none; transition:border .2s;"
                                        onfocus="this.style.borderColor='#6777ef';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#E2E8F0';this.style.background='#F8FAFC'">

                                </div>


                                {{-- Tambah Desa --}}
                                <button type="button" data-toggle="modal" data-target="#modalTambahDesa"
                                    style="display:flex; align-items:center; gap:7px; padding:9px 18px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; transition:background .2s; white-space:nowrap;"
                                    onmouseover="this.style.background='#256628'"
                                    onmouseout="this.style.background='#2E7D32'">

                                    <i class="fas fa-plus"></i>
                                    Tambah Desa

                                </button>

                            </div>

                        </div>


                        {{-- Table --}}
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table mb-0" id="desaTable" style="border-collapse:collapse; width:100%;">

                                    <thead>

                                        <tr style="background:#F8FAFC;">

                                            {{-- No --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No
                                            </th>


                                            {{-- Nama Desa --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Desa
                                            </th>


                                            {{-- Domain --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Domain
                                            </th>


                                            {{-- Kecamatan --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Kecamatan
                                            </th>


                                            {{-- Kabupaten --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Kabupaten
                                            </th>


                                            {{-- Provinsi --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Provinsi
                                            </th>


                                            {{-- Status --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Status
                                            </th>


                                            {{-- Aksi --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @forelse ($desa as $index => $data)
                                            @php
                                                $rowBg = $loop->even ? '#F8FAFC' : '#fff';
                                            @endphp

                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">


                                                {{-- No --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">

                                                    {{ $desa->firstItem() + $index }}

                                                </td>


                                                {{-- Nama Desa --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">

                                                    <div style="display:flex; align-items:center; gap:8px;">

                                                        <div
                                                            style="width:32px; height:32px; border-radius:8px; background:#E8F5E9; color:#2E7D32; display:flex; align-items:center; justify-content:center;">

                                                            <i class="fas fa-building"></i>

                                                        </div>

                                                        <span>
                                                            {{ $data->nama_desa }}
                                                        </span>

                                                    </div>

                                                </td>


                                                {{-- Domain --}}
                                                <td style="padding:14px 18px; font-size:14px; border:1.5px solid #CBD5E1;">

                                                    <a href="https://{{ $data->domain }}" target="_blank"
                                                        style="color:#2E7D32; font-weight:600; text-decoration:none;">

                                                        <i class="fas fa-globe" style="margin-right:5px;"></i>

                                                        {{ $data->domain }}

                                                    </a>

                                                </td>


                                                {{-- Kecamatan --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; color:#334155; border:1.5px solid #CBD5E1;">

                                                    {{ $data->kecamatan }}

                                                </td>


                                                {{-- Kabupaten --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; color:#334155; border:1.5px solid #CBD5E1;">

                                                    {{ $data->kabupaten }}

                                                </td>


                                                {{-- Provinsi --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; color:#334155; border:1.5px solid #CBD5E1;">

                                                    {{ $data->provinsi }}

                                                </td>


                                                {{-- Status --}}
                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">

                                                    @if ($data->status)
                                                        <span
                                                            style="display:inline-flex; align-items:center; gap:5px; padding:5px 10px; border-radius:20px; background:#E8F5E9; color:#2E7D32; font-size:12px; font-weight:600;">

                                                            <i class="fas fa-check-circle"></i>
                                                            Aktif

                                                        </span>
                                                    @else
                                                        <span
                                                            style="display:inline-flex; align-items:center; gap:5px; padding:5px 10px; border-radius:20px; background:#FEE2E2; color:#B91C1C; font-size:12px; font-weight:600;">

                                                            <i class="fas fa-times-circle"></i>
                                                            Nonaktif

                                                        </span>
                                                    @endif

                                                </td>


                                                {{-- Aksi --}}
                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">

                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">


                                                        {{-- Edit --}}
                                                        <button type="button" class="btn-edit"
                                                            data-id="{{ $data->id }}" title="Edit"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">

                                                            <i class="fas fa-edit"></i>

                                                        </button>


                                                        {{-- Hapus --}}
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

                                                <td colspan="8"
                                                    style="padding:35px; text-align:center; color:#64748B; border:1.5px solid #CBD5E1;">

                                                    <i class="fas fa-building"
                                                        style="font-size:30px; margin-bottom:10px; color:#94A3B8;">
                                                    </i>

                                                    <div style="font-size:14px;">
                                                        Belum ada data desa.
                                                    </div>

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

                                    {{-- Pagination AJAX akan dimuat di sini --}}

                                </ul>

                            </nav>

                        </div>

                    </div>

                </div>
            </div>

        </section>
    </div>


    {{-- Modal Tambah Desa --}}
    <div class="modal fade" id="modalTambahDesa" tabindex="-1" role="dialog" aria-labelledby="modalTambahDesaLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">

                    <h5 class="modal-title" id="modalTambahDesaLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">

                        <i class="fas fa-building"></i>
                        Tambah Desa

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>


                {{-- Form --}}
                <form action="{{ route('superadmin.desa.store') }}" method="POST" id="formTambahDesa">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC;">


                        {{-- =====================================================
                    DATA DESA
                    ====================================================== --}}

                        <div style="margin-bottom:24px;">

                            <div
                                style="display:flex; align-items:center; gap:10px; margin-bottom:20px; padding-bottom:12px; border-bottom:1.5px solid #E2E8F0;">

                                <div
                                    style="width:36px; height:36px; border-radius:9px; background:#E8F5E9; color:#2E7D32; display:flex; align-items:center; justify-content:center;">

                                    <i class="fas fa-building"></i>

                                </div>

                                <div>

                                    <div style="font-size:16px; font-weight:700; color:#1E293B;">
                                        Data Desa
                                    </div>

                                    <div style="font-size:13px; color:#64748B; margin-top:2px;">
                                        Informasi dasar desa
                                    </div>

                                </div>

                            </div>


                            <div class="row">

                                {{-- Nama Desa --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="nama_desa"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-building" style="color:#2E7D32;"></i>

                                            Nama Desa

                                        </label>

                                        <input type="text" name="nama_desa" id="nama_desa"
                                            placeholder="Masukkan Nama Desa" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>


                                {{-- Domain --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="domain"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-globe" style="color:#2E7D32;"></i>

                                            Domain Desa

                                        </label>

                                        <input type="text" name="domain" id="domain"
                                            placeholder="galesongtimur.growdesa.id" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                        <small style="display:block; margin-top:8px; font-size:13px; color:#64748B;">

                                            Contoh: galesongtimur.growdesa.id

                                        </small>

                                    </div>

                                </div>


                                {{-- Kecamatan --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="kecamatan"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-map-marker-alt" style="color:#2E7D32;"></i>

                                            Kecamatan

                                        </label>

                                        <input type="text" name="kecamatan" id="kecamatan"
                                            placeholder="Masukkan Kecamatan" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>


                                {{-- Kabupaten --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="kabupaten"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-map" style="color:#2E7D32;"></i>

                                            Kabupaten

                                        </label>

                                        <input type="text" name="kabupaten" id="kabupaten"
                                            placeholder="Masukkan Kabupaten" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>


                                {{-- Provinsi --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="provinsi"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-map-marked-alt" style="color:#2E7D32;"></i>

                                            Provinsi

                                        </label>

                                        <input type="text" name="provinsi" id="provinsi"
                                            placeholder="Masukkan Provinsi" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>


                                {{-- Kode Desa --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="kode_desa"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-barcode" style="color:#2E7D32;"></i>

                                            Kode Desa

                                        </label>

                                        <input type="text" name="kode_desa" id="kode_desa"
                                            placeholder="Masukkan Kode Desa"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                        <small style="display:block; margin-top:8px; font-size:13px; color:#64748B;">

                                            Opsional

                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                    AKUN ADMIN DESA
                    ====================================================== --}}

                        <div>

                            <div
                                style="display:flex; align-items:center; gap:10px; margin-bottom:20px; padding-bottom:12px; border-bottom:1.5px solid #E2E8F0;">

                                <div
                                    style="width:36px; height:36px; border-radius:9px; background:#E8F5E9; color:#2E7D32; display:flex; align-items:center; justify-content:center;">

                                    <i class="fas fa-user-shield"></i>

                                </div>

                                <div>

                                    <div style="font-size:16px; font-weight:700; color:#1E293B;">
                                        Akun Admin Desa
                                    </div>

                                    <div style="font-size:13px; color:#64748B; margin-top:2px;">
                                        Akun untuk mengakses dashboard desa
                                    </div>

                                </div>

                            </div>


                            <div class="row">

                                {{-- Nama Admin --}}
                                <div class="col-md-4">

                                    <div class="form-group" style="margin-bottom:10px;">

                                        <label for="admin_name"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-user" style="color:#2E7D32;"></i>

                                            Nama Admin

                                        </label>

                                        <input type="text" name="admin_name" id="admin_name" placeholder="Nama Admin"
                                            required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>


                                {{-- Email --}}
                                <div class="col-md-4">

                                    <div class="form-group" style="margin-bottom:10px;">

                                        <label for="admin_email"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-envelope" style="color:#2E7D32;"></i>

                                            Email

                                        </label>

                                        <input type="email" name="admin_email" id="admin_email"
                                            placeholder="admin@desa.id" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#2E7D32'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Password --}}
                                <div class="col-md-4">

                                    <div class="form-group" style="margin-bottom:10px;">

                                        <label for="admin_password"
                                            style="
                font-size:15px;
                font-weight:600;
                color:#334155;
                display:flex;
                align-items:center;
                gap:8px;
                margin-bottom:10px;
            ">

                                            <i class="fas fa-lock" style="color:#2E7D32;"></i>

                                            Password

                                        </label>

                                        <div style="position:relative;">

                                            <input type="password" name="admin_password" id="admin_password"
                                                placeholder="Minimal 8 karakter" required minlength="8"
                                                style="
                    width:100%;
                    padding:12px 45px 12px 14px;
                    font-size:15px;
                    color:#1E293B;
                    height:48px;
                    border:1.5px solid #E2E8F0;
                    border-radius:10px;
                    background:#fff;
                    outline:none;
                    transition:border-color .15s;
                "
                                                onfocus="this.style.borderColor='#2E7D32'"
                                                onblur="this.style.borderColor='#E2E8F0'">

                                            <button type="button" id="toggleAdminPassword"
                                                onclick="toggleAdminPasswordVisibility()"
                                                style="
                    position:absolute;
                    top:50%;
                    right:14px;
                    transform:translateY(-50%);
                    border:none;
                    background:transparent;
                    padding:0;
                    margin:0;
                    cursor:pointer;
                    color:#64748B;
                    font-size:16px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                "
                                                title="Lihat password">

                                                <i class="fas fa-eye" id="adminPasswordIcon"></i>

                                            </button>

                                        </div>

                                    </div>

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

                            <i class="fas fa-times"></i>
                            Batal

                        </button>


                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer;"
                            onmouseover="this.style.background='#256528'" onmouseout="this.style.background='#2E7D32'">

                            <i class="fas fa-save"></i>
                            Simpan Desa

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    {{-- Modal Edit Desa --}}
    <div class="modal fade" id="modalEditDesa" tabindex="-1" role="dialog" aria-labelledby="modalEditDesaLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">

                    <h5 class="modal-title" id="modalEditDesaLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">

                        <i class="fas fa-edit"></i> Edit Desa

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <form method="POST" id="formEditDesa">

                    @csrf

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_desa_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB;">

                        {{-- ========================= --}}
                        {{-- DATA DESA --}}
                        {{-- ========================= --}}

                        <div style="margin-bottom:22px;">

                            <h6
                                style="font-size:16px; font-weight:700; color:#92400E; margin-bottom:18px; display:flex; align-items:center; gap:8px;">

                                <i class="fas fa-building"></i>

                                Data Desa

                            </h6>

                            <div class="row">

                                {{-- Nama Desa --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_nama_desa"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-home" style="color:#F59E0B;"></i>

                                            Nama Desa

                                        </label>

                                        <input type="text" name="nama_desa" id="edit_nama_desa" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Domain --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_domain"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-globe" style="color:#F59E0B;"></i>

                                            Domain

                                        </label>

                                        <input type="text" name="domain" id="edit_domain" required maxlength="255"
                                            placeholder="contoh: galesongtimur.growdesa.id"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Kecamatan --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_kecamatan"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-map-marker-alt" style="color:#F59E0B;"></i>

                                            Kecamatan

                                        </label>

                                        <input type="text" name="kecamatan" id="edit_kecamatan" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Kabupaten --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_kabupaten"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-city" style="color:#F59E0B;"></i>

                                            Kabupaten

                                        </label>

                                        <input type="text" name="kabupaten" id="edit_kabupaten" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Provinsi --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_provinsi"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-map" style="color:#F59E0B;"></i>

                                            Provinsi

                                        </label>

                                        <input type="text" name="provinsi" id="edit_provinsi" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Kode Desa --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_kode_desa"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-barcode" style="color:#F59E0B;"></i>

                                            Kode Desa
                                            <span style="font-weight:400; color:#94A3B8;">
                                                (Opsional)
                                            </span>

                                        </label>

                                        <input type="text" name="kode_desa" id="edit_kode_desa" maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Status --}}
                                <div class="col-md-12">

                                    <div class="form-group" style="margin-bottom:6px;">

                                        <label for="edit_status"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-toggle-on" style="color:#F59E0B;"></i>

                                            Status Desa

                                        </label>

                                        <select name="status" id="edit_status" required
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none;">

                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ========================= --}}
                        {{-- AKUN ADMIN DESA --}}
                        {{-- ========================= --}}

                        <div style="border-top:1.5px solid #FDE68A; padding-top:24px;">

                            <h6
                                style="font-size:16px; font-weight:700; color:#92400E; margin-bottom:18px; display:flex; align-items:center; gap:8px;">

                                <i class="fas fa-user-shield"></i>

                                Akun Admin Desa

                            </h6>

                            <div class="row">

                                {{-- Nama Admin --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_admin_name"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-user" style="color:#F59E0B;"></i>

                                            Nama Admin Desa

                                        </label>

                                        <input type="text" name="admin_name" id="edit_admin_name" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Email Admin --}}
                                <div class="col-md-6">

                                    <div class="form-group" style="margin-bottom:20px;">

                                        <label for="edit_admin_email"
                                            style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                            <i class="fas fa-envelope" style="color:#F59E0B;"></i>

                                            Email Admin Desa

                                        </label>

                                        <input type="email" name="admin_email" id="edit_admin_email" required
                                            maxlength="255"
                                            style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                            onfocus="this.style.borderColor='#F59E0B'"
                                            onblur="this.style.borderColor='#E2E8F0'">

                                    </div>

                                </div>

                                {{-- Password Baru --}}
                                <div class="col-md-12">

                                    <div class="form-group" style="margin-bottom:6px;">

                                        <label for="edit_admin_password"
                                            style="
                font-size:15px;
                font-weight:600;
                color:#334155;
                display:flex;
                align-items:center;
                gap:8px;
                margin-bottom:10px;
            ">

                                            <i class="fas fa-lock" style="color:#F59E0B;"></i>

                                            Password Baru

                                            <span style="font-weight:400; color:#94A3B8;">
                                                (Opsional)
                                            </span>

                                        </label>

                                        <div style="position:relative;">

                                            <input type="password" name="admin_password" id="edit_admin_password"
                                                minlength="8" placeholder="Kosongkan jika tidak ingin mengubah password"
                                                style="
                    width:100%;
                    padding:12px 45px 12px 14px;
                    font-size:15px;
                    color:#1E293B;
                    height:48px;
                    border:1.5px solid #E2E8F0;
                    border-radius:10px;
                    background:#fff;
                    outline:none;
                    transition:border-color .15s;
                "
                                                onfocus="this.style.borderColor='#F59E0B'"
                                                onblur="this.style.borderColor='#E2E8F0'">

                                            <button type="button" id="toggleEditAdminPassword"
                                                onclick="toggleEditAdminPasswordVisibility()"
                                                style="
                    position:absolute;
                    top:50%;
                    right:14px;
                    transform:translateY(-50%);
                    border:none;
                    background:transparent;
                    padding:0;
                    margin:0;
                    cursor:pointer;
                    color:#64748B;
                    font-size:16px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                "
                                                title="Lihat password">

                                                <i class="fas fa-eye" id="editAdminPasswordIcon"></i>

                                            </button>

                                        </div>

                                        <small
                                            style="
            display:block;
            margin-top:8px;
            font-size:13.5px;
            color:#64748B;
        ">
                                            Kosongkan jika password admin tidak ingin diubah.
                                            Minimal 8 karakter jika ingin menggantinya.
                                        </small>

                                    </div>

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

        <script>
            // =====================================================
            // TOGGLE PASSWORD TAMBAH DESA
            // =====================================================
            function toggleAdminPasswordVisibility() {

                const passwordInput =
                    document.getElementById('admin_password');

                const passwordIcon =
                    document.getElementById('adminPasswordIcon');

                const toggleButton =
                    document.getElementById('toggleAdminPassword');

                if (passwordInput.type === 'password') {

                    passwordInput.type = 'text';

                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');

                    toggleButton.title = 'Sembunyikan password';

                } else {

                    passwordInput.type = 'password';

                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');

                    toggleButton.title = 'Lihat password';
                }
            }


            // =====================================================
            // TOGGLE PASSWORD BARU - EDIT DESA
            // =====================================================
            function toggleEditAdminPasswordVisibility() {

                const passwordInput =
                    document.getElementById('edit_admin_password');

                const passwordIcon =
                    document.getElementById('editAdminPasswordIcon');

                const toggleButton =
                    document.getElementById('toggleEditAdminPassword');

                if (passwordInput.type === 'password') {

                    passwordInput.type = 'text';

                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');

                    toggleButton.title = 'Sembunyikan password';

                } else {

                    passwordInput.type = 'password';

                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');

                    toggleButton.title = 'Lihat password';
                }
            }
        </script>

        <script>
            // =====================================================
            // AJAX MODAL TAMBAH DESA
            // =====================================================
            $(document).ready(function() {

                $("#formTambahDesa").submit(function(e) {
                    e.preventDefault(); // Mencegah reload halaman

                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('superadmin.desa.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,

                        beforeSend: function() {

                            Swal.fire({
                                title: 'Mohon Tunggu...',
                                text: 'Sedang memproses data desa',
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
                                        'Data desa dan akun admin berhasil ditambahkan.',
                                    timer: 2000,
                                    showConfirmButton: false

                                }).then(() => {

                                    location.reload();

                                });

                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message ||
                                        'Terjadi kesalahan saat menambahkan data desa.'
                                });

                            }

                        },

                        error: function(xhr) {

                            let errorMessage =
                                'Terjadi kesalahan saat mengirim data.';

                            if (xhr.responseJSON && xhr.responseJSON.errors) {

                                let errors = xhr.responseJSON.errors;
                                let errorMessages = "";

                                $.each(errors, function(key, value) {

                                    errorMessages +=
                                        ` < li > $ {
            value[0]
            } < /li>`;

                                });

                                errorMessage =
                                    `<ul style="text-align: left; margin-bottom: 0;">
                                    ${errorMessages}
                                </ul>`;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                html: errorMessage
                            });

                        }
                    });

                });


                // =====================================================
                // VALIDASI INPUT FORM TAMBAH DESA
                // =====================================================
                $("#formTambahDesa").on("submit", function(event) {

                    let isValid = true;

                    // Reset pesan error
                    $(".text-danger").text("");

                    // Periksa input required
                    $(this).find("input, select").each(function() {

                        if ($(this).prop("required") &&
                            $(this).val().trim() === "") {

                            isValid = false;

                            $(this)
                                .next(".text-danger")
                                .text("Kolom ini wajib diisi.");

                        }

                    });

                    if (!isValid) {
                        event.preventDefault();
                    }

                });

            });


            // =====================================================
            // AJAX HAPUS DATA DESA
            // =====================================================
            $(document).on("click", ".btn-hapus", function() {

                let id = $(this).data("id");

                let url = `/superadmin/desa/${id}`;

                Swal.fire({

                    title: "Apakah Anda yakin?",

                    text: "Data desa dan akun admin desa akan dihapus dan tidak bisa dikembalikan!",

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

                            beforeSend: function() {

                                Swal.fire({

                                    title: "Menghapus...",

                                    text: "Sedang menghapus data desa",

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

                                        title: "Berhasil!",

                                        text: response.message ||
                                            "Data desa berhasil dihapus.",

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
                                            "Data desa gagal dihapus.",

                                        icon: "error"

                                    });

                                }

                            },

                            error: function(xhr) {

                                let message =
                                    "Terjadi kesalahan saat menghapus data desa.";

                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    message =
                                        xhr.responseJSON.message;

                                }

                                Swal.fire({

                                    title: "Gagal!",

                                    text: message,

                                    icon: "error"

                                });

                            }

                        });

                    }

                });

            });


            // =====================================================
            // AJAX EDIT DESA
            // =====================================================
            $(document).on("click", ".btn-edit", function() {

                let id = $(this).data("id");

                console.log("Edit Desa ID:", id);
                console.log("URL:", `/superadmin/desa/${id}/edit`);

                $.ajax({
                    url: `/superadmin/desa/${id}/edit`,
                    type: "GET",
                    dataType: "json",

                    beforeSend: function() {

                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang memuat data desa",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                    },

                    success: function(response) {

                        console.log("SUCCESS:", response);

                        Swal.close();

                        if (response.success) {

                            let data = response.data;

                            // Isi form
                            $("#formEditDesa").attr(
                                "action",
                                `/superadmin/desa/${id}`
                            );

                            $("#edit_desa_id").val(data.id);

                            $("#edit_nama_desa").val(data.nama_desa);
                            $("#edit_domain").val(data.domain);
                            $("#edit_kecamatan").val(data.kecamatan);
                            $("#edit_kabupaten").val(data.kabupaten);
                            $("#edit_provinsi").val(data.provinsi);
                            $("#edit_kode_desa").val(data.kode_desa);

                            $("#edit_status").val(
                                data.status ? "1" : "0"
                            );

                            $("#edit_admin_name").val(
                                data.admin_name
                            );

                            $("#edit_admin_email").val(
                                data.admin_email
                            );

                            // Password selalu dikosongkan
                            $("#edit_admin_password").val("");

                            // Tampilkan modal
                            $("#modalEditDesa").modal("show");

                        } else {

                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: response.message ||
                                    "Data desa tidak ditemukan."
                            });

                        }
                    },

                    error: function(xhr, status, error) {

                        Swal.close();

                        console.error("===== ERROR EDIT DESA =====");
                        console.error("Status HTTP:", xhr.status);
                        console.error("Status Text:", status);
                        console.error("Error:", error);
                        console.error("Response:", xhr.responseText);
                        console.error("Response JSON:", xhr.responseJSON);

                        let message = "Gagal memuat data desa.";

                        if (xhr.status === 403) {

                            message =
                                "403 - Anda tidak memiliki izin untuk mengakses data desa.";

                        } else if (xhr.status === 404) {

                            message =
                                "404 - Route atau data desa tidak ditemukan.";

                        } else if (xhr.status === 419) {

                            message =
                                "419 - Session atau CSRF token tidak valid.";

                        } else if (xhr.status === 500) {

                            message =
                                "500 - Terjadi kesalahan pada server Laravel.";

                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: message,
                            footer: `
                    <small>
                        HTTP Status: ${xhr.status}
                    </small>
                `
                        });
                    }
                });
            });

            // =====================================================
            // AJAX SUBMIT EDIT DESA
            // =====================================================
            $("#formEditDesa").submit(function(e) {

                e.preventDefault();

                let form = this;

                let formData = new FormData(form);

                let id = $("#edit_desa_id").val();

                $.ajax({

                    url: `/superadmin/desa/${id}`,

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    headers: {
                        "X-HTTP-Method-Override": "PUT"
                    },

                    beforeSend: function() {

                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang memperbarui data desa",
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

                                title: "Berhasil!",

                                text: response.message ||
                                    "Data desa berhasil diperbarui.",

                                icon: "success",

                                timer: 2000,

                                showConfirmButton: false

                            }).then(() => {

                                // Tutup modal
                                $("#modalEditDesa").modal("hide");

                                // Reset form
                                $("#formEditDesa")[0].reset();

                                // Reload data
                                location.reload();

                            });

                        } else {

                            Swal.fire({

                                title: "Gagal!",

                                text: response.message ||
                                    "Data desa gagal diperbarui.",

                                icon: "error"

                            });

                        }

                    },

                    error: function(xhr) {

                        let errors =
                            xhr.responseJSON?.errors;

                        let errorMessages = "";

                        if (errors) {

                            $.each(errors, function(key, value) {

                                errorMessages +=
                                    `<li>${value[0]}</li>`;

                            });

                        } else if (
                            xhr.responseJSON?.message
                        ) {

                            errorMessages =
                                `<li>${xhr.responseJSON.message}</li>`;

                        } else {

                            errorMessages =
                                "<li>Terjadi kesalahan saat memperbarui data desa.</li>";

                        }

                        Swal.fire({

                            title: "Terjadi Kesalahan!",

                            html: `
                    <ul style="text-align:left; margin-bottom:0;">
                        ${errorMessages}
                    </ul>
                `,

                            icon: "error"

                        });

                    }

                });

            });


            // =====================================================
            // AJAX PAGINATE DESA
            // =====================================================
            $(document).ready(function() {

                let searchTimer = null;

                // =========================================================
                // KONFIGURASI
                // =========================================================

                const AJAX_URL = "{{ route('superadmin.desa.paginate') }}";
                const SEARCH_DELAY = 400;

                const $tbody = $('#desaTable tbody');
                const $pagination = $('#paginationLinks');
                const $searchInput = $('#searchInput');


                // =========================================================
                // LOAD DATA DESA
                // =========================================================

                function loadDesa(page = 1, query = '') {

                    $.ajax({

                        url: AJAX_URL,

                        type: 'GET',

                        data: {
                            page: page,
                            search: query
                        },

                        beforeSend: function() {

                            // Bisa dikosongkan agar tidak terlalu banyak
                            // loading ketika user mengetik pencarian.

                        },

                        success: function(response) {

                            renderDesa(response);

                            renderPagination(response, query);

                        },

                        error: function(xhr) {

                            console.error(
                                "Error:",
                                xhr.responseText
                            );

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat memuat data desa.'
                            });

                        }

                    });

                }


                // =========================================================
                // RENDER DATA DESA
                // =========================================================

                function renderDesa(response) {

                    $tbody.empty();

                    if (!response.data || response.data.length === 0) {

                        renderEmptyData();

                        return;
                    }

                    response.data.forEach(function(data, index) {

                        const rowNumber =
                            response.from + index;

                        $tbody.append(
                            createDesaRow(
                                data,
                                rowNumber,
                                index
                            )
                        );

                    });

                }


                // =========================================================
                // EMPTY DATA
                // =========================================================

                function renderEmptyData() {

                    $tbody.html(`

            <tr>

                <td
                    colspan="8"
                    style="
                        padding:48px;
                        text-align:center;
                        color:#94A3B8;
                        border:1.5px solid #CBD5E1;
                    "
                >

                    <i
                        class="fas fa-building fa-2x mb-3"
                        style="
                            opacity:0.3;
                            display:block;
                        "
                    ></i>

                    <span
                        style="
                            font-size:15px;
                            font-weight:500;
                        "
                    >
                        Data desa tidak ditemukan
                    </span>

                </td>

            </tr>

        `);

                }


                // =========================================================
                // CREATE ROW DESA
                // =========================================================

                function createDesaRow(
                    data,
                    rowNumber,
                    index
                ) {

                    const rowBackground =
                        index % 2 === 1 ?
                        '#F8FAFC' :
                        '#FFFFFF';


                    // =====================================================
                    // STATUS
                    // =====================================================

                    const statusBadge = data.status

                        ?
                        `
                <span
                    style="
                        display:inline-flex;
                        align-items:center;
                        gap:6px;
                        padding:6px 10px;
                        border-radius:20px;
                        background:#DCFCE7;
                        color:#166534;
                        font-size:13px;
                        font-weight:600;
                    "
                >
                    <i class="fas fa-check-circle"></i>
                    Aktif
                </span>
            `

                        :
                        `
                <span
                    style="
                        display:inline-flex;
                        align-items:center;
                        gap:6px;
                        padding:6px 10px;
                        border-radius:20px;
                        background:#FEE2E2;
                        color:#991B1B;
                        font-size:13px;
                        font-weight:600;
                    "
                >
                    <i class="fas fa-times-circle"></i>
                    Nonaktif
                </span>
            `;


                    // =====================================================
                    // DOMAIN
                    // =====================================================

                    let domain = data.domain || '-';

                    let domainUrl = '-';

                    if (data.domain) {

                        domainUrl =
                            `
                    <a
                        href="https://${data.domain}"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="
                            color:#2E7D32;
                            font-weight:600;
                            text-decoration:none;
                        "
                    >
                        <i
                            class="fas fa-external-link-alt"
                            style="margin-right:5px;"
                        ></i>

                        ${data.domain}

                    </a>
                `;

                    }


                    // =====================================================
                    // CREATE ROW
                    // =====================================================

                    return `

            <tr

                style="
                    background:${rowBackground};
                    transition:background .15s;
                "

                onmouseover="
                    this.style.background='#EEF2FF'
                "

                onmouseout="
                    this.style.background='${rowBackground}'
                "
            >

                <!-- NO -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:15px;
                        font-weight:700;
                        color:#334155;
                        border:1.5px solid #CBD5E1;
                        text-align:center;
                    "
                >
                    ${rowNumber}
                </td>


                <!-- NAMA DESA -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:15px;
                        font-weight:600;
                        color:#0F172A;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    ${data.nama_desa || '-'}
                </td>


                <!-- DOMAIN -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:14px;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    ${domainUrl}
                </td>


                <!-- KECAMATAN -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:15px;
                        color:#334155;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    ${data.kecamatan || '-'}
                </td>


                <!-- KABUPATEN -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:15px;
                        color:#334155;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    ${data.kabupaten || '-'}
                </td>


                <!-- PROVINSI -->

                <td
                    style="
                        padding:14px 18px;
                        font-size:15px;
                        color:#334155;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    ${data.provinsi || '-'}
                </td>


                <!-- STATUS -->

                <td
                    style="
                        padding:14px 18px;
                        border:1.5px solid #CBD5E1;
                        text-align:center;
                    "
                >
                    ${statusBadge}
                </td>


                <!-- AKSI -->

                <td
                    style="
                        padding:14px 18px;
                        border:1.5px solid #CBD5E1;
                        text-align:center;
                    "
                >

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            gap:6px;
                        "
                    >

                        <!-- EDIT -->

                        <button

                            type="button"

                            class="btn-edit"

                            data-id="${data.id}"

                            title="Edit"

                            style="
                                width:36px;
                                height:36px;
                                border-radius:8px;
                                border:1.5px solid #F59E0B;
                                background:#FFF3E0;
                                color:#B45309;
                                font-size:15px;
                                cursor:pointer;
                                transition:all .15s;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            "

                            onmouseover="
                                this.style.background='#F59E0B';
                                this.style.color='#fff';
                            "

                            onmouseout="
                                this.style.background='#FFF3E0';
                                this.style.color='#B45309';
                            "
                        >

                            <i class="fas fa-edit"></i>

                        </button>


                        <!-- HAPUS -->

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

                            onmouseover="
                                this.style.background='#EF4444';
                                this.style.color='#fff';
                            "

                            onmouseout="
                                this.style.background='#FFF0F0';
                                this.style.color='#B91C1C';
                            "
                        >

                            <i class="fas fa-trash"></i>

                        </button>

                    </div>

                </td>

            </tr>

        `;

                }


                // =========================================================
                // RENDER PAGINATION
                // =========================================================

                function renderPagination(
                    response,
                    query
                ) {

                    $pagination.empty();

                    if (response.last_page <= 1) {
                        return;
                    }

                    renderPreviousButton(
                        response,
                        query
                    );

                    renderPageNumbers(
                        response,
                        query
                    );

                    renderNextButton(
                        response,
                        query
                    );

                }


                // =========================================================
                // PREVIOUS BUTTON
                // =========================================================

                function renderPreviousButton(
                    response,
                    query
                ) {

                    if (response.current_page <= 1) {
                        return;
                    }

                    $pagination.append(`

            <li class="page-item">

                <a
                    href="#"
                    class="page-link pagination-link"

                    data-page="${response.current_page - 1}"

                    data-query="${query}"
                >

                    <i class="fas fa-chevron-left"></i>

                </a>

            </li>

        `);

                }


                // =========================================================
                // PAGE NUMBERS
                // =========================================================

                function renderPageNumbers(
                    response,
                    query
                ) {

                    for (
                        let page = 1; page <= response.last_page; page++
                    ) {

                        const activeClass =
                            response.current_page === page ?
                            'active' :
                            '';

                        $pagination.append(`

                <li
                    class="page-item ${activeClass}"
                >

                    <a
                        href="#"
                        class="page-link pagination-link"

                        data-page="${page}"

                        data-query="${query}"
                    >

                        ${page}

                    </a>

                </li>

            `);

                    }

                }


                // =========================================================
                // NEXT BUTTON
                // =========================================================

                function renderNextButton(
                    response,
                    query
                ) {

                    if (
                        response.current_page >=
                        response.last_page
                    ) {

                        return;

                    }

                    $pagination.append(`

            <li class="page-item">

                <a
                    href="#"
                    class="page-link pagination-link"

                    data-page="${response.current_page + 1}"

                    data-query="${query}"
                >

                    <i class="fas fa-chevron-right"></i>

                </a>

            </li>

        `);

                }


                // =========================================================
                // SEARCH DESA
                // =========================================================

                $searchInput.on(
                    'input',
                    function() {

                        const query =
                            $(this).val().trim();

                        clearTimeout(
                            searchTimer
                        );

                        searchTimer = setTimeout(
                            function() {

                                loadDesa(
                                    1,
                                    query
                                );

                            },
                            SEARCH_DELAY
                        );

                    }
                );


                // =========================================================
                // PAGINATION CLICK
                // =========================================================

                $(document).on(
                    'click',
                    '.pagination-link',
                    function(e) {

                        e.preventDefault();

                        const page =
                            $(this).data('page');

                        const query =
                            $searchInput
                            .val()
                            .trim();

                        loadDesa(
                            page,
                            query
                        );

                    }
                );


                // =========================================================
                // INITIAL LOAD
                // =========================================================

                loadDesa();

            });
        </script>
    @endsection
