<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    /**
     * Mengambil desa_id dari user yang sedang login.
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
     * Menampilkan halaman kategori.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Category::where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query
            ->latest()
            ->paginate($perPage);

        return view(
            'admin.kategori-berita.index',
            compact(
                'categories',
                'perPage',
                'search'
            )
        );
    }

    /**
     * Mencari kategori menggunakan AJAX.
     */
    public function search(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();

            $query = $request->input('query');

            $categories = Category::where('desa_id', $desaId)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('slug', 'like', "%{$query}%");
                })
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat pencarian kategori:', [
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian kategori!',
            ], 500);
        }
    }

    /**
     * Menampilkan data kategori dengan pagination.
     */
    public function paginate(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Category::where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query
            ->latest()
            ->paginate($perPage);

        return response()->json($categories);
    }

    /**
     * Menambahkan kategori baru.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        try {
            Log::info('📥 Data masuk ke store() kategori:', [
                'desa_id' => $desaId,
                'data' => $request->all(),
            ]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::error(
                    '❌ Validasi kategori gagal:',
                    $validator->errors()->toArray()
                );

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $slug = $request->filled('slug')
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            /**
             * Cek nama kategori hanya pada desa yang sedang login.
             */
            $existingName = Category::where('desa_id', $desaId)
                ->where('name', $request->name)
                ->first();

            if ($existingName) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'name' => [
                            'Nama kategori tersebut sudah digunakan.'
                        ],
                    ],
                ], 422);
            }

            /**
             * Cek slug hanya pada desa yang sedang login.
             */
            $existingSlug = Category::where('desa_id', $desaId)
                ->where('slug', $slug)
                ->first();

            if ($existingSlug) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'slug' => [
                            'Slug kategori tersebut sudah digunakan.'
                        ],
                    ],
                ], 422);
            }

            DB::beginTransaction();

            $category = Category::create([
                'desa_id' => $desaId,
                'name' => $request->name,
                'slug' => $slug,
            ]);

            DB::commit();

            Log::info('✅ Kategori berhasil disimpan:', [
                'id' => $category->id,
                'desa_id' => $category->desa_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => $category,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat menyimpan kategori:', [
                'desa_id' => $desaId,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!',
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Mengambil data kategori berdasarkan ID untuk edit.
     */
    public function edit($id)
    {
        try {
            $desaId = $this->currentDesaId();

            $category = Category::where('desa_id', $desaId)
                ->findOrFail($id);

            $data = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Gagal mengambil kategori untuk edit:', [
                'id' => $id,
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan.',
            ], 404);
        }
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        Log::info('📥 Request update kategori:', [
            'id' => $id,
            'desa_id' => $desaId,
            'data' => $request->all(),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error(
                '❌ Validasi gagal saat update kategori:',
                $validator->errors()->toArray()
            );

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            /**
             * Hanya mengambil kategori
             * milik desa yang sedang login.
             */
            $category = Category::where('desa_id', $desaId)
                ->findOrFail($id);

            $slug = $request->filled('slug')
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            /**
             * Cek nama kategori pada desa yang sama,
             * kecuali data yang sedang diedit.
             */
            $existingName = Category::where('desa_id', $desaId)
                ->where('name', $request->name)
                ->where('id', '!=', $category->id)
                ->first();

            if ($existingName) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'name' => [
                            'Nama kategori tersebut sudah digunakan.'
                        ],
                    ],
                ], 422);
            }

            /**
             * Cek slug pada desa yang sama,
             * kecuali data yang sedang diedit.
             */
            $existingSlug = Category::where('desa_id', $desaId)
                ->where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->first();

            if ($existingSlug) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'slug' => [
                            'Slug kategori tersebut sudah digunakan.'
                        ],
                    ],
                ], 422);
            }

            DB::beginTransaction();

            $category->desa_id = $desaId;
            $category->name = $request->name;
            $category->slug = $slug;
            $category->save();

            DB::commit();

            Log::info('✅ Kategori berhasil diperbarui:', [
                'id' => $category->id,
                'desa_id' => $category->desa_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui!',
                'data' => $category,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat update kategori:', [
                'id' => $id,
                'desa_id' => $desaId,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!',
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Menghapus kategori.
     */
    public function destroy($id)
    {
        try {
            $desaId = $this->currentDesaId();

            DB::beginTransaction();

            /**
             * Hanya boleh menghapus kategori
             * milik desa yang sedang login.
             */
            $category = Category::where('desa_id', $desaId)
                ->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori tidak ditemukan!',
                ], 404);
            }

            $category->delete();

            DB::commit();

            Log::info('✅ Kategori berhasil dihapus:', [
                'id' => $id,
                'desa_id' => $desaId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat menghapus kategori:', [
                'id' => $id,
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori!',
            ], 500);
        }
    }
}