@extends('admin.layouts.app')

@section('page-title', 'Data-Produk Admin')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- Header --}}
            <div class="section-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <h1 style="font-size:clamp(16px,4vw,22px); margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-box" style="color:#2E7D32;"></i> Data Produk
                </h1>
                <div class="section-header-breadcrumb" style="font-size:13px;">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Data Produk</a></div>
                    <div class="breadcrumb-item">Produk</div>
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
                                List Data Produk
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
                                <button type="button" data-toggle="modal" data-target="#modalTambahProduk"
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

                                <table class="table mb-0" id="produkTable" style="border-collapse:collapse; width:100%;">

                                    <thead>
                                        <tr style="background:#F8FAFC;">
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; width:55px; text-align:center;">
                                                No</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Nama Produk</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Kategori</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center;">
                                                Stok</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1;">
                                                Gambar</th>
                                            <th
                                                style="padding:14px 18px; font-size:13px; font-weight:700; color:#1E293B; text-transform:uppercase; letter-spacing:0.6px; border:1.5px solid #CBD5E1; text-align:center; width:120px;">
                                                Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($produk as $index => $data)
                                            @php $rowBg = $loop->even ? '#F8FAFC' : '#fff'; @endphp
                                            <tr style="background:{{ $rowBg }}; transition:background .15s;"
                                                onmouseover="this.style.background='#EEF2FF'"
                                                onmouseout="this.style.background='{{ $rowBg }}'">

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $produk->firstItem() + $index }}
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                                    {{ $data->nama_produk }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                                    <span
                                                        style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                                        {{ $data->kategori }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                                    {{ $data->stok }}
                                                </td>

                                                <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">

                                                    @if ($data->foto)
                                                        <img src="{{ asset('storage/' . $data->foto) }}" alt="Gambar Produk"
                                                            width="80"
                                                            style="border-radius:8px; border:1.5px solid #E2E8F0;">
                                                    @else
                                                        <img src="{{ asset('images/default-image.png') }}"
                                                            alt="Gambar Produk" width="80"
                                                            style="border-radius:8px; border:1.5px solid #E2E8F0;">
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

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" role="dialog" aria-labelledby="modalTambahProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#2E7D32; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalTambahProdukLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-box"></i> Tambah Produk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data"
                    id="formTambahProduk">
                    @csrf

                    <div class="modal-body" style="padding:28px; background:#F8FAFC; max-height:70vh; overflow-y:auto;">
                        <div class="row">

                            <div class="col-md-6">

                                {{-- Nama Produk --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tag" style="color:#2E7D32;"></i> Nama Produk
                                    </label>
                                    <input type="text" name="nama_produk" placeholder="Masukkan nama produk" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tags" style="color:#2E7D32;"></i> Kategori Produk
                                    </label>
                                    <select name="kategori" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        <option value="Pertanian">Pertanian</option>
                                        <option value="Perkebunan">Perkebunan</option>
                                        <option value="Peternakan">Peternakan</option>
                                        <option value="Perikanan">Perikanan</option>
                                        <option value="Makanan & Minuman Olahan">Makanan & Minuman Olahan</option>
                                        <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                                        <option value="Produk Kesehatan & Kecantikan Alami">Produk Kesehatan & Kecantikan
                                            Alami</option>
                                        <option value="Peralatan & Perlengkapan Rumah">Peralatan & Perlengkapan Rumah
                                        </option>
                                        <option value="Pupuk & Produk Organik">Pupuk & Produk Organik</option>
                                        <option value="Pariwisata & Souvenir">Pariwisata & Souvenir</option>
                                    </select>
                                </div>

                                {{-- Harga --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-money-bill-wave" style="color:#2E7D32;"></i> Harga
                                    </label>
                                    <input type="number" name="harga" placeholder="Harga produk" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Stok --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-boxes" style="color:#2E7D32;"></i> Stok
                                    </label>
                                    <input type="number" name="stok" placeholder="Jumlah stok tersedia" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            <div class="col-md-6">

                                {{-- Asal Desa --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-map-marker-alt" style="color:#2E7D32;"></i> Asal Desa
                                    </label>
                                    <input type="text" name="asal_desa" placeholder="Nama desa asal produk" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Foto --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#2E7D32;"></i> Foto Produk
                                    </label>
                                    <input type="file" name="foto" accept="image/*"
                                        style="width:100%; padding:11px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">

                                    <img id="previewFotoProduk" src="#" alt="Preview Foto"
                                        style="display:none; margin-top:12px; max-width:150px; border-radius:10px; border:1.5px solid #E2E8F0; background:#fff; padding:6px;">
                                </div>

                                {{-- Kontak --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-phone-alt" style="color:#2E7D32;"></i> Kontak
                                    </label>
                                    <input type="text" name="kontak" placeholder="Nomor/WA penjual" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#2E7D32'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-align-left" style="color:#2E7D32;"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" placeholder="Deskripsi lengkap produk..." rows="4" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#2E7D32'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
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


    {{-- Modal Edit Produk --}}
    <div class="modal fade" id="modalEditProduk" tabindex="-1" role="dialog" aria-labelledby="modalEditProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"
                style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.15);">

                {{-- Header --}}
                <div class="modal-header" style="background:#F59E0B; padding:22px 28px; border:none;">
                    <h5 class="modal-title" id="modalEditProdukLabel"
                        style="font-size:22px; font-weight:700; color:#fff; display:flex; align-items:center; gap:10px; margin:0;">
                        <i class="fas fa-box-open"></i> Edit Produk
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.9; font-size:26px; text-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" id="formEditProduk">
                    @csrf
                    <input type="hidden" name="_method" value="PUT"> {{-- spoofing method PUT --}}
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body" style="padding:28px; background:#FFFBEB; max-height:70vh; overflow-y:auto;">
                        <div class="row">

                            <div class="col-md-6">

                                {{-- Nama Produk --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tag" style="color:#F59E0B;"></i> Nama Produk
                                    </label>
                                    <input type="text" name="nama_produk" id="edit_nama_produk" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-tags" style="color:#F59E0B;"></i> Kategori
                                    </label>
                                    <select name="kategori" id="edit_kategori" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Pertanian">Pertanian</option>
                                        <option value="Perkebunan">Perkebunan</option>
                                        <option value="Peternakan">Peternakan</option>
                                        <option value="Perikanan">Perikanan</option>
                                        <option value="Makanan & Minuman Olahan">Makanan & Minuman Olahan</option>
                                        <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                                        <option value="Produk Kesehatan & Kecantikan Alami">Produk Kesehatan & Kecantikan
                                            Alami</option>
                                        <option value="Peralatan & Perlengkapan Rumah">Peralatan & Perlengkapan Rumah
                                        </option>
                                        <option value="Pupuk & Produk Organik">Pupuk & Produk Organik</option>
                                        <option value="Pariwisata & Souvenir">Pariwisata & Souvenir</option>
                                    </select>
                                </div>

                                {{-- Harga --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-money-bill-wave" style="color:#F59E0B;"></i> Harga
                                    </label>
                                    <input type="number" name="harga" id="edit_harga" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Stok --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-boxes" style="color:#F59E0B;"></i> Stok
                                    </label>
                                    <input type="number" name="stok" id="edit_stok" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                            </div>

                            <div class="col-md-6">

                                {{-- Asal Desa --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-map-marker-alt" style="color:#F59E0B;"></i> Asal Desa
                                    </label>
                                    <input type="text" name="asal_desa" id="edit_asal_desa" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Kontak --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-phone" style="color:#F59E0B;"></i> Kontak
                                    </label>
                                    <input type="text" name="kontak" id="edit_kontak" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; height:48px; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s;"
                                        onfocus="this.style.borderColor='#F59E0B'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-align-left" style="color:#F59E0B;"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" id="edit_deskripsi" rows="4" required
                                        style="width:100%; padding:12px 14px; font-size:15px; color:#1E293B; border:1.5px solid #E2E8F0; border-radius:10px; background:#fff; outline:none; transition:border-color .15s; resize:vertical;"
                                        onfocus="this.style.borderColor='#F59E0B'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                                </div>

                                {{-- Foto --}}
                                <div class="form-group" style="margin-bottom:6px;">
                                    <label
                                        style="font-size:15px; font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                        <i class="fas fa-image" style="color:#F59E0B;"></i> Foto
                                    </label>
                                    <input type="file" name="foto" id="edit_foto" accept="image/*"
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
        // Ajax modal tambah produk
        $(document).ready(function() {
            $("#formTambahProduk").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.produk.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            text: 'Sedang memproses data produk',
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
                                text: 'Produk berhasil ditambahkan.',
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
                                    'Terjadi kesalahan saat menambahkan produk.',
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
            $("#formTambahProduk").on("submit", function(event) {
                let isValid = true;

                // Reset pesan error
                $(".text-danger").text("");

                $(this).find("input, select, textarea").each(function() {
                    if ($(this).prop("required") && $(this).val().trim() === "") {
                        isValid = false;
                        $(this).next(".text-danger").text("Kolom ini wajib diisi.");
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });

        //Ajax hapus data
        $(document).on("click", ".btn-hapus", function() {
            let id = $(this).data("id");
            let url = `/admin/produk/${id}`;

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

        // 🟢 AJAX Edit Produk
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data("id");

            $.ajax({
                url: `/admin/produk/${id}/edit`, // Ganti ke route edit produk
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data;

                        // Isi form modal
                        $("#formEditProduk").attr("action", `/admin/produk/${id}`);
                        $("#edit_id").val(data.id);
                        $("#edit_nama_produk").val(data.nama_produk);
                        $("#edit_slug").val(data.slug);
                        $("#edit_deskripsi").val(data.deskripsi);
                        $("#edit_harga").val(data.harga);
                        $("#edit_stok").val(data.stok);
                        $("#edit_kategori").val(data.kategori);
                        $("#edit_asal_desa").val(data.asal_desa);
                        $("#edit_kontak").val(data.kontak);

                        // Preview foto
                        if (data.foto_url) {
                            $("#editPreviewFoto").attr("src", data.foto_url).show();
                        } else {
                            $("#editPreviewFoto").hide();
                        }

                        // Tampilkan modal
                        $("#modalEditProduk").modal("show");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Data produk tidak ditemukan.",
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Gagal memuat data dari server.",
                    });
                },
            });
        });

        // 🟢 AJAX Submit Edit Produk
        $("#formEditProduk").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let id = $("#edit_id").val();

            $.ajax({
                url: `/admin/produk/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-HTTP-Method-Override": "PUT", // Untuk spoofing method PUT
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data produk berhasil diperbarui.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            $("#modalEditProduk").modal("hide");
                            $("#formEditProduk")[0].reset();
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

        // AJAX Search dan Pagination Produk
        $(document).ready(function() {

            let searchTimer = null;

            /*
            |--------------------------------------------------------------------------
            | Load Data Produk
            |--------------------------------------------------------------------------
            */
            function loadProduk(page = 1, search = '') {

                $.ajax({
                    url: "{{ route('admin.produk.paginate') }}",
                    type: "GET",

                    data: {
                        page: page,
                        search: search
                    },

                    success: function(response) {

                        let tbody = $('#produkTable tbody');
                        let paginationLinks = $('#paginationLinks');

                        // Kosongkan tabel dan pagination sebelumnya
                        tbody.empty();
                        paginationLinks.empty();

                        /*
                        |--------------------------------------------------------------------------
                        | Jika Data Produk Tidak Ditemukan
                        |--------------------------------------------------------------------------
                        */
                        if (!response.data || response.data.length === 0) {

                            tbody.append(`
                        <tr>
                            <td colspan="6"
                                style="padding:48px; text-align:center; color:#94A3B8; border:1.5px solid #CBD5E1;">
                                <i class="fas fa-box-open fa-2x mb-3" style="opacity:0.3; display:block;"></i>
                                <span style="font-size:15px; font-weight:500;">Data produk tidak ditemukan</span>
                            </td>
                        </tr>
                    `);

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Menampilkan Data Produk
                        |--------------------------------------------------------------------------
                        */
                        response.data.forEach(function(data, index) {

                            let rowBg = (index % 2 === 1) ? '#F8FAFC' : '#fff';

                            let fotoUrl = data.foto ?
                                `{{ asset('storage') }}/${data.foto}` :
                                `{{ asset('images/default-image.png') }}`;

                            let row = `
                        <tr style="background:${rowBg}; transition:background .15s;"
                            onmouseover="this.style.background='#EEF2FF'"
                            onmouseout="this.style.background='${rowBg}'">

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${response.from + index}
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:600; color:#0F172A; border:1.5px solid #CBD5E1;">
                                ${data.nama_produk}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <span style="display:inline-block; background:#EEF2FF; color:#3730A3; font-size:13px; font-weight:700; padding:5px 12px; border-radius:8px; letter-spacing:0.3px; border:1.5px solid #C7D2FE;">
                                    ${data.kategori ?? '-'}
                                </span>
                            </td>

                            <td style="padding:14px 18px; font-size:15px; font-weight:700; color:#334155; border:1.5px solid #CBD5E1; text-align:center;">
                                ${data.stok}
                            </td>

                            <td style="padding:14px 18px; border:1.5px solid #CBD5E1;">
                                <img src="${fotoUrl}" alt="Gambar Produk" width="80"
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

                                    <button type="button" class="btn-hapus" data-id="${data.id}" title="Hapus"
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

                            // Nomor halaman
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
                    | Jika AJAX Gagal
                    |--------------------------------------------------------------------------
                    */
                    error: function(xhr) {

                        console.error('Gagal memuat data produk:', xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat data produk.'
                        });
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Load Awal Data Produk
            |--------------------------------------------------------------------------
            */
            loadProduk();


            /*
            |--------------------------------------------------------------------------
            | Pencarian Produk (debounce, tetap lewat loadProduk yang sama)
            |--------------------------------------------------------------------------
            */
            $('#searchInput').on('keyup', function() {

                let search = $(this).val();

                clearTimeout(searchTimer);

                searchTimer = setTimeout(function() {
                    // Pencarian selalu dimulai dari halaman pertama
                    loadProduk(1, search);
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
                let search = $('#searchInput').val();

                loadProduk(page, search);
            });

        });
    </script>
@endsection
