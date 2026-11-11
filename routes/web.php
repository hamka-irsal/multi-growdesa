<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route Landing Page
Route::get('/', [App\Http\Controllers\Landing\HomeController::class, 'index'])->name('landing.home');

//Route Profil
Route::get('/profil', [App\Http\Controllers\Landing\ProfilController::class, 'index'])->name('landing.profil.index');

//Route Statistik
Route::get('/statistik', [App\Http\Controllers\Landing\StatistikController::class, 'index'])->name('landing.statistik.index');

//Route Belanja
Route::get('/belanja', [App\Http\Controllers\Landing\BelanjaController::class, 'index'])->name('landing.belanja.index');
Route::get('/belanja/{id}', [App\Http\Controllers\Landing\BelanjaController::class, 'show'])->name('landing.belanja.show');

//Route Berita
Route::get('/berita', [App\Http\Controllers\Landing\BeritaController::class, 'index'])->name('landing.berita.index');
Route::get('/berita/{id}', [App\Http\Controllers\Landing\BeritaController::class, 'show'])->name('landing.berita.show');


//Route Surat
Route::get('/surat', [App\Http\Controllers\Landing\SuratController::class, 'index'])->name('landing.surat.index');
Route::post('/cek-nik', [App\Http\Controllers\Landing\SuratController::class, 'cekNIK']);

// Routes untuk Surat Kehilangan
Route::get('/surat/kehilangan', [App\Http\Controllers\Landing\SuratKehilanganController::class, 'formKehilangan'])->name('surat.kehilangan.form');
Route::post('/surat/kehilangan/store', [App\Http\Controllers\Landing\SuratKehilanganController::class, 'simpanKehilangan'])->name('surat.kehilangan.store');

// Routes untuk Surat Kematian
Route::get('/surat/kematian', [App\Http\Controllers\Landing\SuratKematianController::class, 'formKematian'])->name('surat.kematian.form');
Route::post('/surat/kematian/store', [App\Http\Controllers\Landing\SuratKematianController::class, 'simpanKematian'])->name('surat.kematian.store');

// Routes untuk Surat Usaha
Route::get('/surat/usaha', [App\Http\Controllers\Landing\SuratUsahaController::class, 'formUsaha'])->name('surat.usaha.form');
Route::post('/surat/usaha/store', [App\Http\Controllers\Landing\SuratUsahaController::class, 'simpanUsaha'])->name('surat.usaha.store');

// Routes untuk Surat Tidak Mampu
Route::get('/surat/tidak_mampu', [App\Http\Controllers\Landing\SuratTidakMampuController::class, 'FormTidakMampu'])->name('surat.tidak_mampu.form');
Route::post('/surat/tidak_mampu/store', [App\Http\Controllers\Landing\SuratTidakMampuController::class, 'simpanTidakMampu'])->name('surat.tidak_mampu.store');

// Routes untuk Surat Potong Hewan
Route::get('/surat/izin_potong', [App\Http\Controllers\Landing\SuratPotongHewanController::class, 'formPotongHewan'])->name('surat.potong_hewan.form');
Route::post('/surat/izin_potong/store', [App\Http\Controllers\Landing\SuratPotongHewanController::class, 'simpanPotongHewan'])->name('surat.potong_hewan.store');

// Routes untuk Surat Potong Hewan
Route::get('/surat/izin_pesta', [App\Http\Controllers\Landing\SuratPestaController::class, 'formPesta'])->name('surat.pesta.form');
Route::post('/surat/izin_pesta/store', [App\Http\Controllers\Landing\SuratPestaController::class, 'simpanPesta'])->name('surat.pesta.store');

//Route cetak
Route::get('/riwayat-surat/cetak/{id}', [App\Http\Controllers\Landing\RiwayatSuratController::class, 'cetak'])->name('landing.riwayat.cetak');

// Route riwayat surat
Route::get('/riwayat-surat', [App\Http\Controllers\Landing\RiwayatSuratController::class, 'index'])->name('landing.riwayat.form');
Route::post('/riwayat-surat/cek', [App\Http\Controllers\Landing\RiwayatSuratController::class, 'cekRiwayat'])->name('landing.riwayat.cek');
Route::get('/riwayat-surat/{nik}', [App\Http\Controllers\Landing\RiwayatSuratController::class, 'showRiwayat'])->name('landing.riwayat.show');



