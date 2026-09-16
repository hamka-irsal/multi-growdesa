@extends('admin.layouts.app')

@section('page-title', 'Data-Aparat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-map-marker-alt" style="color:#2E7D32;"></i> Data Dusun
                </h1>

                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                    </div>

                    <div class="breadcrumb-item">
                        <a href="{{ route('admin.dusun.index') }}">Data Dusun</a>
                    </div>

                    <div class="breadcrumb-item">Dusun</div>
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
                                List Data Dusun Desa
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahDusun"
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

                                <table class="table mb-0" id="dusunTable" style="border-collapse:collapse; width:100%;">

                                    <thead>
                                        <tr style="background:#F8FAFC;">

                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No
                                            </th>

                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Dusun
                                            </th>

                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Kepdus
                                            </th>

                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                No. WhatsApp
                                            </th>

                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($dusun as $index => $data)
                                            @php
                                                $rowBg = $loop->even ? '#F8FAFC' : '#fff';
                                            @endphp

                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                {{-- No --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">

                                                    {{ $index + 1 }}

                                                </td>

                                                {{-- Nama Dusun --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">

                                                    {{ $data->nama_dusun }}

                                                </td>

                                                {{-- Nama Kepdus --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; color:#334155; border:1.5px solid #CBD5E1;">

                                                    {{ $data->nama_kepdus }}

                                                </td>

                                                {{-- No WhatsApp --}}
                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">

                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data->no_wa) }}"
                                                        target="_blank"
                                                        style="color:#2E7D32; font-weight:600; text-decoration:none;">

                                                        <i class="fab fa-whatsapp" style="margin-right:5px;"></i>

                                                        {{ $data->no_wa }}

                                                    </a>

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


    {{-- Modal Tambah Dusun --}}
    <div class="modal fade" id="modalTambahDusun" tabindex="-1" role="dialog" aria-labelledby="modalTambahDusunLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">

                    <h5 class="modal-title" id="modalTambahDusunLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">

                        <i class="fas fa-map-marker-alt"></i> Tambah Dusun

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <form action="{{ route('admin.dusun.store') }}" method="POST" id="formTambahDusun">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC;">

                        <div class="row">

                            {{-- Kolom kiri --}}
                            <div class="col-md-6">

                                {{-- Nama Dusun --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label for="nama_dusun"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-map-marker-alt" style="color:#2E7D32;"></i>
                                        Nama Dusun

                                    </label>

                                    <input type="text" name="nama_dusun" id="nama_dusun"
                                        placeholder="Masukkan Nama Dusun" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>

                                {{-- Nama Kepdus --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label for="nama_kepdus"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-user-tie" style="color:#2E7D32;"></i>
                                        Nama Kepala Dusun

                                    </label>

                                    <input type="text" name="nama_kepdus" id="nama_kepdus"
                                        placeholder="Masukkan Nama Kepala Dusun" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>

                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">

                                {{-- No WhatsApp --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label for="no_wa"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fab fa-whatsapp" style="color:#2E7D32;"></i>
                                        Nomor WhatsApp

                                    </label>

                                    <input type="text" name="no_wa" id="no_wa"
                                        placeholder="Contoh: 628xxxxxxxxxx" required maxlength="20"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                        Gunakan format 628xxxxxxxxxx agar dapat digunakan untuk WhatsApp.
                                    </small>

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


    {{-- Modal Edit Dusun --}}
    <div class="modal fade" id="modalEditDusun" tabindex="-1" role="dialog" aria-labelledby="modalEditDusunLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">

                    <h5 class="modal-title" id="modalEditDusunLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">

                        <i class="fas fa-edit"></i> Edit Dusun

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <form method="POST" id="formEditDusun">

                    @csrf

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_dusun_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB;">

                        <div class="row">

                            {{-- Kolom kiri --}}
                            <div class="col-md-6">

                                {{-- Nama Dusun --}}
                                <div class="form-group" style="margin-bottom:20px;">

                                    <label for="edit_nama_dusun"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-map-marker-alt" style="color:#F59E0B;"></i>

                                        Nama Dusun

                                    </label>

                                    <input type="text" name="nama_dusun" id="edit_nama_dusun" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>

                                {{-- Nama Kepdus --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label for="edit_nama_kepdus"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fas fa-user-tie" style="color:#F59E0B;"></i>

                                        Nama Kepala Dusun

                                    </label>

                                    <input type="text" name="nama_kepdus" id="edit_nama_kepdus" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                </div>

                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">

                                {{-- No WhatsApp --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label for="edit_no_wa"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">

                                        <i class="fab fa-whatsapp" style="color:#F59E0B;"></i>

                                        Nomor WhatsApp

                                    </label>

                                    <input type="text" name="no_wa" id="edit_no_wa" required maxlength="20"
                                        placeholder="Contoh: 628xxxxxxxxxx"
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                        Pastikan nomor WhatsApp masih aktif.
                                    </small>

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

                            <i class="fas fa-save"></i> Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        // =====================================================
        // AJAX MODAL TAMBAH DUSUN
        // =====================================================
        $(document).ready(function() {

            $("#formTambahDusun").submit(function(e) {
                e.preventDefault(); // Mencegah reload halaman

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.dusun.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang memproses data',
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
                                text: 'Data dusun berhasil ditambahkan.',
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
                                    'Terjadi kesalahan saat menambahkan data dusun.',
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
                                errorMessages += `<li>${value[0]}</li>`;
                            });

                            errorMessage =
                                `<ul style="text-align: left;">${errorMessages}</ul>`;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            html: errorMessage,
                        });
                    }
                });
            });


            // =====================================================
            // VALIDASI INPUT FORM TAMBAH DUSUN
            // =====================================================
            $("#formTambahDusun").on("submit", function(event) {

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
        // AJAX HAPUS DATA DUSUN
        // =====================================================
        $(document).on("click", ".btn-hapus", function() {

            let id = $(this).data("id");
            let url = `/admin/dusun/${id}`;

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
                                text: "Terjadi kesalahan saat menghapus data dusun.",
                                icon: "error",
                                timer: 2000,
                                showConfirmButton: false
                            });

                        }
                    });
                }
            });
        });


        // =====================================================
        // AJAX EDIT DUSUN
        // =====================================================
        $(document).on("click", ".btn-edit", function() {

            let id = $(this).data("id");

            $.ajax({
                url: `/admin/dusun/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    if (response.success) {

                        let data = response.data;

                        // Isi action form edit
                        $("#formEditDusun").attr(
                            "action",
                            `/admin/dusun/${id}`
                        );

                        // Isi ID dusun
                        $("#edit_dusun_id").val(data.id);

                        // Isi nama dusun
                        $("#edit_nama_dusun").val(data.nama_dusun);

                        // Isi nama kepala dusun
                        $("#edit_nama_kepdus").val(data.nama_kepdus);

                        // Isi nomor WhatsApp
                        $("#edit_no_wa").val(data.no_wa);

                        // Tampilkan modal edit
                        $("#modalEditDusun").modal("show");

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data dusun tidak ditemukan.",
                        });

                    }
                },

                error: function(xhr) {

                    console.error("Error:", xhr.responseText);

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data dusun dari server.",
                    });

                },
            });
        });


        // =====================================================
        // AJAX SUBMIT EDIT DUSUN
        // =====================================================
        $("#formEditDusun").submit(function(e) {

            e.preventDefault();

            let formData = new FormData(this);
            let id = $("#edit_dusun_id").val();

            $.ajax({
                url: `/admin/dusun/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                headers: {
                    "X-HTTP-Method-Override": "PUT"
                },

                success: function(response) {

                    if (response.success) {

                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data dusun berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,

                        }).then(() => {

                            $("#modalEditDusun").modal("hide");

                            $("#formEditDusun")[0].reset();

                            location.reload();

                        });

                    } else {

                        Swal.fire({
                            title: "Gagal!",
                            text: "Data dusun gagal diperbarui!",
                            icon: "error",
                        });

                    }
                },

                error: function(xhr) {

                    let errors = xhr.responseJSON?.errors;
                    let errorMessages = "";

                    if (errors) {

                        $.each(errors, function(key, value) {
                            errorMessages += `<li>${value[0]}</li>`;
                        });

                    } else {

                        errorMessages =
                            "<li>Terjadi kesalahan saat memperbarui data.</li>";
                    }

                    Swal.fire({
                        title: "Terjadi Kesalahan!",
                        html: `<ul style='text-align: left;'>${errorMessages}</ul>`,
                        icon: "error",
                    });
                },
            });
        });

        $(document).ready(function() {

            let searchTimer = null;

            // =========================================================
            // KONFIGURASI
            // =========================================================

            const AJAX_URL = "{{ route('admin.dusun.paginate') }}";
            const SEARCH_DELAY = 400;

            const $tbody = $('#dusunTable tbody');
            const $pagination = $('#paginationLinks');
            const $searchInput = $('#searchInput');


            // =========================================================
            // LOAD DATA DUSUN
            // =========================================================

            function loadDusun(page = 1, query = '') {

                $.ajax({
                    url: AJAX_URL,
                    type: 'GET',

                    data: {
                        page: page,
                        search: query
                    },

                    success: function(response) {

                        renderDusun(response);
                        renderPagination(response, query);

                    },

                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat data dusun.'
                        });

                    }
                });
            }


            // =========================================================
            // RENDER DATA DUSUN
            // =========================================================

            function renderDusun(response) {

                $tbody.empty();

                if (!response.data || response.data.length === 0) {
                    renderEmptyData();
                    return;
                }

                response.data.forEach(function(data, index) {

                    const rowNumber = response.from + index;

                    $tbody.append(
                        createDusunRow(data, rowNumber, index)
                    );

                });
            }


            // =========================================================
            // EMPTY DATA
            // =========================================================

            function renderEmptyData() {

                $tbody.html(`
            <tr>
                <td colspan="5"
                    style="
                        padding:48px;
                        text-align:center;
                        color:#94A3B8;
                        border:1.5px solid #CBD5E1;
                    "
                >
                    <i class="fas fa-map-marker-alt fa-2x mb-3"
                       style="
                           opacity:0.3;
                           display:block;
                       "
                    ></i>

                    <span style="
                        font-size:15px;
                        font-weight:500;
                    ">
                        Data dusun tidak ditemukan
                    </span>
                </td>
            </tr>
        `);
            }


            // =========================================================
            // CREATE ROW DUSUN
            // =========================================================

            function createDusunRow(data, rowNumber, index) {

                const rowBackground = index % 2 === 1 ?
                    '#F8FAFC' :
                    '#FFFFFF';

                const whatsappNumber = formatWhatsAppNumber(data.no_wa);

                return `
            <tr
                style="
                    background:${rowBackground};
                    transition:background .15s;
                "
                onmouseover="this.style.background='#EEF2FF'"
                onmouseout="this.style.background='${rowBackground}'"
            >

                <!-- NO -->
                <td style="
                    padding:14px 18px;
                    font-size:15px;
                    font-weight:700;
                    color:#334155;
                    border:1.5px solid #CBD5E1;
                    text-align:center;
                ">
                    ${rowNumber}
                </td>


                <!-- NAMA DUSUN -->
                <td style="
                    padding:14px 18px;
                    font-size:15px;
                    font-weight:600;
                    color:#0F172A;
                    border:1.5px solid #CBD5E1;
                ">
                    ${data.nama_dusun}
                </td>


                <!-- NAMA KEPALA DUSUN -->
                <td style="
                    padding:14px 18px;
                    font-size:15px;
                    font-weight:600;
                    color:#334155;
                    border:1.5px solid #CBD5E1;
                ">
                    ${data.nama_kepdus}
                </td>


                <!-- WHATSAPP -->
                <td style="
                    padding:14px 18px;
                    border:1.5px solid #CBD5E1;
                ">
                    <a
                        href="https://wa.me/${whatsappNumber}"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="
                            color:#2E7D32;
                            font-weight:600;
                            text-decoration:none;
                        "
                    >
                        <i class="fab fa-whatsapp"
                           style="margin-right:5px;">
                        </i>

                        ${data.no_wa || '-'}
                    </a>
                </td>


                <!-- AKSI -->
                <td style="
                    padding:14px 18px;
                    border:1.5px solid #CBD5E1;
                    text-align:center;
                ">
                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        gap:6px;
                    ">

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
            // FORMAT NOMOR WHATSAPP
            // =========================================================

            function formatWhatsAppNumber(phoneNumber) {

                let number = String(phoneNumber || '')
                    .replace(/\D/g, '');

                if (number.startsWith('0')) {
                    number = '62' + number.substring(1);
                }

                return number;
            }


            // =========================================================
            // RENDER PAGINATION
            // =========================================================

            function renderPagination(response, query) {

                $pagination.empty();

                if (response.last_page <= 1) {
                    return;
                }

                renderPreviousButton(response, query);
                renderPageNumbers(response, query);
                renderNextButton(response, query);
            }


            // =========================================================
            // PREVIOUS BUTTON
            // =========================================================

            function renderPreviousButton(response, query) {

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

            function renderPageNumbers(response, query) {

                for (
                    let page = 1; page <= response.last_page; page++
                ) {

                    const activeClass =
                        response.current_page === page ?
                        'active' :
                        '';

                    $pagination.append(`
                <li class="page-item ${activeClass}">

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

            function renderNextButton(response, query) {

                if (response.current_page >= response.last_page) {
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
            // SEARCH DUSUN
            // =========================================================

            $searchInput.on('input', function() {

                const query = $(this).val().trim();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {

                    loadDusun(1, query);

                }, SEARCH_DELAY);
            });


            // =========================================================
            // PAGINATION CLICK
            // =========================================================

            $(document).on('click', '.pagination-link', function(e) {

                e.preventDefault();

                const page = $(this).data('page');
                const query = $searchInput.val().trim();

                loadDusun(page, query);
            });


            // =========================================================
            // INITIAL LOAD
            // =========================================================

            loadDusun();

        });
    </script>
@endsection
