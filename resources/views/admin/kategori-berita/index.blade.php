@extends('layouts.app')

@section('page-title', 'Data-Kategori-Berita Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-tags" style="color:#2E7D32;"></i> Data Kategori Berita
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.kategori-berita.index') }}">Data Kategori
                            Berita</a>
                    </div>
                    <div class="breadcrumb-item">Kategori Berita</div>
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
                                List Kategori Berita
                            </h4>

                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">

                                {{-- Search --}}
                                <div style="position:relative;">
                                    <i class="fas fa-search"
                                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; font-size:13px;"></i>
                                    <input type="text" id="searchInput" autocomplete="off" placeholder="Cari kategori..."
                                        style="padding:9px 14px 9px 34px; border:1.5px solid #E2E8F0; border-radius:10px; font-size:14px; color:#1E293B; background:#F8FAFC; width:200px; outline:none; transition:border .2s;"
                                        onfocus="this.style.borderColor='#6777ef';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#E2E8F0';this.style.background='#F8FAFC'">
                                </div>

                                {{-- Tambah --}}
                                <button type="button" data-toggle="modal" data-target="#modalTambahKategori"
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
                                <table class="table mb-0" id="categoryTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Kategori</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Slug</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($categories as $index => $category)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $categories->firstItem() + $index }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                                    {{ $category->name }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $category->slug }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        <button type="button" class="btn-edit"
                                                            data-id="{{ $category->id }}" title="Edit"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn-hapus"
                                                            data-id="{{ $category->id }}" title="Hapus"
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
                                                <td colspan="4"
                                                    style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                                    <i class="fas fa-tags fa-2x mb-3"
                                                        style="opacity:0.3; display:block;"></i>
                                                    <span style="font-size:15px; font-weight:500;">Data kategori belum
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
                                    <!-- Link pagination akan dimuat di sini -->
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

            </div>

        </section>
    </div>

    {{-- Modal Tambah Kategori --}}
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahKategoriLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-tags"></i> Tambah Kategori Berita
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.kategori-berita.store') }}" method="POST" id="formTambahKategori">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC;">

                        {{-- Nama Kategori --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label for="name"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-tag" style="color:#2E7D32;"></i> Nama Kategori
                            </label>

                            <input type="text" name="name" id="name" placeholder="Masukkan nama kategori"
                                required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">
                        </div>

                        {{-- Slug --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label for="slug"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-link" style="color:#2E7D32;"></i> Slug
                            </label>

                            <input type="text" name="slug" id="slug" placeholder="Slug akan dibuat otomatis"
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">

                            <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                Slug dapat dikosongkan dan akan dibuat otomatis berdasarkan nama kategori.
                            </small>
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


    {{-- Modal Edit Kategori --}}
    <div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog"
        aria-labelledby="modalEditKategoriLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditKategoriLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-edit"></i> Edit Kategori Berita
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" id="formEditKategori">

                    @csrf

                    {{-- Spoofing method PUT --}}
                    <input type="hidden" name="_method" value="PUT">

                    {{-- ID kategori --}}
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB;">

                        {{-- Nama Kategori --}}
                        <div class="form-group" style="margin-bottom:20px;">
                            <label for="edit_name"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-tag" style="color:#F59E0B;"></i> Nama Kategori
                            </label>

                            <input type="text" name="name" id="edit_name" placeholder="Masukkan nama kategori"
                                required
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">
                        </div>

                        {{-- Slug --}}
                        <div class="form-group" style="margin-bottom:6px;">
                            <label for="edit_slug"
                                style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-link" style="color:#F59E0B;"></i> Slug
                            </label>

                            <input type="text" name="slug" id="edit_slug" placeholder="Masukkan slug kategori"
                                style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">

                            <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                Slug dapat dikosongkan dan akan dibuat otomatis berdasarkan nama kategori.
                            </small>
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
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | AJAX Tambah Kategori Berita
            |--------------------------------------------------------------------------
            */
            $("#formTambahKategori").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.kategori-berita.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {
                        Swal.fire({
                            title: "Mohon Tunggu...",
                            text: "Sedang menyimpan kategori berita",
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
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message ||
                                    "Kategori berita berhasil ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false

                            }).then(() => {

                                // Tutup modal
                                $("#modalTambahKategori").modal("hide");

                                // Reset form
                                $("#formTambahKategori")[0].reset();

                                // Refresh halaman
                                location.reload();
                            });

                        } else {

                            let errorMessage =
                                "Terjadi kesalahan saat menambahkan kategori berita.";

                            if (
                                response.errors &&
                                response.errors.general
                            ) {
                                errorMessage =
                                    response.errors.general[0];

                            } else if (response.message) {
                                errorMessage =
                                    response.message;
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: errorMessage,
                                confirmButtonText: "Coba Lagi"
                            });
                        }
                    },

                    error: function(xhr) {

                        let errorMessage =
                            "Terjadi kesalahan saat mengirim data.";

                        // Menampilkan pesan validasi Laravel
                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            let errors =
                                xhr.responseJSON.errors;

                            let errorMessages = "";

                            $.each(
                                errors,
                                function(key, value) {
                                    errorMessages +=
                                        `<li>${value[0]}</li>`;
                                }
                            );

                            Swal.fire({
                                icon: "error",
                                title: "Validasi Gagal!",
                                html: `<ul style="text-align:left;">
                                    ${errorMessages}
                                </ul>`
                            });

                            return;
                        }

                        // Menampilkan error umum
                        if (
                            xhr.responseJSON
                        ) {

                            let response =
                                xhr.responseJSON;

                            if (
                                response.errors &&
                                response.errors.general
                            ) {

                                errorMessage =
                                    response.errors.general[0];

                            } else if (
                                response.message
                            ) {

                                errorMessage =
                                    response.message;
                            }
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            text: errorMessage,
                            confirmButtonText: "Tutup"
                        });
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | AJAX Hapus Kategori Berita
            |--------------------------------------------------------------------------
            */
            $(document).on(
                "click",
                ".btn-hapus",
                function() {

                    let id =
                        $(this).data("id");

                    let url =
                        "{{ route('admin.kategori-berita.destroy', ':id') }}"
                        .replace(":id", id);

                    Swal.fire({
                        title: "Apakah Anda yakin?",

                        text: "Kategori berita yang dihapus tidak dapat dikembalikan!",

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

                                    if (
                                        response.success
                                    ) {

                                        Swal.fire({

                                            title: "Berhasil!",

                                            text: response.message ||
                                                "Kategori berita berhasil dihapus.",

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
                                                "Kategori berita gagal dihapus.",

                                            icon: "error"

                                        });
                                    }
                                },

                                error: function(xhr) {

                                    let errorMessage =
                                        "Terjadi kesalahan saat menghapus kategori berita.";

                                    if (
                                        xhr.responseJSON &&
                                        xhr.responseJSON.message
                                    ) {

                                        errorMessage =
                                            xhr.responseJSON.message;
                                    }

                                    Swal.fire({

                                        title: "Gagal!",

                                        text: errorMessage,

                                        icon: "error"

                                    });
                                }
                            });
                        }
                    });
                }
            );


            /*
            |--------------------------------------------------------------------------
            | AJAX Ambil Data Edit Kategori Berita
            |--------------------------------------------------------------------------
            */
            $(document).on(
                "click",
                ".btn-edit",
                function() {

                    let id =
                        $(this).data("id");

                    let url =
                        "{{ route('admin.kategori-berita.edit', ':id') }}"
                        .replace(":id", id);

                    $.ajax({

                        url: url,

                        type: "GET",

                        dataType: "json",

                        success: function(response) {

                            if (
                                response.success
                            ) {

                                let data =
                                    response.data;

                                // Atur action form edit
                                let updateUrl =
                                    "{{ route('admin.kategori-berita.update', ':id') }}"
                                    .replace(
                                        ":id",
                                        id
                                    );

                                $("#formEditKategori")
                                    .attr(
                                        "action",
                                        updateUrl
                                    );

                                // Isi data ke modal
                                $("#edit_id")
                                    .val(
                                        data.id
                                    );

                                $("#edit_name")
                                    .val(
                                        data.name
                                    );

                                $("#edit_slug")
                                    .val(
                                        data.slug
                                    );

                                // Tampilkan modal
                                $("#modalEditKategori")
                                    .modal("show");

                            } else {

                                Swal.fire({

                                    icon: "error",

                                    title: "Gagal!",

                                    text: "Data kategori berita tidak ditemukan."

                                });
                            }
                        },

                        error: function(xhr) {

                            let errorMessage =
                                "Gagal memuat data kategori berita dari server.";

                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                errorMessage =
                                    xhr.responseJSON.message;
                            }

                            Swal.fire({

                                icon: "error",

                                title: "Error!",

                                text: errorMessage

                            });
                        }
                    });
                }
            );


            /*
            |--------------------------------------------------------------------------
            | AJAX Submit Edit Kategori Berita
            |--------------------------------------------------------------------------
            */
            $("#formEditKategori").submit(function(e) {

                e.preventDefault();

                let formData =
                    new FormData(this);

                let id =
                    $("#edit_id").val();

                let url =
                    "{{ route('admin.kategori-berita.update', ':id') }}"
                    .replace(
                        ":id",
                        id
                    );

                $.ajax({

                    url: url,

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    success: function(response) {

                        if (
                            response.success
                        ) {

                            Swal.fire({

                                title: "Berhasil!",

                                text: response.message ||
                                    "Kategori berita berhasil diperbarui.",

                                icon: "success",

                                timer: 2000,

                                showConfirmButton: false

                            }).then(() => {

                                // Tutup modal
                                $("#modalEditKategori")
                                    .modal("hide");

                                // Reset form
                                $("#formEditKategori")[0]
                                    .reset();

                                // Refresh halaman
                                location.reload();

                            });

                        } else {

                            Swal.fire({

                                title: "Gagal!",

                                text: response.message ||
                                    "Kategori berita gagal diperbarui!",

                                icon: "error"

                            });
                        }
                    },

                    error: function(xhr) {

                        let errorMessages =
                            "";

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            $.each(
                                xhr.responseJSON.errors,
                                function(
                                    key,
                                    value
                                ) {

                                    errorMessages +=
                                        `<li>${value[0]}</li>`;

                                }
                            );

                        } else {

                            errorMessages =
                                "<li>Terjadi kesalahan pada server.</li>";
                        }

                        Swal.fire({

                            title: "Terjadi Kesalahan!",

                            html: `<ul style="text-align:left;">
                                ${errorMessages}
                            </ul>`,

                            icon: "error"

                        });
                    }
                });
            });

        });

        /*
        |--------------------------------------------------------------------------
        | Load Data Kategori Berita
        |--------------------------------------------------------------------------
        */
        let searchTimer = null;

        function loadKategoriBerita(page = 1, query = '') {

            $.ajax({
                url: "{{ route('admin.kategori-berita.paginate') }}",
                type: "GET",

                data: {
                    page: page,
                    search: query
                },

                success: function(response) {

                    let tbody = $('#categoryTable tbody');
                    let paginationLinks = $('#paginationLinks');

                    tbody.empty();
                    paginationLinks.empty();

                    /*
                    |--------------------------------------------------------------------------
                    | Jika Data Kosong
                    |--------------------------------------------------------------------------
                    */
                    if (!response.data || response.data.length === 0) {

                        tbody.append(`
                    <tr>
                        <td colspan="4"
                            style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                            <i class="fas fa-tags fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                            <span style="font-size:15px; font-weight:500;">Data kategori berita tidak ditemukan</span>
                        </td>
                    </tr>
                `);

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Tampilkan Data Kategori
                    |--------------------------------------------------------------------------
                    */
                    response.data.forEach(function(category, index) {

                        let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                        let row = `
                    <tr style="background:${rowBg}; transition:background .15s;"
                        onmouseover="this.style.background='#EEF2FF'"
                        onmouseout="this.style.background='${rowBg}'">

                        <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                            ${response.from + index}
                        </td>

                        <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                            ${category.name}
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                            <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                ${category.slug}
                            </span>
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:6px;">

                                <button type="button" class="btn-edit" data-id="${category.id}" title="Edit"
                                    style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                    onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                    onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn-hapus" data-id="${category.id}" title="Hapus"
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

                    /*
                    |--------------------------------------------------------------------------
                    | Pagination
                    |--------------------------------------------------------------------------
                    */
                    if (response.last_page > 1) {

                        // Tombol Previous
                        if (response.current_page > 1) {

                            paginationLinks.append(`
                        <li class="page-item">
                            <a class="page-link pagination-link" href="#" data-page="${response.current_page - 1}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    `);
                        }

                        // Nomor Halaman
                        for (let i = 1; i <= response.last_page; i++) {

                            let activeClass = response.current_page === i ? 'active' : '';

                            paginationLinks.append(`
                        <li class="page-item ${activeClass}">
                            <a class="page-link pagination-link" href="#" data-page="${i}">
                                ${i}
                            </a>
                        </li>
                    `);
                        }

                        // Tombol Next
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

                /*
                |--------------------------------------------------------------------------
                | Error AJAX
                |--------------------------------------------------------------------------
                */
                error: function(xhr) {

                    console.error('Terjadi kesalahan:', xhr);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memuat data kategori berita.'
                    });
                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Load Awal Data Kategori Berita
        |--------------------------------------------------------------------------
        */
        loadKategoriBerita();


        /*
        |--------------------------------------------------------------------------
        | Pencarian Kategori Berita (debounce, tetap lewat loadKategoriBerita)
        |--------------------------------------------------------------------------
        */
        $('#searchInput').on('keyup', function() {

            let query = $(this).val();

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function() {
                // Pencarian selalu dimulai dari halaman 1
                loadKategoriBerita(1, query);
            }, 400);
        });


        /*
        |--------------------------------------------------------------------------
        | Klik Pagination
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '.pagination-link', function(e) {

            e.preventDefault();

            let page = $(this).data('page');
            let query = $('#searchInput').val();

            loadKategoriBerita(page, query);
        });
    </script>

@endsection
