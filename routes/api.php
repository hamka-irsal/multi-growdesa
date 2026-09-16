<?php

use Illuminate\Support\Facades\Route;


//route login
Route::post('/auth/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'index']);
Route::post('/auth/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);

//group route with middleware "auth"
Route::group(['middleware' => 'auth:api'], function () {

    //logout
    Route::post('/logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
});

//group route with prefix "admin"
Route::prefix('v1')->group(function () {
    //group route with middleware "auth:api"
    Route::group(['middleware' => 'auth:api', 'user.verified'], function () {

        //home
        Route::get('/home', App\Http\Controllers\Api\V1\HomeController::class);

        // Lengkapi Data
        Route::get('/lengkapi-data', [App\Http\Controllers\Api\V1\LengkapiDataController::class, 'show']);
        Route::post('/lengkapi-data/step-1', [App\Http\Controllers\Api\V1\LengkapiDataController::class, 'updateStep1']);
        Route::post('/lengkapi-data/step-2', [App\Http\Controllers\Api\V1\LengkapiDataController::class, 'updateStep2']);
        Route::post('/lengkapi-data/step-3', [App\Http\Controllers\Api\V1\LengkapiDataController::class, 'updateStep3']);

        // Profil
        Route::get('/profil', [App\Http\Controllers\Api\V1\ProfilController::class, 'show']);
        Route::post('/profil', [App\Http\Controllers\Api\V1\ProfilController::class, 'update']);
        Route::delete('/profil/foto', [App\Http\Controllers\Api\V1\ProfilController::class, 'hapusFoto']);

        // Jenis Surat
        Route::get('/jenis-surat', [App\Http\Controllers\Api\V1\JenisSuratController::class, 'index']);

        // Surat dan Riwayat Surat
        Route::get('/surat', [App\Http\Controllers\Api\V1\SuratController::class, 'index']);
        Route::get('/surat/{id}', [App\Http\Controllers\Api\V1\SuratController::class, 'show']);
        Route::post('/surat', [App\Http\Controllers\Api\V1\SuratController::class, 'store']);

        //Categories berita
        Route::get('/categories', [App\Http\Controllers\Api\V1\KategoriBeritaController::class, 'index']);

        //Berita
        Route::get('/berita_home', [App\Http\Controllers\Api\V1\BeritaController::class, 'homePage']);
        Route::get('/berita', [App\Http\Controllers\Api\V1\BeritaController::class, 'index']);
        Route::get('/berita/{id}', [App\Http\Controllers\Api\V1\BeritaController::class, 'show']);

        //Iklan (Mobile)
        Route::get('/iklan', [App\Http\Controllers\Api\V1\IklanController::class, 'iklanAktif']);

        //Produk (Mobile)
        Route::get('/product-categories', [App\Http\Controllers\Api\V1\ProductController::class, 'categories']);
        Route::get('/product', [App\Http\Controllers\Api\V1\ProductController::class, 'index']);
        Route::get('/product/{id}', [App\Http\Controllers\Api\V1\ProductController::class, 'show']);

        // Notif (Mobile)
        Route::get('/notif', [App\Http\Controllers\Api\V1\MobileNotifController::class, 'index']);
        Route::delete('/notif', [App\Http\Controllers\Api\V1\MobileNotifController::class, 'destroyAll']);

        // Apbdes (Mobile)
        Route::get('/apbdes', [App\Http\Controllers\Api\V1\ApbdesController::class, 'index']);
    });
});

//group route with prefix "public"
Route::prefix('public')->group(function () {

    //index posts
    Route::get('/posts', [App\Http\Controllers\Api\Public\PostController::class, 'index']);

    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\Public\PostController::class, 'show']);

    //index posts home
    Route::get('/posts_home', [App\Http\Controllers\Api\Public\PostController::class, 'homePage']);

    //index products
    Route::get('/products', [App\Http\Controllers\Api\Public\ProductController::class, 'index']);

    //show page
    Route::get('/products/{slug}', [App\Http\Controllers\Api\Public\ProductController::class, 'show']);

    //index products home
    Route::get('/products_home', [App\Http\Controllers\Api\Public\ProductController::class, 'homePage']);

    //index pages
    Route::get('/pages', [App\Http\Controllers\Api\Public\PageController::class, 'index']);

    //show page
    Route::get('/pages/{slug}', [App\Http\Controllers\Api\Public\PageController::class, 'show']);

    //index aparaturs
    Route::get('/aparaturs', [App\Http\Controllers\Api\Public\AparaturController::class, 'index']);

    //index photos
    Route::get('/photos', [App\Http\Controllers\Api\Public\PhotoController::class, 'index']);

    //index sliders
    Route::get('/sliders', [App\Http\Controllers\Api\Public\SliderController::class, 'index']);
    Route::get('/iklan', [App\Http\Controllers\Api\V1\IklanController::class, 'iklanAktif']);
});
