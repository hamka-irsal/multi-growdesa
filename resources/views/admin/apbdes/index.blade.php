@extends('admin.layouts.app')

@section('page-title', 'Data-Apbdes Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">

                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-chart-pie" style="color:#2E7D32;"></i>
                    Data APBDes
                </h1>

                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard.index') }}">
                            Dashboard
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        <a href="{{ route('admin.apbdes.index') }}">
                            Data APBDes
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        APBDes
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

                                List Data APBDes

                            </h4>


                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">

                                {{-- Search --}}
                                <div style="position:relative;">

                                    <i class="fas fa-search"
                                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; font-size:13px;"></i>

                                    <input type="text" id="searchInput" autocomplete="off" placeholder="Search tahun"
                                        style="padding:9px 14px 9px 34px; border:1.5px solid #E2E8F0; border-radius:10px; font-size:14px; color:#1E293B; background:#F8FAFC; width:200px; outline:none; transition:border .2s;"
                                        onfocus="this.style.borderColor='#6777ef';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#E2E8F0';this.style.background='#F8FAFC'">

                                </div>


                                {{-- Tambah --}}
                                <button type="button" data-toggle="modal" data-target="#modalTambahApbdes"
                                    style="display:flex; align-items:center; gap:7px; padding:9px 18px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; transition:background .2s; white-space:nowrap;"
                                    onmouseover="this.style.background='#256B2A'"
                                    onmouseout="this.style.background='#2E7D32'">

                                    <i class="fas fa-plus"></i>
                                    Tambah

                                </button>

                            </div>

                        </div>


                        {{-- Table --}}
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table mb-0" id="apbdesTable" style="border-collapse:collapse; width:100%;">

                                    <thead>

                                        <tr style="background:#F8FAFC;">

                                            {{-- No --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No
                                            </th>


                                            {{-- Tahun --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Tahun
                                            </th>


                                            {{-- Total Pendapatan --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:right;">
                                                Total Pendapatan
                                            </th>


                                            {{-- Realisasi Pendapatan --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:right;">
                                                Realisasi Pendapatan
                                            </th>


                                            {{-- Total Belanja --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:right;">
                                                Total Belanja
                                            </th>


                                            {{-- Realisasi Belanja --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:right;">
                                                Realisasi Belanja
                                            </th>


                                            {{-- Aksi --}}
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach ($apbdes as $index => $data)
                                            @php
                                                $rowBg = $loop->even ? '#F8FAFC' : '#fff';
                                            @endphp

                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                {{-- No --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">

                                                    {{ $apbdes->firstItem() + $index }}

                                                </td>


                                                {{-- Tahun --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#0F172A; border:1.5px solid #CBD5E1; text-align:center;">

                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">

                                                        {{ $data->tahun }}

                                                    </span>

                                                </td>


                                                {{-- Total Pendapatan --}}
                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:600; color:#15803D; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">

                                                    Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}

                                                </td>


                                                {{-- Realisasi Pendapatan --}}
                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:600; color:#15803D; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">

                                                    Rp {{ number_format($data->realisasi_pendapatan, 0, ',', '.') }}

                                                </td>


                                                {{-- Total Belanja --}}
                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:600; color:#DC2626; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">

                                                    Rp {{ number_format($data->total_belanja, 0, ',', '.') }}

                                                </td>


                                                {{-- Realisasi Belanja --}}
                                                <td
                                                    style="padding:14px 18px; font-size:14px; font-weight:600; color:#DC2626; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">

                                                    Rp {{ number_format($data->realisasi_belanja, 0, ',', '.') }}

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

    {{-- Modal Tambah APBDes --}}
    <div class="modal fade" id="modalTambahApbdes" tabindex="-1" role="dialog" aria-labelledby="modalTambahApbdesLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">

                    <h5 class="modal-title" id="modalTambahApbdesLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">

                        <i class="fas fa-chart-pie"></i>
                        Tambah APBDes

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>


                {{-- Form --}}
                <form action="{{ route('admin.apbdes.store') }}" method="POST" id="formTambahApbdes">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC; max-height:70vh; overflow-y:auto;">

                        <div class="row">

                            {{-- ========================= --}}
                            {{-- KOLOM KIRI --}}
                            {{-- ========================= --}}

                            <div class="col-md-6">

                                {{-- Tahun --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-calendar-alt" style="color:#2E7D32;"></i>

                                        Tahun

                                    </label>

                                    <input type="number" name="tahun" min="2000" max="2100"
                                        placeholder="Contoh: 2026" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Total Pendapatan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-arrow-down" style="color:#2E7D32;"></i>

                                        Total Pendapatan

                                    </label>

                                    <input type="number" name="total_pendapatan" min="0" step="0.01"
                                        placeholder="Masukkan total pendapatan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Realisasi Pendapatan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-check-circle" style="color:#2E7D32;"></i>

                                        Realisasi Pendapatan

                                    </label>

                                    <input type="number" name="realisasi_pendapatan" min="0" step="0.01"
                                        placeholder="Masukkan realisasi pendapatan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Total Belanja --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-shopping-cart" style="color:#2E7D32;"></i>

                                        Total Belanja

                                    </label>

                                    <input type="number" name="total_belanja" min="0" step="0.01"
                                        placeholder="Masukkan total belanja" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Realisasi Belanja --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-check-double" style="color:#2E7D32;"></i>

                                        Realisasi Belanja

                                    </label>

                                    <input type="number" name="realisasi_belanja" min="0" step="0.01"
                                        placeholder="Masukkan realisasi belanja" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Total Pembiayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-wallet" style="color:#2E7D32;"></i>

                                        Total Pembiayaan

                                    </label>

                                    <input type="number" name="total_pembiayaan" min="0" step="0.01"
                                        placeholder="Masukkan total pembiayaan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Realisasi Pembiayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-money-check-alt" style="color:#2E7D32;"></i>

                                        Realisasi Pembiayaan

                                    </label>

                                    <input type="number" name="realisasi_pembiayaan" min="0" step="0.01"
                                        placeholder="Masukkan realisasi pembiayaan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>

                            </div>


                            {{-- ========================= --}}
                            {{-- KOLOM KANAN --}}
                            {{-- ========================= --}}

                            <div class="col-md-6">

                                {{-- SILPA --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-coins" style="color:#2E7D32;"></i>

                                        SILPA Tahun Lalu

                                    </label>

                                    <input type="number" name="silpa_tahun_lalu" min="0" step="0.01"
                                        placeholder="Masukkan SILPA tahun lalu" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Pemerintahan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-landmark" style="color:#2E7D32;"></i>

                                        Pemerintahan

                                    </label>

                                    <input type="number" name="pemerintahan" min="0" step="0.01"
                                        placeholder="Anggaran pemerintahan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Pembangunan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-building" style="color:#2E7D32;"></i>

                                        Pembangunan

                                    </label>

                                    <input type="number" name="pembangunan" min="0" step="0.01"
                                        placeholder="Anggaran pembangunan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Pemberdayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-users" style="color:#2E7D32;"></i>

                                        Pemberdayaan

                                    </label>

                                    <input type="number" name="pemberdayaan" min="0" step="0.01"
                                        placeholder="Anggaran pemberdayaan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Lainnya --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-ellipsis-h" style="color:#2E7D32;"></i>

                                        Lainnya

                                    </label>

                                    <input type="number" name="lainnya" min="0" step="0.01"
                                        placeholder="Anggaran lainnya" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>


                                {{-- Status --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-toggle-on" style="color:#2E7D32;"></i>

                                        Status

                                    </label>

                                    <select name="status" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                        <option value="draft">
                                            Draft
                                        </option>

                                        <option value="published">
                                            Published
                                        </option>

                                        <option value="archived">
                                            Archived
                                        </option>

                                    </select>

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
                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Modal Edit APBDes --}}
    <div class="modal fade" id="modalEditApbdes" tabindex="-1" role="dialog" aria-labelledby="modalEditApbdesLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditApbdesLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-file-invoice-dollar"></i> Edit APBDes
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" id="formEditApbdes">

                    @csrf

                    {{-- Method spoofing untuk request PUT --}}
                    <input type="hidden" name="_method" value="PUT">

                    {{-- ID APBDes --}}
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB; max-height:70vh; overflow-y:auto;">

                        <div class="row">

                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Tahun --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-calendar-alt" style="color:#F59E0B;"></i>
                                        Tahun
                                    </label>

                                    <input type="number" name="tahun" id="edit_tahun" min="2000" max="2100"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Total Pendapatan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-wallet" style="color:#F59E0B;"></i>
                                        Total Pendapatan
                                    </label>

                                    <input type="number" name="total_pendapatan" id="edit_total_pendapatan"
                                        min="0" step="0.01" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Realisasi Pendapatan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-chart-line" style="color:#F59E0B;"></i>
                                        Realisasi Pendapatan
                                    </label>

                                    <input type="number" name="realisasi_pendapatan" id="edit_realisasi_pendapatan"
                                        min="0" step="0.01" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Total Belanja --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-shopping-cart" style="color:#F59E0B;"></i>
                                        Total Belanja
                                    </label>

                                    <input type="number" name="total_belanja" id="edit_total_belanja" min="0"
                                        step="0.01" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Realisasi Belanja --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-money-bill-wave" style="color:#F59E0B;"></i>
                                        Realisasi Belanja
                                    </label>

                                    <input type="number" name="realisasi_belanja" id="edit_realisasi_belanja"
                                        min="0" step="0.01" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Total Pembiayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-coins" style="color:#F59E0B;"></i>
                                        Total Pembiayaan
                                    </label>

                                    <input type="number" name="total_pembiayaan" id="edit_total_pembiayaan"
                                        min="0" step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Realisasi Pembiayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-chart-line" style="color:#F59E0B;"></i>
                                        Realisasi Pembiayaan
                                    </label>

                                    <input type="number" name="realisasi_pembiayaan" id="edit_realisasi_pembiayaan"
                                        min="0" step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>


                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">\

                                {{-- SILPA Tahun Lalu --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-piggy-bank" style="color:#F59E0B;"></i>
                                        SILPA Tahun Lalu
                                    </label>

                                    <input type="number" name="silpa_tahun_lalu" id="edit_silpa_tahun_lalu"
                                        min="0" step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Pemerintahan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-landmark" style="color:#F59E0B;"></i>
                                        Pemerintahan
                                    </label>

                                    <input type="number" name="pemerintahan" id="edit_pemerintahan" min="0"
                                        step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Pembangunan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-building" style="color:#F59E0B;"></i>
                                        Pembangunan
                                    </label>

                                    <input type="number" name="pembangunan" id="edit_pembangunan" min="0"
                                        step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Pemberdayaan --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-users" style="color:#F59E0B;"></i>
                                        Pemberdayaan
                                    </label>

                                    <input type="number" name="pemberdayaan" id="edit_pemberdayaan" min="0"
                                        step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8E8F0'">
                                </div>

                                {{-- Lainnya --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-ellipsis-h" style="color:#F59E0B;"></i>
                                        Lainnya
                                    </label>

                                    <input type="number" name="lainnya" id="edit_lainnya" min="0"
                                        step="0.01"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Status --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-toggle-on" style="color:#F59E0B;"></i>
                                        Status
                                    </label>

                                    <select name="status" id="edit_status" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>

                                    </select>
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
        // AJAX Modal Tambah APBDes
        $(document).ready(function() {

            $("#formTambahApbdes").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Reset error sebelumnya
                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback").text("");

                $.ajax({
                    url: "{{ route('admin.apbdes.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang menyimpan data APBDes',
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
                                    'Data APBDes berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                // Tutup modal
                                $("#modalTambahApbdes").modal("hide");

                                // Reset form
                                $("#formTambahApbdes")[0].reset();

                                // Reload halaman
                                location.reload();

                            });

                        } else {

                            let errorMessage =
                                'Terjadi kesalahan saat menambahkan data APBDes.';

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
                            'Terjadi kesalahan saat mengirim data APBDes.';

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
            $("#formTambahApbdes").on("submit", function(event) {

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
            $("#formTambahApbdes input, " +
                    "#formTambahApbdes select, " +
                    "#formTambahApbdes textarea")
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
            let url = `/admin/apbdes/${id}`;

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

        // 🟢 AJAX Edit APBDes
        $(document).on("click", ".btn-edit", function() {

            let id = $(this).data("id");

            console.log("ID APBDes:", id);

            $.ajax({
                url: `/admin/apbdes/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    console.log("Response Edit APBDes:", response);

                    if (response.success === true) {

                        let data = response.data;

                        // Atur URL form untuk proses update
                        $("#formEditApbdes").attr(
                            "action",
                            `/admin/apbdes/${data.id}`
                        );

                        // Isi data ke modal
                        $("#edit_id").val(data.id);
                        $("#edit_tahun").val(data.tahun);

                        $("#edit_total_pendapatan")
                            .val(data.total_pendapatan);

                        $("#edit_realisasi_pendapatan")
                            .val(data.realisasi_pendapatan);

                        $("#edit_total_belanja")
                            .val(data.total_belanja);

                        $("#edit_realisasi_belanja")
                            .val(data.realisasi_belanja);

                        // Pembiayaan
                        $("#edit_total_pembiayaan")
                            .val(data.total_pembiayaan);

                        $("#edit_realisasi_pembiayaan")
                            .val(data.realisasi_pembiayaan);

                        // SILPA
                        $("#edit_silpa_tahun_lalu")
                            .val(data.silpa_tahun_lalu);

                        // Bidang Belanja
                        $("#edit_pemerintahan")
                            .val(data.pemerintahan);

                        $("#edit_pembangunan")
                            .val(data.pembangunan);

                        $("#edit_pemberdayaan")
                            .val(data.pemberdayaan);

                        $("#edit_lainnya")
                            .val(data.lainnya);

                        // Status
                        $("#edit_status")
                            .val(data.status);

                        // Reset error sebelumnya
                        $("#formEditApbdes")
                            .find(".is-invalid")
                            .removeClass("is-invalid");

                        $("#formEditApbdes")
                            .find(".invalid-feedback")
                            .text("");

                        // Tampilkan modal
                        $("#modalEditApbdes").modal("show");

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message ||
                                "Data APBDes tidak ditemukan."
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
                        "Gagal memuat data APBDes dari server.";

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


        // 🟢 AJAX Submit Edit APBDes
        $("#formEditApbdes").on("submit", function(e) {

            e.preventDefault();

            // Ambil form dan ID APBDes
            let form = this;
            let formData = new FormData(form);
            let id = $("#edit_id").val();

            console.log(
                "ID APBDes yang akan diperbarui:",
                id
            );

            // Pastikan ID tersedia
            if (!id) {

                Swal.fire({
                    title: "Gagal!",
                    text: "ID APBDes tidak ditemukan.",
                    icon: "error"
                });

                return;
            }

            $.ajax({

                // URL update APBDes
                url: `/admin/apbdes/${id}`,

                // Tetap POST karena Laravel menggunakan _method=PUT
                type: "POST",

                data: formData,

                // Wajib false saat menggunakan FormData
                processData: false,
                contentType: false,

                beforeSend: function() {

                    // Reset error sebelumnya
                    $("#formEditApbdes")
                        .find(".is-invalid")
                        .removeClass("is-invalid");

                    $("#formEditApbdes")
                        .find(".invalid-feedback")
                        .text("");

                    // Nonaktifkan tombol saat proses simpan
                    $("#formEditApbdes button[type='submit']")
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
                        "Response Update APBDes:",
                        response
                    );

                    if (response.success === true) {

                        Swal.fire({

                            title: "Berhasil!",

                            text: response.message ||
                                "Data APBDes berhasil diperbarui.",

                            icon: "success",

                            timer: 2000,

                            showConfirmButton: false

                        }).then(function() {

                            // Tutup modal
                            $("#modalEditApbdes")
                                .modal("hide");

                            // Reset form
                            form.reset();

                            // Refresh halaman
                            location.reload();

                        });

                    } else {

                        Swal.fire({

                            title: "Gagal!",

                            text: response.message ||
                                "Data APBDes gagal diperbarui.",

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

                                // Tandai input yang error
                                let input =
                                    $("#edit_" + key);

                                if (input.length) {
                                    input.addClass("is-invalid");
                                }

                                // Tampilkan pesan di bawah input
                                let errorElement =
                                    $("#error_edit_" + key);

                                if (errorElement.length) {
                                    errorElement.text(value[0]);
                                }

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
                            "Terjadi kesalahan saat memperbarui data APBDes.";

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
                    $("#formEditApbdes button[type='submit']")
                        .prop("disabled", false)
                        .html(`
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                `);

                }

            });

        });

        // AJAX Search dan Pagination APBDes
        $(document).ready(function() {

            let searchTimer = null;

            // Fungsi untuk memuat data APBDes
            function loadApbdes(page = 1, search = '') {

                $.ajax({
                    url: "{{ route('admin.apbdes.paginate') }}",
                    type: "GET",
                    data: {
                        page: page,
                        search: search
                    },

                    success: function(response) {

                        let tbody = $('#apbdesTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        tbody.empty();
                        paginationLinks.empty();

                        // Jika data APBDes tidak ditemukan
                        if (!response.data || response.data.length === 0) {

                            tbody.append(`
                        <tr>
                            <td colspan="6"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">

                                <i class="fas fa-file-invoice-dollar fa-2x mb-3"
                                    style="opacity:0.3; display:block;"></i>

                                <span style="font-size:15px; font-weight:500;">
                                    Data APBDes tidak ditemukan
                                </span>

                            </td>
                        </tr>
                    `);

                            return;
                        }


                        // Menampilkan data APBDes
                        response.data.forEach(function(data, index) {

                            let rowBg =
                                (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            // Nomor urut
                            let nomor =
                                response.from + index;


                            // Format Rupiah
                            function formatRupiah(value) {

                                if (value === null || value === undefined) {
                                    value = 0;
                                }

                                return new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(value);

                            }


                            let totalPendapatan =
                                formatRupiah(data.total_pendapatan);

                            let realisasiPendapatan =
                                formatRupiah(data.realisasi_pendapatan);

                            let totalBelanja =
                                formatRupiah(data.total_belanja);

                            let realisasiBelanja =
                                formatRupiah(data.realisasi_belanja);


                            let row = `
                        <tr
                            style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            {{-- No --}}
                            <td
                                style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${nomor}
                            </td>


                            {{-- Tahun --}}
                            <td
                                style="padding:14px 18px; font-size:15px; font-weight:700; color:#0F172A; border:1.5px solid #CBD5E1; text-align:center;">
                                ${data.tahun}
                            </td>


                            {{-- Total Pendapatan --}}
                            <td
                                style="padding:14px 18px; font-size:14px; font-weight:600; color:#334155; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">
                                Rp ${totalPendapatan}
                            </td>


                            {{-- Realisasi Pendapatan --}}
                            <td
                                style="padding:14px 18px; font-size:14px; font-weight:600; color:#334155; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">
                                Rp ${realisasiPendapatan}
                            </td>


                            {{-- Total Belanja --}}
                            <td
                                style="padding:14px 18px; font-size:14px; font-weight:600; color:#334155; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">
                                Rp ${totalBelanja}
                            </td>


                            {{-- Realisasi Belanja --}}
                            <td
                                style="padding:14px 18px; font-size:14px; font-weight:600; color:#334155; border:1.5px solid #CBD5E1; text-align:right; white-space:nowrap;">
                                Rp ${realisasiBelanja}
                            </td>


                            {{-- Aksi --}}
                            <td
                                style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">

                                <div
                                    style="display:flex; align-items:center; justify-content:center; gap:6px;">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        class="btn-edit"
                                        data-id="${data.id}"
                                        title="Edit"

                                        style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"

                                        onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                        onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">

                                        <i class="fas fa-edit"></i>

                                    </button>


                                    {{-- Hapus --}}
                                    <button
                                        type="button"
                                        class="btn-hapus"
                                        data-id="${data.id}"
                                        title="Hapus"

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


                            // Tombol Previous
                            if (response.current_page > 1) {

                                paginationLinks.append(`
                            <li class="page-item">

                                <a
                                    class="page-link pagination-link"
                                    href="#"
                                    data-page="${response.current_page - 1}">

                                    <i class="fas fa-chevron-left"></i>

                                </a>

                            </li>
                        `);

                            }


                            // Nomor halaman
                            for (
                                let i = 1; i <= response.last_page; i++
                            ) {

                                let activeClass =
                                    response.current_page == i ?
                                    'active' :
                                    '';


                                paginationLinks.append(`
                            <li class="page-item ${activeClass}">

                                <a
                                    class="page-link pagination-link"
                                    href="#"
                                    data-page="${i}">

                                    ${i}

                                </a>

                            </li>
                        `);

                            }


                            // Tombol Next
                            if (
                                response.current_page <
                                response.last_page
                            ) {

                                paginationLinks.append(`
                            <li class="page-item">

                                <a
                                    class="page-link pagination-link"
                                    href="#"
                                    data-page="${response.current_page + 1}">

                                    <i class="fas fa-chevron-right"></i>

                                </a>

                            </li>
                        `);

                            }

                        }

                    },


                    error: function(xhr) {

                        console.error(
                            'Gagal memuat data APBDes:',
                            xhr.responseText
                        );

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal!',

                            text: 'Terjadi kesalahan saat memuat data APBDes.'

                        });

                    }

                });

            }


            // Load semua APBDes saat halaman pertama kali dibuka
            loadApbdes();


            // Pencarian APBDes
            // Menggunakan debounce agar tidak request setiap ketikan
            $('#searchInput').on('keyup', function() {

                let search = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {

                    // Saat mencari,
                    // selalu kembali ke halaman pertama
                    loadApbdes(1, search);

                }, 400);

            });


            // Klik pagination
            $(document).on(
                'click',
                '.pagination-link',
                function(e) {

                    e.preventDefault();

                    let page =
                        $(this).data('page');

                    let search =
                        $('#searchInput').val();

                    loadApbdes(
                        page,
                        search
                    );

                }
            );

        });
    </script>
@endsection
