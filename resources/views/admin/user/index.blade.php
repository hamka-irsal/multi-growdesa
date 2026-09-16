@extends('admin.layouts.app')

@section('page-title', 'Data-Operator Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-users-cog" style="color:#2E7D32;"></i> Data Operator
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                    </div>
                    <div class="breadcrumb-item">
                        <a href="{{ route('admin.user.index') }}">Operator</a>
                    </div>
                    <div class="breadcrumb-item">Daftar Operator</div>
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
                                List Data Operator
                            </h4>

                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">

                                {{-- Search --}}
                                <div style="position:relative;">
                                    <i class="fas fa-search"
                                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; font-size:13px;"></i>
                                    <input type="text" id="searchOperator" autocomplete="off"
                                        placeholder="Cari operator..."
                                        style="padding:9px 14px 9px 34px; border:1.5px solid #E2E8F0; border-radius:10px; font-size:14px; color:#1E293B; background:#F8FAFC; width:200px; outline:none; transition:border .2s;"
                                        onfocus="this.style.borderColor='#2E7D32';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#E2E8F0';this.style.background='#F8FAFC'">
                                </div>

                                {{-- Tambah --}}
                                <button type="button" data-toggle="modal" data-target="#modalTambahUser"
                                    style="display:flex; align-items:center; gap:7px; padding:9px 18px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; cursor:pointer; transition:background .2s; white-space:nowrap;"
                                    onmouseover="this.style.background='#256528'"
                                    onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>

                            </div>
                        </div>

                        {{-- Table --}}

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="operatorTable"
                                    style="border-collapse: collapse; width: 100%;">

                                    <thead>
                                        <tr style="background: #F8FAFC;">

                                            {{-- No --}}
                                            <th
                                                style="padding: 14px 18px; font-size: 13px; font-weight: 700;
                    color: #1E293B; text-transform: uppercase; letter-spacing: 0.6px;
                    border: 1.5px solid #CBD5E1; width: 55px; text-align: center;">
                                                No
                                            </th>

                                            {{-- Nama --}}
                                            <th
                                                style="padding: 14px 18px; font-size: 13px; font-weight: 700;
                    color: #1E293B; text-transform: uppercase; letter-spacing: 0.6px;
                    border: 1.5px solid #CBD5E1;">
                                                Nama Operator
                                            </th>

                                            {{-- Email --}}
                                            <th
                                                style="padding: 14px 18px; font-size: 13px; font-weight: 700;
                    color: #1E293B; text-transform: uppercase; letter-spacing: 0.6px;
                    border: 1.5px solid #CBD5E1;">
                                                Email
                                            </th>

                                            {{-- Role --}}
                                            <th
                                                style="padding: 14px 18px; font-size: 13px; font-weight: 700;
                    color: #1E293B; text-transform: uppercase; letter-spacing: 0.6px;
                    border: 1.5px solid #CBD5E1; text-align: center;">
                                                Role/Jabatan
                                            </th>

                                            {{-- Aksi --}}
                                            <th
                                                style="padding: 14px 18px; font-size: 13px; font-weight: 700;
                    color: #1E293B; text-transform: uppercase; letter-spacing: 0.6px;
                    border: 1.5px solid #CBD5E1; width: 100px; text-align: center;">
                                                Aksi
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($users as $index => $user)
                                            @php
                                                $rowBg = $loop->even ? '#F8FAFC' : '#FFFFFF';

                                                $roleStyle = match (strtolower($user->role)) {
                                                    'admin' => [
                                                        'background' => '#EEF2FF',
                                                        'color' => '#3730A3',
                                                        'border' => '#C7D2FE',
                                                        'icon' => 'fas fa-user-shield',
                                                    ],

                                                    'aparat' => [
                                                        'background' => '#F0FDF4',
                                                        'color' => '#15803D',
                                                        'border' => '#86EFAC',
                                                        'icon' => 'fas fa-user-tie',
                                                    ],

                                                    'penduduk' => [
                                                        'background' => '#FFF7ED',
                                                        'color' => '#C2410C',
                                                        'border' => '#FED7AA',
                                                        'icon' => 'fas fa-users',
                                                    ],

                                                    default => [
                                                        'background' => '#F8FAFC',
                                                        'color' => '#475569',
                                                        'border' => '#CBD5E1',
                                                        'icon' => 'fas fa-user',
                                                    ],
                                                };
                                            @endphp

                                            <tr style="background: {{ $rowBg }}; transition: background 0.15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                {{-- Nomor --}}
                                                <td
                                                    style="padding: 14px 18px; font-size: 15px; font-weight: 700;
                        color: #334155; border: 1.5px solid #CBD5E1;
                        text-align: center;">

                                                    {{ $users->firstItem() + $index }}

                                                </td>

                                                {{-- Nama --}}
                                                <td
                                                    style="padding: 14px 18px;
                        border: 1.5px solid #CBD5E1;">

                                                    <div style="display: flex; align-items: center; gap: 10px;">

                                                        <div
                                                            style="width: 38px; height: 38px;
                                border-radius: 50%; background: #DCFCE7;
                                border: 2px solid #86EFAC;
                                display: flex; align-items: center;
                                justify-content: center; flex-shrink: 0;">

                                                            <i class="fas fa-user" style="font-size: 15px; color: #2E7D32;">
                                                            </i>

                                                        </div>

                                                        <div>
                                                            <span
                                                                style="display: block; font-size: 15px;
                                    font-weight: 600; color: #0F172A;">

                                                                {{ $user->name }}

                                                            </span>

                                                        </div>

                                                    </div>

                                                </td>

                                                {{-- Email --}}
                                                <td
                                                    style="padding: 14px 18px;
                        border: 1.5px solid #CBD5E1;">

                                                    <span
                                                        style="display: inline-flex;
                            align-items: center; gap: 7px;
                            font-size: 14px; color: #334155;">

                                                        <i class="fas fa-envelope"
                                                            style="color: #2E7D32;
                                font-size: 13px;">
                                                        </i>

                                                        {{ $user->email }}

                                                    </span>

                                                </td>

                                                {{-- Role --}}
                                                <td
                                                    style="padding: 14px 18px;
                        border: 1.5px solid #CBD5E1;
                        text-align: center;">

                                                    <span
                                                        style="display: inline-flex;
                            align-items: center; gap: 6px;
                            background: {{ $roleStyle['background'] }};
                            color: {{ $roleStyle['color'] }};
                            border: 1.5px solid {{ $roleStyle['border'] }};
                            padding: 5px 12px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 700;
                            text-transform: capitalize;">

                                                        <i class="{{ $roleStyle['icon'] }}"></i>

                                                        {{ $user->role }}

                                                    </span>

                                                </td>

                                                {{-- Aksi --}}
                                                <td
                                                    style="padding: 14px 18px;
                        border: 1.5px solid #CBD5E1;
                        text-align: center;">

                                                    <div
                                                        style="display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 6px;">

                                                        {{-- Edit --}}
                                                        <button type="button" class="btn-edit"
                                                            data-id="{{ $user->id }}" title="Edit Operator"
                                                            style="width: 36px;
                                height: 36px;
                                border-radius: 8px;
                                border: 1.5px solid #F59E0B;
                                background: #FFF3E0;
                                color: #B45309;
                                font-size: 15px;
                                cursor: pointer;
                                transition: all 0.15s;
                                display: flex;
                                align-items: center;
                                justify-content: center;"
                                                            onmouseover="
                                    this.style.background='#F59E0B';
                                    this.style.color='#FFFFFF';
                                "
                                                            onmouseout="
                                    this.style.background='#FFF3E0';
                                    this.style.color='#B45309';
                                ">

                                                            <i class="fas fa-edit"></i>

                                                        </button>

                                                        {{-- Hapus --}}
                                                        <button type="button" class="btn-hapus"
                                                            data-id="{{ $user->id }}" title="Hapus Operator"
                                                            style="width: 36px;
                                height: 36px;
                                border-radius: 8px;
                                border: 1.5px solid #EF4444;
                                background: #FFF0F0;
                                color: #B91C1C;
                                font-size: 15px;
                                cursor: pointer;
                                transition: all 0.15s;
                                display: flex;
                                align-items: center;
                                justify-content: center;"
                                                            onmouseover="
                                    this.style.background='#EF4444';
                                    this.style.color='#FFFFFF';
                                "
                                                            onmouseout="
                                    this.style.background='#FFF0F0';
                                    this.style.color='#B91C1C';
                                ">

                                                            <i class="fas fa-trash"></i>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="5"
                                                    style="padding: 48px;
                        text-align: center;
                        color: #94A3B8;
                        border: 1.5px solid #CBD5E1;">

                                                    <i class="fas fa-users-cog fa-2x"
                                                        style="opacity: 0.3;
                            display: block;
                            margin-bottom: 12px;">
                                                    </i>

                                                    <span
                                                        style="font-size: 15px;
                            font-weight: 500;">

                                                        Belum ada data operator

                                                    </span>

                                                </td>

                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>


                        </div>


                        {{-- Footer Pagination --}}
                        <div class="card-footer"
                            style="background:#F8FAFC; border-top:1.5px solid #F1F5F9; padding:14px 20px; display:flex; align-items:center; justify-content:center; border-radius:0 0 14px 14px;">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0" id="paginationLinks" style="gap:4px;"></ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Tambah User --}}
    <div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header Modal --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahUserLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-plus"></i> Tambah Operator
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Form Tambah User --}}
                <form action="{{ route('admin.user.store') }}" method="POST" id="formTambahUser">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC; max-height:75vh; overflow-y:auto;">

                        {{-- Data User --}}
                        <div class="row">

                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Nama Lengkap --}}
                                <div class="form-group mb-3">
                                    <label for="tambah_name"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#2E7D32;"></i> Nama Lengkap
                                    </label>
                                    <input type="text" name="name" id="tambah_name"
                                        placeholder="Masukkan nama lengkap" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Password --}}
                                <div class="form-group mb-3">
                                    <label for="tambah_password"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-lock" style="color:#2E7D32;"></i> Password
                                    </label>
                                    <input type="password" name="password" id="tambah_password"
                                        placeholder="Masukkan password" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">

                                {{-- Email --}}
                                <div class="form-group mb-3">
                                    <label for="tambah_email"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-envelope" style="color:#2E7D32;"></i> Email
                                    </label>
                                    <input type="email" name="email" id="tambah_email"
                                        placeholder="Masukkan email pengguna" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Level --}}
                                <div class="form-group mb-3">
                                    <label for="tambah_role"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-layer-group" style="color:#2E7D32;"></i> Level
                                    </label>
                                    <select name="role" id="tambah_role" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Level --</option>
                                        <option value="admin">Admin</option>
                                        <option value="aparat">Aparat</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <hr style="border-color:#E2E8F0; margin:20px 0;">

                        {{-- Permission --}}
                        <div class="form-group">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <label class="mb-0"
                                    style="font-size:16px; font-weight:700; color:#1E293B; display:flex; align-items:center; gap:8px;">
                                    <i class="fas fa-key" style="color:#2E7D32;"></i> Akses Permission
                                </label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pilihSemuaPermission"
                                        style="width:18px; height:18px; margin-top:0; cursor:pointer;">
                                    <label class="form-check-label" for="pilihSemuaPermission"
                                        style="font-size:14px; font-weight:600; color:#334155; cursor:pointer;">
                                        <strong>Pilih Semua Permission</strong>
                                    </label>
                                </div>

                            </div>

                            @php
                                $groupedPermissions = $permissions->sortBy('name')->groupBy(function ($permission) {
                                    return Str::headline(Str::before($permission->name, '.'));
                                });
                            @endphp

                            <div class="row">

                                @forelse ($groupedPermissions as $groupName => $groupPermissions)

                                    <div class="col-lg-6 col-md-6 mb-3">

                                        <div
                                            style="border:1.5px solid #E2E8F0; border-radius:12px; padding:16px; height:100%; background:#fff;">

                                            {{-- Header Grup --}}
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="border-bottom:1.5px solid #F1F5F9; padding-bottom:10px; margin-bottom:12px;">

                                                <h6 class="mb-0"
                                                    style="font-size:14px; font-weight:700; color:#2E7D32; display:flex; align-items:center; gap:8px;">
                                                    <i class="fas fa-folder-open"></i> {{ $groupName }}
                                                </h6>

                                                {{-- Pilih Semua per Fitur --}}
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input pilih-grup"
                                                        id="group_{{ Str::slug($groupName) }}"
                                                        data-group="{{ Str::slug($groupName) }}"
                                                        style="width:16px; height:16px; margin-top:0; cursor:pointer;">
                                                    <label class="form-check-label small"
                                                        for="group_{{ Str::slug($groupName) }}"
                                                        style="font-size:13px; color:#64748B; cursor:pointer;">
                                                        Semua
                                                    </label>
                                                </div>

                                            </div>

                                            {{-- List Permission --}}
                                            @foreach ($groupPermissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input
                                                        class="form-check-input permission-checkbox permission-group-{{ Str::slug($groupName) }}"
                                                        type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}"
                                                        style="width:16px; height:16px; margin-top:2px; cursor:pointer;">
                                                    <label class="form-check-label"
                                                        for="permission_{{ $permission->id }}"
                                                        style="font-size:14px; color:#334155; cursor:pointer;">
                                                        <strong>
                                                            {{ $permission->label ?? Str::headline(Str::after($permission->name, '.')) }}
                                                        </strong>
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>

                                @empty

                                    <div class="col-12">
                                        <div
                                            style="background:#FFF7ED; border:1.5px solid #FED7AA; border-radius:10px; padding:16px; color:#C2410C; font-size:14px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Data permission belum tersedia. Silakan jalankan:
                                            <code>php artisan db:seed --class=PermissionsTableSeeder</code>
                                        </div>
                                    </div>

                                @endforelse

                            </div>

                        </div>

                    </div>

                    {{-- Footer Modal --}}
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


    {{-- Modal Edit User --}}
    <div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modalEditUserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditUserLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-edit"></i> Edit Operator
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Form Edit --}}
                <form method="POST" id="formEditUser">
                    @csrf

                    {{-- Laravel Method PUT --}}
                    <input type="hidden" name="_method" value="PUT">

                    {{-- ID User --}}
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB; max-height:75vh; overflow-y:auto;">

                        {{-- Data Operator --}}
                        <div class="row">

                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Nama Lengkap --}}
                                <div class="form-group mb-3">
                                    <label for="edit_name"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#F59E0B;"></i> Nama Lengkap
                                    </label>
                                    <input type="text" name="name" id="edit_name"
                                        placeholder="Masukkan nama lengkap" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Password --}}
                                <div class="form-group mb-3">
                                    <label for="edit_password"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-lock" style="color:#F59E0B;"></i> Password
                                        <small style="font-size:13px; font-weight:500; color:#94A3B8;">(Kosongkan jika
                                            tidak diganti)</small>
                                    </label>
                                    <input type="password" name="password" id="edit_password"
                                        placeholder="Masukkan password baru"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">

                                {{-- Email --}}
                                <div class="form-group mb-3">
                                    <label for="edit_email"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-envelope" style="color:#F59E0B;"></i> Email
                                    </label>
                                    <input type="email" name="email" id="edit_email"
                                        placeholder="Masukkan email pengguna" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Role / Level --}}
                                <div class="form-group mb-3">
                                    <label for="edit_role"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-layer-group" style="color:#F59E0B;"></i> Level
                                    </label>
                                    <select name="role" id="edit_role" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Level --</option>
                                        <option value="admin">Admin</option>
                                        <option value="aparat">Aparat</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <hr style="border-color:#FDE68A; margin:20px 0;">

                        {{-- Permission --}}
                        <div class="form-group">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <label class="mb-0"
                                    style="font-size:16px; font-weight:700; color:#1E293B; display:flex; align-items:center; gap:8px;">
                                    <i class="fas fa-key" style="color:#F59E0B;"></i> Akses Fitur
                                </label>

                                {{-- Pilih Semua Permission --}}
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_select_all_permissions"
                                        style="width:18px; height:18px; cursor:pointer;">
                                    <label class="custom-control-label" for="edit_select_all_permissions"
                                        style="font-size:14px; font-weight:600; color:#334155; cursor:pointer;">
                                        Pilih Semua
                                    </label>
                                </div>

                            </div>

                            <div class="row">

                                @php
                                    $groupedPermissions = [];

                                    foreach ($permissions as $permission) {
                                        $parts = explode('.', $permission->name);

                                        $group = Str::headline(str_replace('-', ' ', $parts[0]));

                                        $groupedPermissions[$group][] = $permission;
                                    }
                                @endphp

                                @foreach ($groupedPermissions as $groupName => $groupPermissions)
                                    <div class="col-md-6 col-lg-4 mb-3">

                                        <div
                                            style="border:1.5px solid #E2E8F0; border-radius:12px; padding:16px; height:100%; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.04);">

                                            {{-- Nama Kelompok --}}
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="border-bottom:1.5px solid #F1F5F9; padding-bottom:10px; margin-bottom:12px;">

                                                <h6 class="mb-0"
                                                    style="font-size:14px; font-weight:700; color:#B45309; display:flex; align-items:center; gap:8px;">
                                                    <i class="fas fa-folder-open"></i> {{ $groupName }}
                                                </h6>

                                                {{-- Pilih Semua per Kelompok --}}
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        class="custom-control-input edit-group-checkbox"
                                                        id="edit_group_{{ Str::slug($groupName) }}"
                                                        style="width:16px; height:16px; cursor:pointer;">
                                                    <label class="custom-control-label"
                                                        for="edit_group_{{ Str::slug($groupName) }}"
                                                        style="font-size:13px; color:#64748B; cursor:pointer;">
                                                        Semua
                                                    </label>
                                                </div>

                                            </div>

                                            {{-- Daftar Permission --}}
                                            @foreach ($groupPermissions as $permission)
                                                <div class="custom-control custom-checkbox mb-2">
                                                    <input type="checkbox"
                                                        class="custom-control-input edit-permission-checkbox edit-group-{{ Str::slug($groupName) }}"
                                                        name="permissions[]" value="{{ $permission->name }}"
                                                        id="edit_permission_{{ $permission->id }}"
                                                        style="width:16px; height:16px; cursor:pointer;">
                                                    <label class="custom-control-label"
                                                        for="edit_permission_{{ $permission->id }}"
                                                        style="font-size:14px; color:#334155; cursor:pointer;">
                                                        <strong>
                                                            {{ $permission->label ?? Str::headline(Str::after($permission->name, '.')) }}
                                                        </strong>
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                @endforeach

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
                            <i class="fas fa-save"></i> Update Operator
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    
    <script>
        $(document).ready(function() {
            // 🟢 AJAX Tambah User
            $("#formTambahUser").on("submit", function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const submitButton = $(form).find('button[type="submit"]');

                $.ajax({
                    url: form.action,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    beforeSend: function() {
                        // Nonaktifkan tombol agar tidak terjadi submit berulang
                        submitButton
                            .prop("disabled", true)
                            .html(
                                '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'
                            );

                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang menambahkan operator",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,

                            didOpen: function() {
                                Swal.showLoading();
                            }
                        });
                    },

                    success: function(response) {
                        Swal.close();

                        if (response.status === true) {
                            // Reset seluruh input form
                            form.reset();

                            // Hapus semua checkbox permission yang terpilih
                            $(form)
                                .find(
                                    '.permission-checkbox, .pilih-grup, #pilihSemuaPermission'
                                )
                                .prop("checked", false);

                            // Tutup modal
                            $("#modalTambahUser").modal("hide");

                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message ||
                                    "Operator berhasil ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {
                                window.location.reload();
                            });

                            return;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message ||
                                "Data operator gagal ditambahkan."
                        });
                    },

                    error: function(xhr) {
                        Swal.close();

                        let errorMessages = "";

                        /*
                        |--------------------------------------------------------------------------
                        | Error Validasi Laravel
                        |--------------------------------------------------------------------------
                        |
                        | Laravel biasanya mengirim:
                        |
                        | {
                        |     message: "...",
                        |     errors: {
                        |         name: ["Nama wajib diisi."],
                        |         email: ["Email sudah digunakan."]
                        |     }
                        | }
                        |
                        */

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {
                            errorMessages = "<ul class='text-left mb-0'>";

                            $.each(
                                xhr.responseJSON.errors,
                                function(key, messages) {
                                    $.each(
                                        messages,
                                        function(index, message) {
                                            errorMessages +=
                                                "<li>" +
                                                message +
                                                "</li>";
                                        }
                                    );
                                }
                            );

                            errorMessages += "</ul>";
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Error dari Response Controller
                        |--------------------------------------------------------------------------
                        */
                        else if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {
                            errorMessages =
                                "<p class='mb-0'>" +
                                xhr.responseJSON.message +
                                "</p>";
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Error Server
                        |--------------------------------------------------------------------------
                        */
                        else {
                            errorMessages =
                                "<p class='mb-0'>" +
                                "Terjadi kesalahan pada server. " +
                                "Silakan coba kembali." +
                                "</p>";
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal Menambahkan Operator",
                            html: errorMessages,
                            confirmButtonText: "Tutup"
                        });
                    },

                    complete: function() {
                        // Aktifkan kembali tombol submit
                        submitButton
                            .prop("disabled", false)
                            .html(
                                '<i class="fas fa-save"></i> Simpan'
                            );
                    }
                });

            });

            // 🟢 AJAX Hapus User
            $(document).on("click", ".btn-hapus", function() {
                let id = $(this).data("id");
                let url = `/admin/user/${id}`;

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
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function(res) {
                                Swal.fire("Berhasil!", res.message, "success");
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire("Gagal!", xhr.responseJSON?.message ||
                                    "Terjadi kesalahan", "error");
                            }
                        });

                    }
                });
            });

            // 🟢 AJAX Edit User - Ambil Data
            $(document).on("click", ".btn-edit", function() {
                const id = $(this).data("id");

                $.ajax({
                    url: `/admin/user/${id}/edit`,
                    type: "GET",
                    dataType: "json",

                    beforeSend: function() {
                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang memuat data operator",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },

                    success: function(response) {
                        Swal.close();

                        /*
                        |--------------------------------------------------------------------------
                        | Validasi Response
                        |--------------------------------------------------------------------------
                        */

                        if (!response.status) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: response.message ||
                                    "Data operator tidak ditemukan."
                            });

                            return;
                        }

                        const data = response.data;

                        /*
                        |--------------------------------------------------------------------------
                        | Set URL Update
                        |--------------------------------------------------------------------------
                        */

                        $("#formEditUser").attr(
                            "action",
                            `/admin/user/${data.id}`
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Isi Data User
                        |--------------------------------------------------------------------------
                        */

                        $("#edit_id").val(data.id);

                        $("#edit_name").val(
                            data.name ?? ""
                        );

                        $("#edit_email").val(
                            data.email ?? ""
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Isi Role
                        |--------------------------------------------------------------------------
                        */

                        $("#edit_role").val(
                            data.role ?? ""
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Kosongkan Password
                        |--------------------------------------------------------------------------
                        */

                        $("#edit_password").val("");

                        /*
                        |--------------------------------------------------------------------------
                        | Reset Semua Permission Modal Edit
                        |--------------------------------------------------------------------------
                        */

                        const permissionCheckboxes = $(
                            "#formEditUser .edit-permission-checkbox"
                        );

                        permissionCheckboxes.prop(
                            "checked",
                            false
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Ambil Permission User
                        |--------------------------------------------------------------------------
                        |
                        | Prioritas:
                        | 1. response.permissions
                        | 2. response.data.permissions
                        |
                        */

                        const userPermissions =
                            response.permissions ??
                            data.permissions ?? [];

                        /*
                        |--------------------------------------------------------------------------
                        | Debug Permission
                        |--------------------------------------------------------------------------
                        */

                        console.log(
                            "Permission user:",
                            userPermissions
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Centang Permission User
                        |--------------------------------------------------------------------------
                        */

                        userPermissions.forEach(
                            function(permission) {

                                /*
                                |--------------------------------------------------------------------------
                                | Jika permission berupa object
                                |--------------------------------------------------------------------------
                                |
                                | Contoh:
                                | {
                                |     id: 1,
                                |     name: "penduduk.index"
                                | }
                                |
                                */

                                const permissionName =
                                    typeof permission === "object" ?
                                    permission.name :
                                    permission;

                                /*
                                |--------------------------------------------------------------------------
                                | Cari Checkbox Berdasarkan Value
                                |--------------------------------------------------------------------------
                                */

                                permissionCheckboxes
                                    .filter(function() {

                                        return String(
                                            $(this).val()
                                        ) === String(
                                            permissionName
                                        );

                                    })
                                    .prop(
                                        "checked",
                                        true
                                    );
                            }
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Update Checkbox Pilih Semua
                        |--------------------------------------------------------------------------
                        */

                        const totalPermissions =
                            permissionCheckboxes.length;

                        const checkedPermissions =
                            permissionCheckboxes.filter(
                                ":checked"
                            ).length;

                        $("#edit_select_all_permissions")
                            .prop(
                                "checked",
                                totalPermissions > 0 &&
                                totalPermissions ===
                                checkedPermissions
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | Update Checkbox Semua Per Kelompok
                        |--------------------------------------------------------------------------
                        */

                        $(".edit-group-checkbox").each(
                            function() {

                                const groupCheckbox =
                                    $(this);

                                /*
                                |--------------------------------------------------------------------------
                                | Ambil Nama Group Dari ID
                                |--------------------------------------------------------------------------
                                |
                                | Contoh:
                                | edit_group_penduduk
                                |
                                | Menjadi:
                                | penduduk
                                |
                                */

                                const groupSlug =
                                    groupCheckbox
                                    .attr("id")
                                    .replace(
                                        "edit_group_",
                                        ""
                                    );

                                const groupPermissions =
                                    $(
                                        `#formEditUser .edit-group-${groupSlug}`
                                    );

                                const totalGroupPermissions =
                                    groupPermissions.length;

                                const checkedGroupPermissions =
                                    groupPermissions
                                    .filter(":checked")
                                    .length;

                                groupCheckbox.prop(
                                    "checked",
                                    totalGroupPermissions > 0 &&
                                    totalGroupPermissions ===
                                    checkedGroupPermissions
                                );
                            }
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | Tampilkan Modal
                        |--------------------------------------------------------------------------
                        */

                        $("#modalEditUser").modal("show");
                    },

                    error: function(xhr) {
                        Swal.close();

                        const message =
                            xhr.responseJSON?.message ||
                            "Gagal memuat data dari server.";

                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: message
                        });
                    }
                });
            });


            // 🟢 AJAX Update User
            $("#formEditUser").on("submit", function(e) {
                e.preventDefault();

                const form = this;

                const id = $("#edit_id").val();

                if (!id) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: "ID operator tidak ditemukan."
                    });

                    return;
                }

                const formData = new FormData(form);

                $.ajax({
                    url: `/admin/user/${id}`,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {
                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang memperbarui data operator",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },

                    success: function(response) {
                        Swal.close();

                        // Controller mengirim "status", bukan "success"
                        if (response.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message ||
                                    "Data operator berhasil diperbarui.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {

                                $("#modalEditUser").modal("hide");

                                form.reset();

                                location.reload();
                            });

                            return;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message ||
                                "Data operator gagal diperbarui."
                        });
                    },

                    error: function(xhr) {
                        Swal.close();

                        const response =
                            xhr.responseJSON;

                        const errors =
                            response?.errors;

                        let errorMessages = "";

                        if (errors) {
                            $.each(
                                errors,
                                function(key, value) {
                                    errorMessages +=
                                        `<li>${value[0]}</li>`;
                                }
                            );
                        } else {
                            errorMessages =
                                `<li>${
                        response?.message ||
                        "Terjadi kesalahan server."
                    }</li>`;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan!",
                            html: `
                    <ul style="text-align: left;">
                        ${errorMessages}
                    </ul>
                `
                        });
                    }
                });
            });


            // ============================================================
            // 🟢 AJAX Pagination & Search — Operator
            // ============================================================

            function loadOperator(page = 1, search = '') {
                let tbody = $('#userTable tbody');

                // 🔹 Loading state
                tbody.html(`
        <tr>
            <td colspan="5" style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                <i class="fas fa-spinner fa-spin fa-2x" style="opacity:0.4; display:block; margin-bottom:10px;"></i>
                <span style="font-size:15px; font-weight:500;">Memuat data operator...</span>
            </td>
        </tr>
    `);
                $('#paginationLinks').empty();

                $.ajax({
                    url: "{{ route('admin.user.paginate') }}",
                    type: "GET",
                    data: {
                        page: page,
                        search: search
                    },

                    success: function(response) {
                        tbody.empty();

                        // ── Kosong ──
                        if (!response.data || response.data.length === 0) {
                            tbody.html(`
                    <tr>
                        <td colspan="5" style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                            <i class="fas fa-users-cog fa-2x" style="opacity:0.3; display:block; margin-bottom:10px;"></i>
                            <span style="font-size:15px; font-weight:500;">Belum ada data operator</span>
                        </td>
                    </tr>
                `);
                            $('#paginationLinks').empty();
                            return;
                        }

                        // ── Render baris data ──
                        response.data.forEach(function(data, index) {
                            let rowBg = index % 2 !== 0 ? '#F8FAFC' : '#fff';

                            // Badge level warna dinamis
                            let levelColor = {
                                bg: '#F8FAFC',
                                color: '#475569',
                                border: '#CBD5E1'
                            };
                            let levelLower = (data.level ?? '').toLowerCase();
                            if (levelLower === 'admin') {
                                levelColor = {
                                    bg: '#EEF2FF',
                                    color: '#3730A3',
                                    border: '#C7D2FE'
                                };
                            } else if (levelLower === 'operator') {
                                levelColor = {
                                    bg: '#F0FDF4',
                                    color: '#15803D',
                                    border: '#86EFAC'
                                };
                            }

                            tbody.append(`
                    <tr style="background:${rowBg}; transition:background .15s;"
                        onmouseover="this.style.background='#EEF2FF'"
                        onmouseout="this.style.background='${rowBg}'">

                        <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155;
                                   border:1.5px solid #CBD5E1; text-align:center;">
                            ${response.from + index}
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#EEF2FF;
                                            border:2px solid #C7D2FE; display:flex; align-items:center;
                                            justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-user" style="font-size:15px; color:#6366F1;"></i>
                                </div>
                                <span style="font-size:15px; font-weight:600; color:#0F172A;">
                                    ${data.name}
                                </span>
                            </div>
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                            <span style="display:inline-flex; align-items:center; gap:6px; font-size:14px; color:#334155;">
                                <i class="fas fa-envelope" style="color:#6777ef; font-size:12px;"></i>
                                ${data.email}
                            </span>
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                            <span style="display:inline-block; background:${levelColor.bg}; color:${levelColor.color};
                                         font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px;
                                         border:1.5px solid ${levelColor.border}; text-transform:capitalize;
                                         letter-spacing:0.3px;">
                                ${data.level ?? '-'}
                            </span>
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                <button type="button" class="btn-edit" data-id="${data.id}" title="Edit"
                                    style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B;
                                           background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer;
                                           transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                    onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                    onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-hapus" data-id="${data.id}" title="Hapus"
                                    style="width:36px; height:36px; border-radius:8px; border:1.5px solid #EF4444;
                                           background:#FFF0F0; color:#B91C1C; font-size:15px; cursor:pointer;
                                           transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                    onmouseover="this.style.background='#EF4444';this.style.color='#fff'"
                                    onmouseout="this.style.background='#FFF0F0';this.style.color='#B91C1C'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
                        });

                        // ── Render Pagination ──
                        renderOperatorPagination(response, search);
                    },

                    error: function() {
                        tbody.html(`
                <tr>
                    <td colspan="5" style="padding:48px; text-align:center; color:#EF4444; border:1.5px solid #CBD5E1;">
                        <i class="fas fa-exclamation-triangle fa-2x" style="display:block; margin-bottom:10px;"></i>
                        <span style="font-size:15px; font-weight:500;">Terjadi kesalahan saat memuat data operator.</span>
                    </td>
                </tr>
            `);
                    }
                });
            }

            // ============================================================
            // 🔹 Render Pagination — max 5 nomor, prev/next chevron
            // ============================================================
            function renderOperatorPagination(response, search) {
                let paginationLinks = $('#paginationLinks');
                paginationLinks.empty();

                if (response.last_page <= 1) return;

                let cur = response.current_page;
                let last = response.last_page;

                let startPage = Math.max(cur - 2, 1);
                let endPage = Math.min(startPage + 4, last);
                if (endPage - startPage < 4) startPage = Math.max(endPage - 4, 1);

                // Tombol Prev
                paginationLinks.append(`
        <li class="page-item ${cur === 1 ? 'disabled' : ''}">
            <a class="page-link pagination-link-operator" href="#"
               data-page="${cur - 1}"
               style="border-radius:8px; border:1.5px solid #E2E8F0; color:#6777ef; font-weight:600; margin:0 2px;">
                <i class="fas fa-chevron-left" style="font-size:11px;"></i>
            </a>
        </li>
    `);

                // Nomor halaman (max 5)
                for (let i = startPage; i <= endPage; i++) {
                    let isActive = cur === i;
                    paginationLinks.append(`
            <li class="page-item ${isActive ? 'active' : ''}">
                <a class="page-link pagination-link-operator" href="#"
                   data-page="${i}"
                   style="border-radius:8px; margin:0 2px; font-weight:600;
                          border:1.5px solid ${isActive ? '#6777ef' : '#E2E8F0'};
                          background:${isActive ? '#6777ef' : '#fff'};
                          color:${isActive ? '#fff' : '#334155'};">
                    ${i}
                </a>
            </li>
        `);
                }

                // Tombol Next
                paginationLinks.append(`
        <li class="page-item ${cur === last ? 'disabled' : ''}">
            <a class="page-link pagination-link-operator" href="#"
               data-page="${cur + 1}"
               style="border-radius:8px; border:1.5px solid #E2E8F0; color:#6777ef; font-weight:600; margin:0 2px;">
                <i class="fas fa-chevron-right" style="font-size:11px;"></i>
            </a>
        </li>
    `);
            }

            // ============================================================
            // 🔹 Event Listeners
            // ============================================================

            // Load awal
            loadOperator();

            // Pencarian dengan debounce 400ms
            let searchTimerOperator;
            $('#searchOperator').on('keyup', function() {
                clearTimeout(searchTimerOperator);
                let search = $(this).val();
                searchTimerOperator = setTimeout(function() {
                    loadOperator(1, search);
                }, 400);
            });

            // Klik nomor halaman
            $(document).on('click', '.pagination-link-operator', function(e) {
                e.preventDefault();
                let page = parseInt($(this).data('page'));
                let search = $('#searchOperator').val();
                if (page > 0) loadOperator(page, search);
            });
        });
    </script>


@endsection
