@extends('admin.layouts.app')

@section('page-title', 'Data-TTD-Surat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-signature" style="color:#2E7D32;"></i> Data TTD Surat
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.persetujuan.index') }}">Data Surat</a></div>
                    <div class="breadcrumb-item">Data Persetujuan Surat</div>
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
                                List Data TTD Surat
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahPersetujuan"
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
                                                Jabatan</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                TTD</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($persetujuan as $index => $data)
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
                                                    {{ $data->jenisSurat->nama_jenis ?? '-' }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->jabatan ?? '-' }}
                                                    </span>
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    @if ($data->file_ttd)
                                                        <img src="{{ asset('storage/' . $data->file_ttd) }}" alt="Foto TTD"
                                                            width="100"
                                                            style="border-radius:8px; border:1.5px solid #E2E8F0;">
                                                    @else
                                                        <span style="color:#94A3B8; font-size:14px; font-weight:500;">
                                                            -
                                                        </span>
                                                    @endif
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

    {{-- Modal Tambah Persetujuan --}}
    <div class="modal fade" id="modalTambahPersetujuan" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahPersetujuanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahPersetujuanLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-check"></i> Tambah TTD Surat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.persetujuan.store') }}" method="POST" id="formTambahPersetujuan"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC;">

                        {{-- Jenis Surat --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-file-alt" style="color:#2E7D32;"></i> Jenis Surat
                            </label>
                            <select name="jenis_surat_id" id="jenis_surat_id" required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">Pilih Jenis Surat</option>
                                @foreach ($jenisSuratList as $surat)
                                    <option value="{{ $surat->id }}">{{ $surat->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Penandatangan --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-user-check" style="color:#2E7D32;"></i> Penandatangan
                            </label>
                            <select name="aparat_id" id="aparat_id" required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">Pilih Penandatangan</option>
                                @foreach ($aparatList as $aparat)
                                    <option value="{{ $aparat->id }}">{{ $aparat->nama }} - {{ $aparat->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- File TTD --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-signature" style="color:#2E7D32;"></i> File Tanda Tangan
                            </label>
                            <input type="file" name="file_ttd" id="file_ttd" accept="image/*" required
                                style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
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


    {{-- Modal Edit Persetujuan --}}
    <div class="modal fade" id="modalEditPersetujuan" tabindex="-1" role="dialog"
        aria-labelledby="modalEditPersetujuanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditPersetujuanLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-check"></i> Edit Persetujuan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" id="formEditPersetujuan">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id_persetujuan">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB;">

                        {{-- Jenis Surat --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-file-alt" style="color:#F59E0B;"></i> Jenis Surat
                            </label>
                            <select name="jenis_surat_id" id="edit_jenis_surat_id" required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">Pilih Jenis Surat</option>
                                @foreach ($jenisSuratList as $surat)
                                    <option value="{{ $surat->id }}">{{ $surat->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Penandatangan --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-user-check" style="color:#F59E0B;"></i> Penandatangan
                            </label>
                            <select name="aparat_id" id="edit_aparat_id" required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">Pilih Penandatangan</option>
                                @foreach ($aparatList as $aparat)
                                    <option value="{{ $aparat->id }}">{{ $aparat->nama }} - {{ $aparat->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- File TTD --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-signature" style="color:#F59E0B;"></i> File Tanda Tangan
                                <small style="font-size:13px; font-weight:500; color:#94A3B8;">(Kosongkan jika tidak
                                    diganti)</small>
                            </label>
                            <input type="file" name="file_ttd" id="edit_file_ttd" accept="image/*"
                                style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">

                            <div style="margin-top:12px;">
                                <img id="edit_preview_ttd_img" src="#" alt="Preview TTD"
                                    style="
                                    max-width:200px;
                                    display:none;
                                    border-radius:10px;
                                    border:1.5px solid #E2E8F0;
                                    background:#fff;
                                    padding:8px;
                                ">
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
        // AJAX Tambah Persetujuan
        $(document).ready(function() {

            $("#formTambahPersetujuan").on("submit", function(e) {

                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Validasi sederhana
                let jenisSurat = $("#jenis_surat_id").val();
                let aparatId = $("#aparat_id").val();
                let fileTtd = $("#file_ttd")[0].files.length;

                if (!jenisSurat) {
                    Swal.fire({
                        icon: "warning",
                        title: "Perhatian!",
                        text: "Silakan pilih jenis surat."
                    });
                    return;
                }

                if (!aparatId) {
                    Swal.fire({
                        icon: "warning",
                        title: "Perhatian!",
                        text: "Silakan pilih penandatangan."
                    });
                    return;
                }

                if (!fileTtd) {
                    Swal.fire({
                        icon: "warning",
                        title: "Perhatian!",
                        text: "Silakan pilih file tanda tangan."
                    });
                    return;
                }

                $.ajax({

                    url: $(form).attr("action"),

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    beforeSend: function() {

                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang menyimpan data persetujuan surat.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,

                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                    },

                    success: function(response) {

                        if (response.success) {

                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message ||
                                    "Persetujuan surat berhasil ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                $("#modalTambahPersetujuan").modal("hide");

                                form.reset();

                                location.reload();

                            });

                        } else {

                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: response.message ||
                                    "Terjadi kesalahan saat menambahkan persetujuan surat."
                            });

                        }
                    },

                    error: function(xhr) {

                        console.error("Status:", xhr.status);
                        console.error("Response:", xhr.responseText);

                        let message =
                            "Terjadi kesalahan saat mengirim data.";

                        // Validasi Laravel 422
                        if (xhr.status === 422 && xhr.responseJSON) {

                            if (xhr.responseJSON.errors) {

                                let errors = xhr.responseJSON.errors;

                                message = Object.values(errors)
                                    .flat()
                                    .join("<br>");

                            } else if (xhr.responseJSON.message) {

                                message = xhr.responseJSON.message;

                            }

                        }

                        // Error server 500
                        else if (
                            xhr.status === 500 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message = xhr.responseJSON.message;

                        }

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            html: message
                        });
                    }

                });

            });

        });

        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/persetujuan/${id}`;

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

        // 🟡 AJAX Edit Persetujuan
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/persetujuan/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    if (response.success) {

                        let data = response.data;

                        // Action form
                        $("#formEditPersetujuan").attr(
                            "action",
                            `/admin/persetujuan/${id}`
                        );

                        // ID
                        $("#edit_id_persetujuan").val(data.id);

                        // Jenis surat
                        $("#edit_jenis_surat_id").val(data.jenis_surat_id);

                        // Penandatangan
                        $("#edit_aparat_id").val(data.aparat_id);

                        // Preview TTD
                        if (data.file_ttd_url) {

                            $("#edit_preview_ttd_img")
                                .attr("src", data.file_ttd_url)
                                .show();

                        } else {

                            $("#edit_preview_ttd_img")
                                .hide();
                        }

                        // Tampilkan modal
                        $("#modalEditPersetujuan").modal("show");

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: response.message || "Data persetujuan tidak ditemukan.",
                        });

                    }
                },

                error: function(xhr) {

                    console.error(xhr.responseText);

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data dari server.",
                    });
                }
            });
        });

        // 🟡 AJAX Submit Edit Persetujuan
        $("#formEditPersetujuan").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let id = $("#edit_id_persetujuan").val();

            $.ajax({
                url: `/admin/persetujuan/${id}`,
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
                            text: "Persetujuan berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            $("#modalEditPersetujuan").modal("hide");
                            $("#formEditPersetujuan")[0].reset();
                            location
                                .reload(); // Atau datatable.ajax.reload() kalau pakai datatable
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

        // Ajax Persetujuan Surat (Search + Paginate digabung)
        $(document).ready(function() {

            let searchTimer = null;

            function loadPersetujuan(page = 1, query = '') {

                $.ajax({
                    url: "{{ route('admin.persetujuan.paginate') }}",
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
                            <td colspan="5"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-signature fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                            return;
                        }

                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let ttdHtml = data.file_ttd ?
                                `<img src="/storage/${data.file_ttd}" alt="Foto TTD" width="100"
                            style="border-radius:8px; border:1.5px solid #E2E8F0;">` :
                                `<span style="color:#94A3B8; font-size:14px; font-weight:500;">-</span>`;

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.jenis_surat?.nama_jenis ?? '-'}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${data.jabatan ?? '-'}
                                </span>
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                ${ttdHtml}
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
                            text: 'Terjadi kesalahan saat memuat data persetujuan surat.'
                        });
                    }
                });
            }

            // Load awal
            loadPersetujuan();

            // Pencarian (debounce, tetap lewat loadPersetujuan yang sama)
            $('#searchInput').on('keyup', function() {

                let query = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    loadPersetujuan(1, query);
                }, 400);
            });

            // Klik pagination
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                let query = $('#searchInput').val();
                loadPersetujuan(page, query);
            });
        });
    </script>
@endsection
