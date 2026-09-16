<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\DetailBeritaResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    /**
     * index
     *
     * @return BeritaResource
     */
    public function index()
    {
        $berita = Berita::with('category')
            ->when(request()->search, function ($query) {
                $query->where(
                    'judul',
                    'like',
                    '%' . request()->search . '%'
                );
            })
            ->when(request()->category, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where(
                        'slug',
                        request()->category
                    );
                });
            })
            ->latest('tanggal_publish')
            ->paginate(10);

        $berita->appends([
            'search' => request()->search,
            'category' => request()->category,
        ]);

        return BeritaResource::collection($berita)
            ->additional([
                'success' => true,
                'message' => 'List Data Berita',
            ]);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return BeritaResource
     */

    /**
     * show
     *
     * @param  mixed $id
     * @return BeritaResource
     */
    public function show($id)
    {
        $berita = Berita::with('category')->find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Detail Data Berita Tidak Ditemukan!',
                'data' => null,
            ], 404);
        }

        return (new DetailBeritaResource($berita))
            ->additional([
                'success' => true,
                'message' => 'Detail Data Berita',
            ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $berita
     * @return BeritaResource
     */

    /**
     * homePage
     *
     * @return BeritaResource
     */
    public function homePage()
    {
        $berita = Berita::with('category')->latest()->take(6)->get();

        return new BeritaResource(true, 'List Data Berita HomePage', $berita);
    }
}
