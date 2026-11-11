@extends('layouts.app')

@section('page-title', 'Dashboard Superadmin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-chart-pie" style="color:#2E7D32;"></i> Dashboard
                </h1>
            </div>

            <div class="row" style="row-gap:24px;">

                {{-- ========================================================= --}}
                {{-- 1. JUMLAH PENDUDUK --}}
                {{-- Route: admin.penduduk.index --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.penduduk.index') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#EEF2FF;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="fas fa-users" style="font-size:28px; color:#4338CA;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#4338CA;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Jumlah <br> Penduduk
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($jumlahPenduduk ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 2. JUMLAH SURAT --}}
                {{-- Route: admin.surat.pengajuan --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.surat.pengajuan') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#E0F2FE;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="far fa-envelope" style="font-size:28px; color:#0369A1;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#0369A1;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Jumlah <br> Surat
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($jumlahSurat ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 3. SURAT SELESAI --}}
                {{-- Route: admin.surat.pengajuan --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.surat.pengajuan') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#DCFCE7;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="far fa-check-circle" style="font-size:28px; color:#15803D;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#15803D;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Surat <br> Selesai
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($suratSelesai ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 4. SURAT DIPROSES --}}
                {{-- Route: admin.surat.pengajuan --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.surat.pengajuan') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#FFF3E0;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="far fa-clock" style="font-size:28px; color:#B45309;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#B45309;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Surat <br> Diproses
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($suratDiproses ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 5. SURAT DITOLAK --}}
                {{-- Route: admin.surat.pengajuan --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.surat.pengajuan') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#FFF0F0;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="far fa-times-circle" style="font-size:28px; color:#B91C1C;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#B91C1C;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Surat <br> Ditolak
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($suratDitolak ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 6. JUMLAH PRODUK --}}
                {{-- Route: admin.produk.index --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.produk.index') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#F1F5F9;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="fas fa-box-open" style="font-size:28px; color:#475569;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#475569;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Jumlah <br> Produk
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($jumlahProduk ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 7. JUMLAH APARAT --}}
                {{-- Route: admin.aparat.index --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('admin.aparat.index') }}"
                        style="text-decoration:none; color:inherit; display:block;">

                        <div style="
                            background:#fff;
                            border-radius:18px;
                            border:0.5px solid #E2E8F0;
                            box-shadow:0 4px 16px rgba(0,0,0,0.07);
                            padding:30px 26px;
                            display:flex;
                            align-items:center;
                            gap:20px;
                            transition:transform .2s, box-shadow .2s;
                            cursor:pointer;
                        "
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">

                            <div
                                style="
                                width:68px;
                                height:68px;
                                min-width:68px;
                                border-radius:16px;
                                background:#DCFCE7;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="fas fa-user-tie" style="font-size:28px; color:#2E7D32;"></i>
                            </div>

                            <div style="overflow:hidden;">
                                <div
                                    style="
                                    font-size:13px;
                                    font-weight:800;
                                    color:#2E7D32;
                                    text-transform:uppercase;
                                    letter-spacing:0.6px;
                                    margin-bottom:6px;
                                    white-space:nowrap;
                                ">
                                    Jumlah <br> Aparat
                                </div>

                                <div
                                    style="
                                    font-size:32px;
                                    font-weight:800;
                                    color:#0F172A;
                                    line-height:1.1;
                                ">
                                    {{ number_format($jumlahAparat ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                        </div>
                    </a>
                </div>


                {{-- ========================================================= --}}
                {{-- 8. JUMLAH DUSUN --}}
                {{-- KLIK → ADMIN DUSUN --}}
                {{-- ========================================================= --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                    <a href="{{ route('admin.dusun.index') }}"
                        style="
            text-decoration:none;
            display:block;
            color:inherit;
       ">

                        <div style="
            background:#fff;
            border-radius:18px;
            border:0.5px solid #E2E8F0;
            box-shadow:0 4px 16px rgba(0,0,0,0.07);
            padding:30px 26px;
            display:flex;
            align-items:center;
            gap:20px;
            transition:transform .2s, box-shadow .2s;
            cursor:pointer;
        "
                            onmouseover="
            this.style.transform='translateY(-5px)';
            this.style.boxShadow='0 14px 30px rgba(0,0,0,0.12)';
        "
                            onmouseout="
            this.style.transform='translateY(0)';
            this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)';
        ">

                            {{-- ICON --}}
                            <div
                                style="
                width:68px;
                height:68px;
                min-width:68px;
                border-radius:16px;
                background:#E0F2FE;
                display:flex;
                align-items:center;
                justify-content:center;
            ">
                                <i class="fas fa-map-marked-alt" style="font-size:28px; color:#0369A1;">
                                </i>
                            </div>


                            {{-- CONTENT --}}
                            <div style="overflow:hidden;">

                                <div
                                    style="
                    font-size:13px;
                    font-weight:800;
                    color:#0369A1;
                    text-transform:uppercase;
                    letter-spacing:0.6px;
                    margin-bottom:6px;
                    white-space:nowrap;
                ">
                                    Jumlah <br> Dusun
                                </div>

                                <div
                                    style="
                    font-size:32px;
                    font-weight:800;
                    color:#0F172A;
                    line-height:1.1;
                ">
                                    {{ number_format($jumlah_dusun ?? 0, 0, ',', '.') }}
                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </section>
    </div>
@endsection
