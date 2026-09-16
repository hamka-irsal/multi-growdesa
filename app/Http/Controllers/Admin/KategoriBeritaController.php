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
     * Menampilkan halaman kategori.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Category::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        $categories = $query
            ->latest()
            ->paginate($perPage);

        return view(
            'admin.kategori-berita.index',
            compact('categories', 'perPage', 'search')
        );
    }

    /**
     * Mencari kategori menggunakan AJAX.
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $categories = Category::where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian kategori:', [
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
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Category::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
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
        try {
            Log::info('📥 Data masuk ke store() kategori:', $request->all());

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
                'slug' => 'nullable|string|max:255|unique:categories,slug',
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

            DB::beginTransaction();

            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->filled('slug')
                    ? Str::slug($request->slug)
                    : Str::slug($request->name),
            ]);

            DB::commit();

            Log::info('✅ Kategori berhasil disimpan:', [
                'id' => $category->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => $category,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat menyimpan kategori:', [
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
        $category = Category::findOrFail($id);

        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        Log::info('📥 Request update kategori:', [
            'id' => $id,
            'data' => $request->all(),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
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
            DB::beginTransaction();

            $category = Category::findOrFail($id);

            $category->update([
                'name' => $request->name,
                'slug' => $request->filled('slug')
                    ? Str::slug($request->slug)
                    : Str::slug($request->name),
            ]);

            DB::commit();

            Log::info('✅ Kategori berhasil diperbarui:', [
                'id' => $category->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui!',
                'data' => $category,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat update kategori:', [
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
            DB::beginTransaction();

            $category = Category::find($id);

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
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Kesalahan saat menghapus kategori:', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori!',
            ], 500);
        }
    }
}