// Anjungan
Route::get('/anjungan', [App\Http\Controllers\Anjungan\HomeController::class, 'index'])->name('anjungan.home');
Route::get('/anjungan/surat', [App\Http\Controllers\Anjungan\SuratController::class, 'index'])->name('anjungan.surat.index');
Route::post('/anjungan/cek-identitas', [App\Http\Controllers\Anjungan\SuratController::class, 'cekIdentitas'])->name('anjungan.cek-nik');
Route::get('/anjungan/surat/{jenisSurat}', [App\Http\Controllers\Anjungan\SuratController::class, 'form'])->name('anjungan.surat.form');
Route::post('/anjungan/surat/{jenisSurat}', [App\Http\Controllers\Anjungan\SuratController::class, 'simpan'])->name('anjungan.surat.simpan');
Route::post('/anjungan/riwayat/cek-identitas', [App\Http\Controllers\Anjungan\RiwayatSuratController::class, 'cekIdentitas'])->name('anjungan.riwayat.cek-identitas');
Route::get('/anjungan/riwayat/cek/{identifier}', [App\Http\Controllers\Anjungan\RiwayatSuratController::class, 'showRiwayat'])->name('anjungan.riwayat.show');

//Route cetak surat anjungan
Route::get('/anjungan/riwayat/cetak/{id}', [App\Http\Controllers\Anjungan\RiwayatSuratController::class, 'cetak'])->name('anjungan.riwayat.cetak');



//Route Login
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


