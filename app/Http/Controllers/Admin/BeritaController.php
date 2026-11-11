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
     * Mengambil desa_id dari akun yang sedang login.
     */
    private function currentDesaId(): int
    {
        $desaId = auth()->user()?->desa_id;

        abort_unless(
            $desaId,
            403,
            'Akun tidak terhubung dengan desa.'
        );

        return (int) $desaId;
    }


    /**
     * Menampilkan halaman data berita.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        /*
        |--------------------------------------------------------------------------
        | Query berita berdasarkan desa
        |--------------------------------------------------------------------------
        */
        $query = Berita::with('category')
            ->where('desa_id', $desaId);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $berita = $query
            ->latest()
            ->paginate($perPage);

        /*
        |--------------------------------------------------------------------------
        | Data kategori
        |--------------------------------------------------------------------------
        */
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

            $desaId = $this->currentDesaId();

            $search = $request->input('query');

            /*
            |--------------------------------------------------------------------------
            | Hanya berita milik desa login
            |--------------------------------------------------------------------------
            */
            $berita = Berita::with('category')
                ->where('desa_id', $desaId)
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
                    'desa_id' => auth()->user()?->desa_id,
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
        $desaId = $this->currentDesaId();

        $perPage = $request->input(
            'perPage',
            10
        );

        $search = $request->input(
            'search'
        );

        /*
        |--------------------------------------------------------------------------
        | Query berdasarkan desa
        |--------------------------------------------------------------------------
        */
        $query = Berita::with('category')
            ->where('desa_id', $desaId);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
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
        $desaId = $this->currentDesaId();

        try {

            Log::info(
                '📥 Data masuk ke store() berita:',
                [
                    'desa_id' => $desaId,
                    'data' => $request->all()
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Validasi
            |--------------------------------------------------------------------------
            */
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
            | Membuat slug unik berdasarkan desa
            |--------------------------------------------------------------------------
            */
            $slug = Str::slug(
                $request->judul
            );

            $originalSlug = $slug;

            $counter = 1;

            while (
                Berita::where(
                    'desa_id',
                    $desaId
                )
                    ->where(
                        'slug',
                        $slug
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
            | Membuat data berita
            |--------------------------------------------------------------------------
            */
            $berita = new Berita();

            // desa_id dari akun login
            $berita->desa_id =
                $desaId;

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
                    $file->getClientOriginalName();

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
                        $berita->id,

                    'desa_id' =>
                        $berita->desa_id,

                    'tahun' =>
                        $berita->tanggal_publish
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
                    'desa_id' => $desaId,
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

            $desaId = $this->currentDesaId();

            /*
            |--------------------------------------------------------------------------
            | Hanya boleh mengambil berita dari desa sendiri
            |--------------------------------------------------------------------------
            */
            $berita = Berita::with('category')
                ->where('desa_id', $desaId)
                ->findOrFail($id);

            $data = [

                'id' =>
                    $berita->id,

                'judul' =>
                    $berita->judul,

                'slug' =>
                    $berita->slug,

                'category_id' =>
                    $berita->category_id,

                'deskripsi' =>
                    $berita->deskripsi,

                'penulis' =>
                    $berita->penulis,

                'tanggal_publish' =>
                    $berita->tanggal_publish
                        ? $berita->tanggal_publish->format('Y-m-d')
                        : null,

                'foto_url' =>
                    $berita->foto
                        ? asset(
                            'storage/' .
                            $berita->foto
                        )
                        : null,
            ];

            return response()->json([

                'success' => true,

                'data' => $data,

            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Gagal memuat data edit berita:',
                [
                    'id' => $id,
                    'desa_id' => auth()->user()?->desa_id,
                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal memuat data berita.',

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

        $desaId = $this->currentDesaId();

        Log::info(
            '📥 Request update berita:',
            [

                'id' =>
                    $id,

                'desa_id' =>
                    $desaId,

                'data' =>
                    $request->all()

            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */
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

            /*
            |--------------------------------------------------------------------------
            | Ambil berita hanya dari desa login
            |--------------------------------------------------------------------------
            */
            $berita =
                Berita::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
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
                    'desa_id',
                    $desaId
                )
                    ->where(
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
            $berita->desa_id =
                $desaId;

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

                /*
                |--------------------------------------------------------------------------
                | Hapus foto lama
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

                $file =
                    $request->file(
                        'foto'
                    );

                $filename =
                    time() .
                    '_' .
                    $file->getClientOriginalName();

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
                        $berita->id,

                    'desa_id' =>
                        $berita->desa_id
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
                    'id' => $id,
                    'desa_id' => $desaId,
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

            $desaId = $this->currentDesaId();

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Hanya boleh menghapus berita dari desa sendiri
            |--------------------------------------------------------------------------
            */
            $berita =
                Berita::where(
                    'desa_id',
                    $desaId
                )
                    ->find(
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
                        $id,

                    'desa_id' =>
                        $desaId
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
                    'id' => $id,
                    'desa_id' => auth()->user()?->desa_id,
                    'message' =>
                        $e->getMessage()
                ]
            );

            return response()->json([

                'success' => false,

                'message' =>
                    'Terjadi kesalahan saat menghapus berita!'

            ], 500);
        }
    }
}