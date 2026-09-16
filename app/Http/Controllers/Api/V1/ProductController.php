<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResource;
use App\Http\Resources\KategoriProductResource;
use App\Http\Resources\DetailProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Produk::query()
            ->when(request('search'), function ($query, $search) {
                $query->where(
                    'nama_produk',
                    'like',
                    "%{$search}%"
                );
            })
            ->when(request('kategori'), function ($query, $kategori) {
                $query->where(
                    'kategori',
                    $kategori
                );
            })
            ->latest()
            ->paginate(9)
            ->appends([
                'search' => request('search'),
                'kategori' => request('kategori'),
            ]);

        return ProductResource::collection($products)
            ->additional([
                'success' => true,
                'message' => 'List Data Produk',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Produk::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Detail Data Produk Tidak Ditemukan!',
                'data' => null,
            ], 404);
        }

        return (new DetailProductResource($product))
            ->additional([
                'success' => true,
                'message' => 'Detail Data Produk',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * categories - Ambil daftar kategori unik dari tabel produk
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $categories = Produk::query()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return KategoriProductResource::collection($categories)
            ->additional([
                'success' => true,
                'message' => 'List Kategori Produk',
            ]);
    }
}
