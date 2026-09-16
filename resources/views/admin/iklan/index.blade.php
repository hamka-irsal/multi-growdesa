@extends('admin.layouts.app')

@section('page-title', 'Data-Kategori-Berita Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-bullhorn" style="color:#2E7D32;"></i> Data Iklan
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.iklan.index') }}">Data Iklan</a></div>
                    <div class="breadcrumb-item">Data Iklan</div>
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
                                List Data Iklan
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahIklan"
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
                                <table class="table mb-0" id="iklanTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Gambar Iklan</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Status</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($iklans as $index => $iklan)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                {{-- Nomor --}}
                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $iklans->firstItem() + $index }}
                                                </td>

                                                {{-- Gambar Iklan --}}
                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    @if ($iklan->image)
                                                        <img src="{{ $iklan->image }}" alt="Gambar Iklan" width="120"
                                                            style="border-radius:8px; border:1.5px solid #E2E8F0;">
                                                    @else
                                                        <span style="color:#94A3B8; font-size:14px; font-weight:500;">
                                                            Gambar belum tersedia
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Status Iklan --}}
                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    @if ($iklan->is_active)
                                                        <span
                                                            style="display:inline-block; background:#DCFCE7; color:#15803D; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #86EFAC;">
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span
                                                            style="display:inline-block; background:#F1F5F9; color:#475569; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #CBD5E1;">
                                                            Tidak Aktif
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Aksi --}}
                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        <button type="button" class="btn-edit"
                                                            data-id="{{ $iklan->id }}" title="Edit"
                                                            style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                                            onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                                            onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn-hapus" data-id="{{ $iklan->id }}"
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
                                                <td colspan="4"
                                                    style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                                    <i class="fas fa-image fa-2x mb-3"
                                                        style="opacity:0.3; display:block;"></i>
                                                    <span style="font-size:15px; font-weight:500;">Data iklan belum
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

    {{-- Modal Tambah Iklan --}}

    <div class="modal fade" id="modalTambahIklan" tabindex="-1" role="dialog" aria-labelledby="modalTambahIklanLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-ld" role="document">

            <div class="modal-content"
                style="border-radius:16px; border:none; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border-bottom:none;">

                    <h5 class="modal-title" id="modalTambahIklanLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-bullhorn"></i>
                        Tambah Iklan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                {{-- Form Tambah --}}
                <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data"
                    id="formTambahIklan">

                    @csrf


                    <div class="modal-body" style="padding:28px;">

                        {{-- Gambar Iklan --}}
                        <div class="form-group" style="margin-bottom:22px;">

                            <label for="image"
                                style="font-size:15px; font-weight:600; color:#1E293B; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-image" style="color:#2E7D32;"></i>
                                Gambar Iklan
                            </label>

                            <input type="file" name="image" id="image"
                                accept="image/jpeg,image/png,image/jpg,image/webp" required
                                style="width:100%; padding:12px 14px; font-size:15px; border:1.5px solid #E2E8F0; border-radius:10px; background:#F8FAFC; outline:none; transition:border .2s;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">

                            <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                Format gambar: JPG, JPEG, PNG, atau WEBP. Maksimal ukuran 2 MB.
                            </small>

                        </div>


                        {{-- Preview Gambar --}}
                        <div class="form-group" style="margin-bottom:22px;">

                            <img id="previewImage" src="#" alt="Preview Gambar Iklan"
                                style="
                                display:none;
                                width:100%;
                                max-height:280px;
                                object-fit:contain;
                                border-radius:12px;
                                border:1.5px solid #E2E8F0;
                                background:#F8FAFC;
                                padding:8px;
                            ">

                        </div>


                        {{-- Status Iklan --}}
                        <div class="form-group" style="margin-bottom:6px;">

                            <label for="is_active"
                                style="font-size:15px; font-weight:600; color:#1E293B; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-toggle-on" style="color:#2E7D32;"></i>
                                Status Iklan
                            </label>

                            <select name="is_active" id="is_active" required
                                style="width:100%; padding:12px 14px; font-size:15px; font-weight:500; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#F8FAFC; outline:none; transition:border .2s; appearance:auto;"
                                onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'">

                                <option value="1" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>

                            </select>

                            <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                Iklan aktif akan ditampilkan pada aplikasi atau halaman publik.
                            </small>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="modal-footer"
                        style="background:#F8FAFC; padding:18px 28px; border-top:1.5px solid #F1F5F9; gap:10px;">

                        <button type="button" data-dismiss="modal"
                            style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                            <i class="fas fa-times"></i>
                            Batal
                        </button>


                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#2E7D32; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#256528'" onmouseout="this.style.background='#2E7D32'">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    {{-- Modal Edit Iklan --}}

    <div class="modal fade" id="modalEditIklan" tabindex="-1" role="dialog" aria-labelledby="modalEditIklanLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-ld" role="document">

            <div class="modal-content"
                style="border-radius:16px; border:none; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border-bottom:none;">

                    <h5 class="modal-title" id="modalEditIklanLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-edit"></i>
                        Edit Iklan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                {{-- Form Edit --}}
                <form method="POST" enctype="multipart/form-data" id="formEditIklan">

                    @csrf

                    {{-- Method PUT --}}
                    <input type="hidden" name="_method" value="PUT">

                    {{-- ID Iklan --}}
                    <input type="hidden" name="id" id="edit_id">


                    <div class="modal-body" style="padding:28px;">

                        {{-- Gambar Lama --}}
                        <div class="form-group" style="margin-bottom:22px;">

                            <label
                                style="font-size:15px; font-weight:600; color:#1E293B; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-image" style="color:#F59E0B;"></i>
                                Gambar Iklan Saat Ini
                            </label>

                            <img id="editPreviewImage" src="#" alt="Gambar Iklan"
                                style="
                                display:none;
                                width:100%;
                                max-height:280px;
                                object-fit:contain;
                                border-radius:12px;
                                border:1.5px solid #E2E8F0;
                                background:#F8FAFC;
                                padding:8px;
                            ">

                        </div>


                        {{-- Ganti Gambar --}}
                        <div class="form-group" style="margin-bottom:22px;">

                            <label for="edit_image"
                                style="font-size:15px; font-weight:600; color:#1E293B; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-upload" style="color:#F59E0B;"></i>
                                Ganti Gambar Iklan
                            </label>

                            <input type="file" name="image" id="edit_image"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                style="width:100%; padding:12px 14px; font-size:15px; border:1.5px solid #E2E8F0; border-radius:10px; background:#F8FAFC; outline:none; transition:border .2s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">

                            <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                Kosongkan jika tidak ingin mengganti gambar iklan.
                            </small>

                        </div>


                        {{-- Status --}}
                        <div class="form-group" style="margin-bottom:6px;">

                            <label for="edit_is_active"
                                style="font-size:15px; font-weight:600; color:#1E293B; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                <i class="fas fa-toggle-on" style="color:#F59E0B;"></i>
                                Status Iklan
                            </label>

                            <select name="is_active" id="edit_is_active" required
                                style="width:100%; padding:12px 14px; font-size:15px; font-weight:500; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#F8FAFC; outline:none; transition:border .2s;"
                                onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'">

                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>

                            </select>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="modal-footer"
                        style="background:#F8FAFC; padding:18px 28px; border-top:1.5px solid #F1F5F9; gap:10px;">

                        <button type="button" data-dismiss="modal"
                            style="display:flex; align-items:center; gap:8px; padding:11px 22px; background:#fff; color:#475569; border:1.5px solid #E2E8F0; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='#fff'">
                            <i class="fas fa-times"></i>
                            Batal
                        </button>


                        <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:11px 24px; background:#F59E0B; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#D97706'" onmouseout="this.style.background='#F59E0B'">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
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
            | AJAX Tambah Iklan
            |--------------------------------------------------------------------------
            */
            $("#formTambahIklan").submit(function(e) {

                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({

                    url: "{{ route('admin.iklan.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,


                    /*
                    |--------------------------------------------------------------------------
                    | Loading
                    |--------------------------------------------------------------------------
                    */
                    beforeSend: function() {

                        Swal.fire({

                            title: "Mohon Tunggu...",
                            text: "Sedang menyimpan iklan...",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {

                                Swal.showLoading();

                            }

                        });

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Jika Berhasil
                    |--------------------------------------------------------------------------
                    */
                    success: function(response) {

                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message ||
                                    "Iklan berhasil ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Tutup modal
                                $("#modalTambahIklan").modal("hide");
                                // Reset form
                                $("#formTambahIklan")[0].reset();
                                // Sembunyikan preview gambar
                                $("#previewImage")
                                    .attr("src", "#")
                                    .hide();
                                // Refresh halaman
                                location.reload();
                            });

                        } else {

                            let errorMessage =
                                "Terjadi kesalahan saat menambahkan iklan.";
                            /*
                            |--------------------------------------------------------------------------
                            | Pesan Error Umum
                            |--------------------------------------------------------------------------
                            */
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


                            Swal.fire({

                                icon: "error",
                                title: "Gagal!",
                                text: errorMessage,
                                confirmButtonText: "Coba Lagi"

                            });

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Jika Terjadi Error
                    |--------------------------------------------------------------------------
                    */
                    error: function(xhr) {

                        let errorMessage =
                            "Terjadi kesalahan saat mengirim data iklan.";


                        /*
                        |--------------------------------------------------------------------------
                        | Error Validasi Laravel
                        |--------------------------------------------------------------------------
                        */
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
                                html: `
                        <ul style="text-align:left;">
                            ${errorMessages}
                        </ul>
                    `

                            });


                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Error Dari Response Server
                        |--------------------------------------------------------------------------
                        */
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
            | AJAX Hapus Iklan
            |--------------------------------------------------------------------------
            */
            $(document).on(
                "click",
                ".btn-hapus",
                function() {

                    let id =
                        $(this).data("id");


                    /*
                    |--------------------------------------------------------------------------
                    | Membuat URL Hapus Iklan
                    |--------------------------------------------------------------------------
                    */
                    let url =
                        "{{ route('admin.iklan.destroy', ':id') }}"
                        .replace(":id", id);


                    /*
                    |--------------------------------------------------------------------------
                    | Konfirmasi Hapus
                    |--------------------------------------------------------------------------
                    */
                    Swal.fire({

                        title: "Apakah Anda yakin?",

                        text: "Iklan yang dihapus tidak dapat dikembalikan!",

                        icon: "warning",

                        showCancelButton: true,

                        confirmButtonColor: "#d33",

                        cancelButtonColor: "#3085d6",

                        confirmButtonText: "Ya, hapus!",

                        cancelButtonText: "Batal"

                    }).then((result) => {


                        /*
                        |--------------------------------------------------------------------------
                        | Jika Tombol Hapus Dikonfirmasi
                        |--------------------------------------------------------------------------
                        */
                        if (result.isConfirmed) {


                            $.ajax({

                                url: url,

                                type: "DELETE",

                                data: {

                                    _token: "{{ csrf_token() }}"

                                },


                                /*
                                |--------------------------------------------------------------------------
                                | Loading
                                |--------------------------------------------------------------------------
                                */
                                beforeSend: function() {

                                    Swal.fire({

                                        title: "Mohon Tunggu...",

                                        text: "Sedang menghapus iklan...",

                                        allowOutsideClick: false,

                                        showConfirmButton: false,


                                        didOpen: () => {

                                            Swal.showLoading();

                                        }

                                    });

                                },


                                /*
                                |--------------------------------------------------------------------------
                                | Jika Berhasil Dihapus
                                |--------------------------------------------------------------------------
                                */
                                success: function(response) {

                                    if (
                                        response.success
                                    ) {

                                        Swal.fire({

                                            title: "Berhasil!",

                                            text: response.message ||
                                                "Iklan berhasil dihapus.",

                                            icon: "success",

                                            timer: 2000,

                                            showConfirmButton: false

                                        }).then(() => {

                                            // Refresh halaman
                                            location.reload();

                                        });

                                    } else {

                                        Swal.fire({

                                            title: "Gagal!",

                                            text: response.message ||
                                                "Iklan gagal dihapus.",

                                            icon: "error"

                                        });

                                    }

                                },


                                /*
                                |--------------------------------------------------------------------------
                                | Jika Gagal Menghapus
                                |--------------------------------------------------------------------------
                                */
                                error: function(xhr) {

                                    let errorMessage =
                                        "Terjadi kesalahan saat menghapus iklan.";


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
            | AJAX Ambil Data Edit Iklan
            |--------------------------------------------------------------------------
            */
            $(document).on(
                "click",
                ".btn-edit",
                function() {

                    let id = $(this).data("id");

                    let url =
                        "{{ route('admin.iklan.edit', ':id') }}"
                        .replace(":id", id);

                    $.ajax({

                        url: url,

                        type: "GET",

                        dataType: "json",

                        success: function(response) {

                            if (response.success) {

                                let data = response.data;

                                /*
                                |--------------------------------------------------------------------------
                                | Atur URL Update
                                |--------------------------------------------------------------------------
                                */
                                let updateUrl =
                                    "{{ route('admin.iklan.update', ':id') }}"
                                    .replace(
                                        ":id",
                                        id
                                    );

                                $("#formEditIklan")
                                    .attr(
                                        "action",
                                        updateUrl
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | Isi ID Iklan
                                |--------------------------------------------------------------------------
                                */
                                $("#edit_id")
                                    .val(
                                        data.id
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | Isi Status Aktif
                                |--------------------------------------------------------------------------
                                */
                                $("#edit_is_active")
                                    .val(
                                        data.is_active
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | Tampilkan Gambar Lama
                                |--------------------------------------------------------------------------
                                */
                                if (data.image_url) {

                                    $("#editPreviewImage")
                                        .attr(
                                            "src",
                                            data.image_url
                                        )
                                        .show();

                                } else {

                                    $("#editPreviewImage")
                                        .attr(
                                            "src",
                                            "#"
                                        )
                                        .hide();
                                }


                                /*
                                |--------------------------------------------------------------------------
                                | Kosongkan Input File
                                |--------------------------------------------------------------------------
                                */
                                $("#edit_image")
                                    .val("");


                                /*
                                |--------------------------------------------------------------------------
                                | Tampilkan Modal Edit
                                |--------------------------------------------------------------------------
                                */
                                $("#modalEditIklan")
                                    .modal("show");

                            } else {

                                Swal.fire({

                                    icon: "error",

                                    title: "Gagal!",

                                    text: response.message ||
                                        "Data iklan tidak ditemukan."

                                });
                            }
                        },

                        error: function(xhr) {

                            let errorMessage =
                                "Gagal memuat data iklan dari server.";

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
            | AJAX Submit Edit Iklan
            |--------------------------------------------------------------------------
            */
            $("#formEditIklan").submit(function(e) {

                e.preventDefault();

                let formData =
                    new FormData(this);

                let id =
                    $("#edit_id").val();

                let url =
                    "{{ route('admin.iklan.update', ':id') }}"
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

                    beforeSend: function() {

                        Swal.fire({

                            title: "Mohon Tunggu...",

                            text: "Sedang memperbarui data iklan.",

                            allowOutsideClick: false,

                            showConfirmButton: false,

                            didOpen: () => {

                                Swal.showLoading();

                            }
                        });
                    },

                    success: function(response) {

                        if (
                            response.success
                        ) {

                            Swal.fire({

                                title: "Berhasil!",

                                text: response.message ||
                                    "Iklan berhasil diperbarui.",

                                icon: "success",

                                timer: 2000,

                                showConfirmButton: false

                            }).then(() => {

                                /*
                                |--------------------------------------------------------------------------
                                | Tutup Modal
                                |--------------------------------------------------------------------------
                                */
                                $("#modalEditIklan")
                                    .modal("hide");


                                /*
                                |--------------------------------------------------------------------------
                                | Reset Form
                                |--------------------------------------------------------------------------
                                */
                                $("#formEditIklan")[0]
                                    .reset();


                                /*
                                |--------------------------------------------------------------------------
                                | Sembunyikan Preview
                                |--------------------------------------------------------------------------
                                */
                                $("#editPreviewImage")
                                    .attr(
                                        "src",
                                        "#"
                                    )
                                    .hide();


                                /*
                                |--------------------------------------------------------------------------
                                | Refresh Halaman
                                |--------------------------------------------------------------------------
                                */
                                location.reload();

                            });

                        } else {

                            Swal.fire({

                                title: "Gagal!",

                                text: response.message ||
                                    "Iklan gagal diperbarui!",

                                icon: "error"

                            });
                        }
                    },

                    error: function(xhr) {

                        let errorMessages =
                            "";

                        /*
                        |--------------------------------------------------------------------------
                        | Menampilkan Error Validasi Laravel
                        |--------------------------------------------------------------------------
                        */
                        if (
                            xhr.status === 422 &&
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

                        } else if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            errorMessages =
                                `<li>${xhr.responseJSON.message}</li>`;

                        } else {

                            errorMessages =
                                "<li>Terjadi kesalahan pada server.</li>";
                        }

                        Swal.fire({

                            title: "Terjadi Kesalahan!",

                            html: `
                    <ul style="text-align:left;">
                        ${errorMessages}
                    </ul>
                `,

                            icon: "error"

                        });
                    }
                });
            });

        });

        /*
        |--------------------------------------------------------------------------
        | Load Data Iklan (Paginate + Search jadi satu)
        |--------------------------------------------------------------------------
        */
        let searchTimer = null;

        function loadIklan(page = 1, search = '') {

            $.ajax({

                url: "{{ route('admin.iklan.paginate') }}",

                type: "GET",

                data: {
                    page: page,
                    search: search
                },

                success: function(response) {

                    let tbody = $('#iklanTable tbody');
                    let paginationLinks = $('#paginationLinks');

                    tbody.empty();
                    paginationLinks.empty();

                    /*
                    |--------------------------------------------------------------------------
                    | Jika Data Iklan Kosong
                    |--------------------------------------------------------------------------
                    */
                    if (!response.data || response.data.length === 0) {

                        tbody.append(`
                    <tr>
                        <td colspan="4"
                            style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                            <i class="fas fa-image fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                            <span style="font-size:15px; font-weight:500;">Data iklan tidak ditemukan</span>
                        </td>
                    </tr>
                `);

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Tampilkan Data Iklan
                    |--------------------------------------------------------------------------
                    */
                    response.data.forEach(function(iklan, index) {

                        let imageUrl = iklan.image ? iklan.image :
                            `{{ asset('images/default-image.png') }}`;

                        let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                        let status = Number(iklan.is_active) === 1 ?
                            `<span style="display:inline-block; background:#DCFCE7; color:#15803D; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #86EFAC;">Aktif</span>` :
                            `<span style="display:inline-block; background:#F1F5F9; color:#475569; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #CBD5E1;">Tidak Aktif</span>`;

                        let row = `
                    <tr style="background:${rowBg}; transition:background .15s;"
                        onmouseover="this.style.background='#EEF2FF'"
                        onmouseout="this.style.background='${rowBg}'">

                        <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                            ${response.from + index}
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                            <img src="${imageUrl}" alt="Gambar Iklan" width="120"
                                style="border-radius:8px; border:1.5px solid #E2E8F0; max-height:80px; object-fit:cover;">
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                            ${status}
                        </td>

                        <td style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:6px;">

                                <button type="button" class="btn-edit" data-id="${iklan.id}" title="Edit"
                                    style="width:36px; height:36px; border-radius:8px; border:1.5px solid #F59E0B; background:#FFF3E0; color:#B45309; font-size:15px; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center;"
                                    onmouseover="this.style.background='#F59E0B';this.style.color='#fff'"
                                    onmouseout="this.style.background='#FFF3E0';this.style.color='#B45309'">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button" class="btn-hapus" data-id="${iklan.id}" title="Hapus"
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
                    | Menampilkan Pagination
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

                            let activeClass = (Number(response.current_page) === i) ? 'active' : '';

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
                | Jika AJAX Gagal
                |--------------------------------------------------------------------------
                */
                error: function(xhr) {

                    console.error('Gagal memuat data iklan:', xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memuat data iklan.'
                    });
                }

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Load Awal Data Iklan
        |--------------------------------------------------------------------------
        */
        loadIklan();

        /*
        |--------------------------------------------------------------------------
        | Pencarian Iklan (debounce, tetap lewat loadIklan yang sama)
        |--------------------------------------------------------------------------
        */
        $('#searchInput').on('keyup', function() {

            let search = $(this).val();

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function() {
                // Pencarian selalu dimulai dari halaman pertama
                loadIklan(1, search);
            }, 400);
        });

        /*
        |--------------------------------------------------------------------------
        | Klik Link Pagination
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '.pagination-link', function(e) {

            e.preventDefault();

            let page = $(this).data('page');
            let search = $('#searchInput').val();

            loadIklan(page, search);
        });
    </script>

@endsection
