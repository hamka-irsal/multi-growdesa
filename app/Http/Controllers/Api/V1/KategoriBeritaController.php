<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriBeritaResource;
use App\Models\Category;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        $data = collect([
            [
                'id' => null,
                'name' => 'Semua',
                'slug' => 'semua',
            ],
        ])->merge(
            KategoriBeritaResource::collection($categories)->resolve()
        );

        return response()->json([
            'success' => true,
            'message' => 'Kategori berita berhasil diambil',
            'data' => $data,
        ]);
    }
}