// Route Superadmin
Route::middleware('auth', 'role:superadmin')->group(function () {

    // Route Dashboard
    Route::get('/superadmin/dashboard', [App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('superadmin.dashboard.index');

    // Route Desa
    Route::get('/superadmin/desa', [App\Http\Controllers\Superadmin\DesaController::class, 'index'])->name('superadmin.desa.index');
    Route::get('/superadmin/desa/paginate', [App\Http\Controllers\Superadmin\DesaController::class, 'paginate'])->name('superadmin.desa.paginate');
    Route::get('/search-desa', [App\Http\Controllers\Superadmin\DesaController::class, 'searchDesa'])->name('superadmin.desa.search');
    Route::post('/superadmin/desa/store', [App\Http\Controllers\Superadmin\DesaController::class, 'store'])->name('superadmin.desa.store');
    Route::get('/superadmin/desa/{id}/edit', [App\Http\Controllers\Superadmin\DesaController::class, 'edit'])->name('superadmin.desa.edit');
    Route::put('/superadmin/desa/{id}', [App\Http\Controllers\Superadmin\DesaController::class, 'update'])->name('superadmin.desa.update');
    Route::delete('/superadmin/desa/{id}', [App\Http\Controllers\Superadmin\DesaController::class, 'destroy'])->name('superadmin.desa.destroy');

});


//Route Admin Desa
Route::middleware(['auth', 'role:admindesa,aparat'])->group(function () {
    //dashboard admin
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

    // notifikasi admin
    Route::get('/admin/notif/count', [App\Http\Controllers\Admin\NotifController::class, 'count'])->name('admin.notif.count');
    Route::get('/admin/notif/latest', [App\Http\Controllers\Admin\NotifController::class, 'latest'])->name('admin.notif.latest');

    //penduduk admin
    Route::get('/admin/penduduk', [App\Http\Controllers\Admin\PendudukController::class, 'index'])->name('admin.penduduk.index');
    Route::get('/admin/penduduk/paginate', [App\Http\Controllers\Admin\PendudukController::class, 'paginate'])->name('admin.penduduk.paginate');
    Route::get('/admin/search-penduduk', [App\Http\Controllers\Admin\PendudukController::class, 'searchPenduduk']);
    Route::get('/admin/penduduk/create', [App\Http\Controllers\Admin\PendudukController::class, 'create'])->name('admin.penduduk.create');
    Route::post('/admin/penduduk/store', [App\Http\Controllers\Admin\PendudukController::class, 'store'])->name('admin.penduduk.store');
    Route::get('/admin/penduduk/{id}', [App\Http\Controllers\Admin\PendudukController::class, 'show'])->name('admin.penduduk.detail');
    Route::get('/admin/penduduk/{id}/edit', [App\Http\Controllers\Admin\PendudukController::class, 'edit'])->name('admin.penduduk.edit');
    Route::put('/admin/penduduk/{id}', [App\Http\Controllers\Admin\PendudukController::class, 'update'])->name('admin.penduduk.update');
    Route::delete('/admin/penduduk/{id}', [App\Http\Controllers\Admin\PendudukController::class, 'destroy'])->name('admin.penduduk.destroy');

    // verifikasi pengguna admin
    Route::get('/admin/verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('admin.verifikasi.index');
    Route::get('/admin/verifikasi/paginate', [App\Http\Controllers\Admin\VerifikasiController::class, 'paginate'])->name('admin.verifikasi.paginate');
    Route::get('/admin/search-verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'search'])->name('admin.verifikasi.search');
    Route::post('/admin/verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'store'])->name('admin.verifikasi.store');
    Route::get('/admin/verifikasi/{id}', [App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('admin.verifikasi.detail');
    Route::put('/admin/verifikasi/{id}/status', [App\Http\Controllers\Admin\VerifikasiController::class, 'updateStatus'])->name('admin.verifikasi.update-status');
    Route::delete('/admin/verifikasi/{id}', [App\Http\Controllers\Admin\VerifikasiController::class, 'destroy'])->name('admin.verifikasi.destroy');

    //Aparat admin
    Route::get('/admin/aparat', [App\Http\Controllers\Admin\AparatController::class, 'index'])->name('admin.aparat.index');
    Route::get('/admin/aparat/paginate', [App\Http\Controllers\Admin\AparatController::class, 'paginate'])->name('admin.aparat.paginate');
    Route::get('/search-aparat', [App\Http\Controllers\Admin\AparatController::class, 'searchAparat']);
    Route::get('/admin/aparat/create', [App\Http\Controllers\Admin\AparatController::class, 'create'])->name('admin.aparat.create');
    Route::post('/admin/aparat/store', [App\Http\Controllers\Admin\AparatController::class, 'store'])->name('admin.aparat.store');
    Route::get('/admin/aparat/{id}', [App\Http\Controllers\Admin\AparatController::class, 'show'])->name('admin.aparat.detail');
    Route::get('/admin/aparat/{id}/edit', [App\Http\Controllers\Admin\AparatController::class, 'edit'])->name('admin.aparat.edit');
    Route::put('/admin/aparat/{id}', [App\Http\Controllers\Admin\AparatController::class, 'update'])->name('admin.aparat.update');
    Route::delete('/admin/aparat/{id}', [App\Http\Controllers\Admin\AparatController::class, 'destroy'])->name('admin.aparat.destroy');

    // Dusun admin
    Route::get('/admin/dusun', [App\Http\Controllers\Admin\DusunController::class, 'index'])->name('admin.dusun.index');
    Route::get('/admin/dusun/paginate', [App\Http\Controllers\Admin\DusunController::class, 'paginate'])->name('admin.dusun.paginate');
    Route::get('/search-dusun', [App\Http\Controllers\Admin\DusunController::class, 'searchDusun']);
    Route::get('/admin/dusun/create', [App\Http\Controllers\Admin\DusunController::class, 'create'])->name('admin.dusun.create');
    Route::post('/admin/dusun/store', [App\Http\Controllers\Admin\DusunController::class, 'store'])->name('admin.dusun.store');
    Route::get('/admin/dusun/{id}', [App\Http\Controllers\Admin\DusunController::class, 'show'])->name('admin.dusun.detail');
    Route::get('/admin/dusun/{id}/edit', [App\Http\Controllers\Admin\DusunController::class, 'edit'])->name('admin.dusun.edit');
    Route::put('/admin/dusun/{id}', [App\Http\Controllers\Admin\DusunController::class, 'update'])->name('admin.dusun.update');
    Route::delete('/admin/dusun/{id}', [App\Http\Controllers\Admin\DusunController::class, 'destroy'])->name('admin.dusun.destroy');

    // Kategori Berita Admin
    Route::get('/admin/kategori-berita', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'index'])->name('admin.kategori-berita.index');
    Route::get('/admin/kategori-berita/paginate', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'paginate'])->name('admin.kategori-berita.paginate');
    Route::get('/search-kategori-berita', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'search'])->name('admin.kategori-berita.search');
    Route::post('/admin/kategori-berita/store', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'store'])->name('admin.kategori-berita.store');
    Route::get('/admin/kategori-berita/{id}/edit', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'edit'])->name('admin.kategori-berita.edit');
    Route::put('/admin/kategori-berita/{id}', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'update'])->name('admin.kategori-berita.update');
    Route::delete('/admin/kategori-berita/{id}', [App\Http\Controllers\Admin\KategoriBeritaController::class, 'destroy'])->name('admin.kategori-berita.destroy');

    //Berita admin
    Route::get('/admin/berita', [App\Http\Controllers\Admin\BeritaController::class, 'index'])->name('admin.berita.index');
    Route::get('/admin/berita/paginate', [App\Http\Controllers\Admin\BeritaController::class, 'paginate'])->name('admin.berita.paginate');
    Route::get('/search-berita', [App\Http\Controllers\Admin\BeritaController::class, 'searchBerita']);
    Route::get('/admin/berita/create', [App\Http\Controllers\Admin\BeritaController::class, 'create'])->name('admin.berita.create');
    Route::post('/admin/berita/store', [App\Http\Controllers\Admin\BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('/admin/berita/{id}', [App\Http\Controllers\Admin\BeritaController::class, 'show'])->name('admin.berita.detail');
    Route::get('/admin/berita/{id}/edit', [App\Http\Controllers\Admin\BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('/admin/berita/{id}', [App\Http\Controllers\Admin\BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/admin/berita/{id}', [App\Http\Controllers\Admin\BeritaController::class, 'destroy'])->name('admin.berita.destroy');

    // APBDes Admin
    Route::get('/admin/apbdes', [App\Http\Controllers\Admin\ApbdesController::class, 'index'])->name('admin.apbdes.index');
    Route::get('/admin/apbdes/paginate', [App\Http\Controllers\Admin\ApbdesController::class, 'paginate'])->name('admin.apbdes.paginate');
    Route::get('/search-apbdes', [App\Http\Controllers\Admin\ApbdesController::class, 'search'])->name('admin.apbdes.search');
    Route::post('/admin/apbdes/store', [App\Http\Controllers\Admin\ApbdesController::class, 'store'])->name('admin.apbdes.store');
    Route::get('/admin/apbdes/{id}/edit', [App\Http\Controllers\Admin\ApbdesController::class, 'edit'])->name('admin.apbdes.edit');
    Route::put('/admin/apbdes/{id}', [App\Http\Controllers\Admin\ApbdesController::class, 'update'])->name('admin.apbdes.update');
    Route::delete('/admin/apbdes/{id}', [App\Http\Controllers\Admin\ApbdesController::class, 'destroy'])->name('admin.apbdes.destroy');

    // Iklan Admin
    Route::get('/admin/iklan', [App\Http\Controllers\Admin\IklanController::class, 'index'])->name('admin.iklan.index');
    Route::get('/admin/iklan/paginate', [App\Http\Controllers\Admin\IklanController::class, 'paginate'])->name('admin.iklan.paginate');
    Route::get('/search-iklan', [App\Http\Controllers\Admin\IklanController::class, 'search'])->name('admin.iklan.search');
    Route::post('/admin/iklan/store', [App\Http\Controllers\Admin\IklanController::class, 'store'])->name('admin.iklan.store');
    Route::get('/admin/iklan/{id}/edit', [App\Http\Controllers\Admin\IklanController::class, 'edit'])->name('admin.iklan.edit');
    Route::put('/admin/iklan/{id}', [App\Http\Controllers\Admin\IklanController::class, 'update'])->name('admin.iklan.update');
    Route::delete('/admin/iklan/{id}', [App\Http\Controllers\Admin\IklanController::class, 'destroy'])->name('admin.iklan.destroy');

    //Produk admin
    Route::get('/admin/produk', [App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('/paginate', [App\Http\Controllers\Admin\ProdukController::class, 'paginate'])->name('admin.produk.paginate');
    Route::get('/search-produk', [App\Http\Controllers\Admin\ProdukController::class, 'searchProduk']);
    Route::get('/admin/produk/create', [App\Http\Controllers\Admin\ProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('/admin/produk/store', [App\Http\Controllers\Admin\ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/admin/produk/{id}', [App\Http\Controllers\Admin\ProdukController::class, 'show'])->name('admin.produk.detail');
    Route::get('/admin/produk/{id}/edit', [App\Http\Controllers\Admin\ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('/admin/produk/{id}', [App\Http\Controllers\Admin\ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/admin/produk/{id}', [App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('admin.produk.destroy');

    // Route manajemen surat
    Route::get('/admin/surat/manajemen', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'index'])->name('admin.surat.manajemen');
    Route::get('/admin/surat/manajemen/paginate', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'paginate'])->name('admin.surat.manajemen.paginate');
    Route::post('/admin/surat/manajemen', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'store'])->name('admin.jenis-surat.store');
    Route::get('/admin/jenis-surat/{id}/edit', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'edit'])->name('admin.jenis-surat.edit');
    Route::put('/admin/jenis-surat/{id}', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'update'])->name('admin.jenis-surat.update');
    Route::delete('/admin/manajemen/{id}', [App\Http\Controllers\Admin\ManajemenSuratController::class, 'destroy'])->name('admin.surat.manajemen.destroy');

    //Route persetujuan surat
    Route::get('/admin/persetujuan', [App\Http\Controllers\Admin\PersetujuanController::class, 'index'])->name('admin.persetujuan.index');
    Route::get('/admin/persetujuan/paginate', [App\Http\Controllers\Admin\PersetujuanController::class, 'paginate'])->name('admin.persetujuan.paginate');
    Route::get('/admin/persetujuan/create', [App\Http\Controllers\Admin\PersetujuanController::class, 'create'])->name('admin.persetujuan.create');
    Route::post('/admin/persetujuan/store', [App\Http\Controllers\Admin\PersetujuanController::class, 'store'])->name('admin.persetujuan.store');
    Route::get('/admin/persetujuan/{id}', [App\Http\Controllers\Admin\PersetujuanController::class, 'show'])->name('admin.persetujuan.show');
    Route::get('/admin/persetujuan/{id}/edit', [App\Http\Controllers\Admin\PersetujuanController::class, 'edit'])->name('admin.persetujuan.edit');
    Route::put('/admin/persetujuan/{id}', [App\Http\Controllers\Admin\PersetujuanController::class, 'update'])->name('admin.persetujuan.update');
    Route::delete('/admin/persetujuan/{id}', [App\Http\Controllers\Admin\PersetujuanController::class, 'destroy'])->name('admin.persetujuan.destroy');

    // Route pengajuan surat
    Route::get('/admin/surat/pengajuan', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'index'])->name('admin.surat.pengajuan');
    Route::get('/admin/surat/paginate', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'paginate'])->name('admin.surat.paginate');
    Route::post('/admin/update-status-surat/{id}', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'updateStatus']);
    Route::get('/admin/surat/create', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'create'])->name('admin.surat.create');
    Route::post('/admin/surat', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'store'])->name('admin.surat.store');
    Route::delete('/admin/surat/{id}', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'destroy'])->name('admin.surat.destroy');

    // Route cetak  surat
    Route::get('/admin/pengajuan-surat/cetak/{id}', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'cetak'])->name('admin.surat.cetak');

    // User Admin
    Route::get('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/paginate', [App\Http\Controllers\Admin\UserController::class, 'paginate'])->name('admin.user.paginate');
    Route::post('/admin/user/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');

    // Profil Desa Admin
    Route::get('/admin/profil-desa', [App\Http\Controllers\Admin\ProfilDesaController::class, 'index'])->name('admin.profil-desa.index');
    Route::get('/admin/profil-desa/{id}/edit', [App\Http\Controllers\Admin\ProfilDesaController::class, 'edit'])->name('admin.profil-desa.edit');
    Route::put('/admin/profil-desa/{id}', [App\Http\Controllers\Admin\ProfilDesaController::class, 'update'])->name('admin.profil-desa.update');
});
