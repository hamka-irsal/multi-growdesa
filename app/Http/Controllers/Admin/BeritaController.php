<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Menampilkan halaman data berita.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Berita::with('category');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        $berita = $query
            ->latest()
            ->paginate($perPage);

        // Data kategori untuk dropdown tambah dan edit berita
        $categories = Category::orderBy('name', 'asc')->get();

        return view(
            'admin.berita.index',
            compact(
                'berita',
                'categories',
                'perPage',
                'search'
            )
        );
    }


    /**
     * Pencarian berita.
     */
    public function search(Request $request)
    {
        try {

            $search = $request->input('query');

            $berita = Berita::with('category')
                ->where(function ($query) use ($search) {

                    $query->where(
                        'judul',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'penulis',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'category',
                            function ($categoryQuery) use ($search) {

                                $categoryQuery->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                })
                ->latest()
                ->get();


            return response()->json([

                'success' => true,

                'data' => $berita

            ]);
        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat pencarian berita:',
                [
                    'message' => $e->getMessage()
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                'Terjadi kesalahan saat pencarian berita!'

            ], 500);
        }
    }


    /**
     * Menampilkan data berita menggunakan AJAX pagination.
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input(
            'perPage',
            10
        );

        $search = $request->input(
            'search'
        );


        $query = Berita::with('category');


        if (!empty($search)) {

            $query->where(
                function ($query) use ($search) {

                    $query->where(
                        'judul',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'penulis',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'category',
                            function (
                                $categoryQuery
                            ) use (
                                $search
                            ) {

                                $categoryQuery->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                }
            );
        }


        $berita = $query
            ->latest()
            ->paginate($perPage);


        return response()->json(
            $berita
        );
    }


    /**
     * Menambahkan berita baru.
     */
    public function store(Request $request)
    {
        try {

            Log::info(
                '📥 Data masuk ke store() berita:',
                $request->all()
            );


            $validator = Validator::make(
                $request->all(),
                [

                    'judul' =>
                    'required|string|max:255',

                    'category_id' =>
                    'required|exists:categories,id',

                    'deskripsi' =>
                    'required|string',

                    'penulis' =>
                    'required|string|max:100',

                    'tanggal_publish' =>
                    'required|date',

                    'foto' =>
                    'nullable|image|mimes:jpeg,png,jpg|max:2048',

                ]
            );


            if ($validator->fails()) {

                Log::error(
                    '❌ Validasi berita gagal:',
                    $validator
                        ->errors()
                        ->toArray()
                );


                return response()->json([

                    'success' => false,

                    'errors' =>
                    $validator->errors()

                ], 422);
            }


            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | Membuat slug unik
            |--------------------------------------------------------------------------
            */
            $slug = Str::slug(
                $request->judul
            );

            $originalSlug = $slug;

            $counter = 1;


            while (
                Berita::where(
                    'slug',
                    $slug
                )->exists()
            ) {

                $slug =
                    $originalSlug .
                    '-' .
                    $counter;

                $counter++;
            }


            /*
            |--------------------------------------------------------------------------
            | Membuat data berita
            |--------------------------------------------------------------------------
            */
            $berita = new Berita();

            $berita->judul =
                $request->judul;

            $berita->slug =
                $slug;

            $berita->category_id =
                $request->category_id;

            $berita->deskripsi =
                $request->deskripsi;

            $berita->penulis =
                $request->penulis;

            $berita->tanggal_publish =
                $request->tanggal_publish;


            /*
            |--------------------------------------------------------------------------
            | Upload foto
            |--------------------------------------------------------------------------
            */
            if (
                $request->hasFile(
                    'foto'
                )
            ) {

                $file =
                    $request->file(
                        'foto'
                    );

                $filename =
                    time() .
                    '_' .
                    $file
                    ->getClientOriginalName();


                $path =
                    $file->storeAs(
                        'public/foto_berita',
                        $filename
                    );


                $berita->foto =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }


            $berita->save();


            DB::commit();


            Log::info(
                '✅ Berita berhasil disimpan:',
                [
                    'id' =>
                    $berita->id
                ]
            );


            return response()->json([

                'success' => true,

                'message' =>
                'Berita berhasil ditambahkan!',

                'data' =>
                $berita->load(
                    'category'
                )

            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                '❌ Kesalahan saat menyimpan berita:',
                [
                    'message' =>
                    $e->getMessage()
                ]
            );


            return response()->json([

                'success' => false,

                'errors' => [

                    'general' => [

                        'Terjadi kesalahan, coba lagi!'

                    ]

                ]

            ], 500);
        }
    }


    /**
     * Mengambil data berita untuk modal edit.
     */
    public function edit($id)
    {
        try {
            $berita = Berita::with('category')->findOrFail($id);

            $data = [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'category_id' => $berita->category_id,
                'deskripsi' => $berita->deskripsi,
                'penulis' => $berita->penulis,
                'tanggal_publish' => $berita->tanggal_publish
                    ? $berita->tanggal_publish->format('Y-m-d')
                    : null,
                'foto_url' => $berita->foto
                    ? asset('storage/' . $berita->foto)
                    : null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {

            Log::error('❌ Gagal memuat data edit berita:', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data berita.',
            ], 500);
        }
    }



    /**
     * Memperbarui data berita.
     */
    public function update(
        Request $request,
        $id
    ) {

        Log::info(
            '📥 Request update berita:',
            [

                'id' =>
                $id,

                'data' =>
                $request->all()

            ]
        );


        $validator = Validator::make(
            $request->all(),
            [

                'judul' =>
                'required|string|max:255',

                'category_id' =>
                'required|exists:categories,id',

                'deskripsi' =>
                'required|string',

                'penulis' =>
                'required|string|max:100',

                'tanggal_publish' =>
                'required|date',

                'foto' =>
                'nullable|image|mimes:jpeg,png,jpg|max:2048',

            ]
        );


        if (
            $validator->fails()
        ) {

            Log::error(
                '❌ Validasi gagal saat update berita:',
                $validator
                    ->errors()
                    ->toArray()
            );


            return response()->json([

                'success' => false,

                'errors' =>
                $validator->errors()

            ], 422);
        }


        try {

            DB::beginTransaction();


            $berita =
                Berita::findOrFail(
                    $id
                );


            /*
            |--------------------------------------------------------------------------
            | Membuat slug baru jika judul berubah
            |--------------------------------------------------------------------------
            */
            $slug =
                Str::slug(
                    $request->judul
                );


            $originalSlug =
                $slug;

            $counter =
                1;


            while (

                Berita::where(
                    'slug',
                    $slug
                )

                ->where(
                    'id',
                    '!=',
                    $berita->id
                )

                ->exists()

            ) {

                $slug =
                    $originalSlug .
                    '-' .
                    $counter;

                $counter++;
            }


            /*
            |--------------------------------------------------------------------------
            | Update data berita
            |--------------------------------------------------------------------------
            */
            $berita->judul =
                $request->judul;

            $berita->slug =
                $slug;

            $berita->category_id =
                $request->category_id;

            $berita->deskripsi =
                $request->deskripsi;

            $berita->penulis =
                $request->penulis;

            $berita->tanggal_publish =
                $request->tanggal_publish;


            /*
            |--------------------------------------------------------------------------
            | Update foto
            |--------------------------------------------------------------------------
            */
            if (
                $request->hasFile(
                    'foto'
                )
            ) {

                if (
                    $berita->foto
                ) {

                    Storage::disk(
                        'public'
                    )->delete(
                        $berita->foto
                    );
                }


                $file =
                    $request->file(
                        'foto'
                    );


                $filename =
                    time() .
                    '_' .
                    $file
                    ->getClientOriginalName();


                $path =
                    $file->storeAs(
                        'public/foto_berita',
                        $filename
                    );


                $berita->foto =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }


            $berita->save();


            DB::commit();


            Log::info(
                '✅ Berita berhasil diperbarui:',
                [
                    'id' =>
                    $berita->id
                ]
            );


            return response()->json([

                'success' => true,

                'message' =>
                'Berita berhasil diperbarui!',

                'data' =>
                $berita->load(
                    'category'
                )

            ]);
        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                '❌ Kesalahan saat update berita:',
                [
                    'message' =>
                    $e->getMessage()
                ]
            );


            return response()->json([

                'success' => false,

                'errors' => [

                    'general' => [

                        'Terjadi kesalahan, coba lagi!'

                    ]

                ]

            ], 500);
        }
    }


    /**
     * Menghapus berita.
     */
    public function destroy($id)
    {
        try {

            DB::beginTransaction();


            $berita =
                Berita::find(
                    $id
                );


            if (
                !$berita
            ) {

                return response()->json([

                    'success' =>
                    false,

                    'message' =>
                    'Data berita tidak ditemukan!'

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Hapus foto dari storage
            |--------------------------------------------------------------------------
            */
            if (
                $berita->foto
            ) {

                Storage::disk(
                    'public'
                )->delete(
                    $berita->foto
                );
            }


            $berita->delete();


            DB::commit();


            Log::info(
                '✅ Berita berhasil dihapus:',
                [
                    'id' =>
                    $id
                ]
            );


            return response()->json([

                'success' =>
                true,

                'message' =>
                'Berita berhasil dihapus.'

            ]);
        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                '❌ Kesalahan saat menghapus berita:',
                [
                    'message' =>
                    $e->getMessage()
                ]
            );


            return response()->json([

                'success' =>
                false,

                'message' =>
                'Terjadi kesalahan saat menghapus berita!'

            ], 500);
        }
    }
}
