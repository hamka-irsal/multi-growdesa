@extends('layouts.app')

@section('page-title', 'Data-Aparat Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-user-tie" style="color:#2E7D32;"></i> Data Aparat
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.aparat.index') }}">Data Aparat</a></div>
                    <div class="breadcrumb-item">Aparat</div>
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
                                List Data Aparat Desa
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahAparat"
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
                                <table class="table mb-0" id="aparatTable" style="border-collapse:collapse; width:100%;">
                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Jabatan</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Foto</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aparat as $index => $data)
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
                                                    {{ $data->nama }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->jabatan }}
                                                    </span>
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto Aparat"
                                                        width="80"
                                                        style="border-radius:8px; border:1.5px solid #E2E8F0;">
                                                </td>

                                                <td
                                                    style="padding:14px 18px; border:1.5px solid #CBD5E1; text-align:center;">
                                                    <div
                                                        style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                                        {{-- <a href="#" data-id="{{ $data->id }}" class="btn-detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a> --}}
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

    {{-- Modal Tambah Aparat --}}
    <div class="modal fade" id="modalTambahAparat" tabindex="-1" role="dialog" aria-labelledby="modalTambahAparatLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahAparatLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-tie"></i> Tambah Aparat
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.aparat.store') }}" method="POST" enctype="multipart/form-data"
                    id="formTambahAparat">

                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC;">

                        <div class="row">

                            {{-- Kolom kiri --}}
                            <div class="col-md-6">

                                {{-- Nama Aparat --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label for="user_id"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#2E7D32;"></i> Nama Lengkap
                                    </label>

                                    <select name="user_id" id="user_id" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Nama Aparat --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                    <small style="display:block; margin-top:8px; font-size:13.5px; color:#64748B;">
                                        Nama diambil dari akun pengguna dengan role aparat.
                                    </small>
                                </div>

                                {{-- Jabatan --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label for="jabatan"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-briefcase" style="color:#2E7D32;"></i> Jabatan
                                    </label>

                                    <input type="text" name="jabatan" id="jabatan" placeholder="Masukkan Jabatan"
                                        required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">

                                {{-- Foto --}}
                                <div class="form-group" style="margin-bottom:6px;">

                                    <label for="foto"
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#2E7D32;"></i> Foto
                                    </label>

                                    <input type="file" name="foto" id="foto" accept="image/*"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <img id="previewFoto" src="#" alt="Preview Foto"
                                        style="display:none; margin-top:12px; max-width:150px; border-radius:10px; border:1.5px solid #E2E8F0; background:#fff; padding:6px;">

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


    {{-- Modal Edit Aparat --}}
    <div class="modal fade" id="modalEditAparat" tabindex="-1" role="dialog" aria-labelledby="modalEditAparatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditAparatLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-user-edit"></i> Edit Aparat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" id="formEditAparat">
                    @csrf
                    <input type="hidden" name="_method" value="PUT"> {{-- spoofing method PUT --}}
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB;">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-user" style="color:#F59E0B;"></i> Nama
                                    </label>
                                    <select name="user_id" id="edit_user_id" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Nama Aparat --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-briefcase" style="color:#F59E0B;"></i> Jabatan
                                    </label>
                                    <input type="text" name="jabatan" id="edit_jabatan" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#F59E0B;"></i> Foto
                                    </label>
                                    <input type="file" name="foto" id="editFoto" accept="image/*"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <img id="editPreviewFoto" src="#" alt="Preview Foto"
                                        style="display:none; margin-top:12px; max-width:150px; border-radius:10px; border:1.5px solid #E2E8F0; background:#fff; padding:6px;">
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
        // Ajax modal tambah aparat
        $(document).ready(function() {
            $("#formTambahAparat").submit(function(e) {
                e.preventDefault(); // Mencegah reload halaman

                let formData = new FormData(this); // Mengambil data dari form

                $.ajax({
                    url: "{{ route('admin.aparat.store') }}", // Ganti dengan route Laravel
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
                                text: 'Data aparat berhasil ditambahkan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh halaman setelah sukses
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message ||
                                    'Terjadi kesalahan saat menambahkan data.',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Terjadi kesalahan saat mengirim data.',
                        });
                    }
                });
            });

            // Validasi input sebelum submit
            $("#formTambahAparat").on("submit", function(event) {
                let isValid = true;

                // Reset pesan error
                $(".text-danger").text("");

                // Periksa input hanya untuk form tambah aparat
                $(this).find("input, select").each(function() {
                    if ($(this).prop("required") && $(this).val().trim() === "") {
                        isValid = false;
                        $(this).next(".text-danger").text("Kolom ini wajib diisi.");
                    }
                });

                if (!isValid) {
                    event.preventDefault(); // Mencegah pengiriman form jika ada error
                }
            });
        });

        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/aparat/${id}`;

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

        // 🟢 AJAX Edit Aparat
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/aparat/${id}/edit`,
                type: "GET",
                dataType: "json",

                success: function(response) {

                    if (response.success) {

                        let data = response.data;

                        // Isi action form edit
                        $("#formEditAparat").attr(
                            "action",
                            `/admin/aparat/${id}`
                        );

                        // Isi ID aparat
                        $("#edit_id").val(data.id);

                        // Pilih user/aparat berdasarkan user_id
                        $("#edit_user_id").val(data.user_id);

                        // Isi jabatan
                        $("#edit_jabatan").val(data.jabatan);

                        // Preview foto
                        if (data.foto_url) {
                            $("#editPreviewFoto")
                                .attr("src", data.foto_url)
                                .show();
                        } else {
                            $("#editPreviewFoto")
                                .attr("src", "#")
                                .hide();
                        }

                        // Tampilkan modal
                        $("#modalEditAparat").modal("show");

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data aparat tidak ditemukan.",
                        });

                    }
                },

                error: function(xhr) {

                    console.error("Error:", xhr.responseText);

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data dari server.",
                    });

                },
            });
        });

        // 🟢 AJAX Submit Edit Aparat
        $("#formEditAparat").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let id = $("#edit_id").val();

            $.ajax({
                url: `/admin/aparat/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-HTTP-Method-Override": "PUT", // Untuk method spoofing
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data aparat berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            $("#modalEditAparat").modal("hide");
                            $("#formEditAparat")[0].reset();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Data gagal diperbarui!",
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


        // Ajax Cari Aparat
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let query = $(this).val();
                loadAparat(1, query);

                $.ajax({
                    url: '/admin/search-aparat', // Sesuaikan dengan route pencarian aparat kamu
                    method: 'GET',
                    data: {
                        query: searchQuery
                    },
                    success: function(response) {
                        var tbody = $('#aparatTable tbody');
                        tbody.empty();

                        if (response.data.length > 0) {
                            response.data.forEach(function(aparat, index) {
                                var foto = aparat.foto ? `/storage/${aparat.foto}` :
                                    '/images/default-user.png';

                                var row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${aparat.nama}</td>
                                <td>${aparat.jabatan}</td>
                                <td><img src="${foto}" alt="Foto Aparat" width="80"></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="${aparat.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-hapus" data-id="${aparat.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            tbody.append(
                                '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });
        });

        //Ajax Pagination Aparat
        $(document).ready(function() {

            let searchTimer = null;

            function loadAparat(page = 1, query = '') {

                $.ajax({
                    url: "{{ route('admin.aparat.paginate') }}",
                    type: "GET",
                    data: {
                        page: page,
                        query: query
                    },
                    success: function(response) {

                        let tbody = $('#aparatTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        tbody.empty();
                        paginationLinks.empty();

                        if (response.data.length === 0) {
                            tbody.append(`
                        <tr>
                            <td colspan="5"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-user-slash fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data tidak ditemukan</span>
                            </td>
                        </tr>
                    `);
                            return;
                        }

                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let fotoUrl = data.foto ? `/storage/${data.foto}` :
                                '/images/default-user.png';

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.nama}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${data.jabatan}
                                </span>
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <img src="${fotoUrl}" alt="Foto Aparat" width="80"
                                    style="border-radius:8px; border:1.5px solid #E2E8F0;">
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
                            text: 'Terjadi kesalahan saat memuat data aparat.'
                        });
                    }
                });
            }

            // Awal: load semua
            loadAparat();

            // Ketik di pencarian (debounce, tetap lewat loadAparat yang sama)
            $('#searchInput').on('keyup', function() {

                let query = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    loadAparat(1, query); // pencarian selalu dari halaman pertama
                }, 400);
            });

            // Klik pagination
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                let query = $('#searchInput').val(); // ambil query dari input
                loadAparat(page, query);
            });
        });
    </script>
@endsection
