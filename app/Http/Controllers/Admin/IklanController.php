<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IklanController extends Controller
{
    /**
     * Menampilkan halaman iklan.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = strtolower($request->input('search', ''));

        $query = Iklan::query();

        if (in_array($search, ['aktif', 'active', '1'])) {
            $query->where('is_active', true);
        } elseif (in_array($search, ['nonaktif', 'tidak aktif', 'inactive', '0'])) {
            $query->where('is_active', false);
        }

        $iklans = $query
            ->latest()
            ->paginate($perPage);

        return view('admin.iklan.index', compact(
            'iklans',
            'perPage',
            'search'
        ));
    }

    /**
     * Mencari iklan menggunakan AJAX.
     */
    public function search(Request $request)
    {
        try {
            $search = strtolower(
                $request->input('query', '')
            );

            $query = Iklan::query();

            if (in_array($search, ['aktif', 'active', '1'])) {
                $query->where('is_active', true);
            } elseif (
                in_array(
                    $search,
                    ['nonaktif', 'tidak aktif', 'inactive', '0']
                )
            ) {
                $query->where('is_active', false);
            }

            $iklans = $query
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $iklans,
            ]);
        } catch (\Throwable $e) {
            Log::error('Kesalahan saat pencarian iklan', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian iklan.',
            ], 500);
        }
    }

    /**
     * Menampilkan data iklan dengan pagination.
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $iklans = Iklan::query()
            ->latest()
            ->paginate($perPage);

        return response()->json($iklans);
    }

    /**
     * Menambahkan iklan baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $path = $request
                ->file('image')
                ->store('iklan', 'public');

            $iklan = Iklan::create([
                'image' => $path,
                'is_active' => $request->boolean(
                    'is_active',
                    true
                ),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Iklan berhasil ditambahkan.',
                'data' => $iklan,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Kesalahan saat menyimpan iklan', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi.',
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Mengambil data iklan berdasarkan ID untuk edit.
     */
    public function edit($id)
    {
        $iklan = Iklan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $iklan->id,

                'image' => $iklan->image,

                'image_url' => $this->getImageUrl(
                    $iklan->image
                ),

                'is_active' => (bool) $iklan->is_active,
            ],
        ]);
    }

    /**
     * Memperbarui data iklan.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $iklan = Iklan::findOrFail($id);

            if ($request->hasFile('image')) {
                $this->deleteImage(
                    $iklan->image
                );

                $iklan->image = $request
                    ->file('image')
                    ->store('iklan', 'public');
            }

            $iklan->is_active = $request->boolean(
                'is_active'
            );

            $iklan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Iklan berhasil diperbarui.',
                'data' => $iklan,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Kesalahan saat memperbarui iklan', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi.',
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Menghapus iklan.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $iklan = Iklan::findOrFail($id);

            $this->deleteImage(
                $iklan->image
            );

            $iklan->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Iklan berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Kesalahan saat menghapus iklan', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus iklan.',
            ], 500);
        }
    }

    /**
     * Membuat URL gambar iklan.
     */
    private function getImageUrl(?string $image): ?string
    {
        if (empty($image)) {
            return null;
        }

        $image = trim($image);

        // Jika sudah berupa URL lengkap.
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Menghapus slash di bagian awal.
        $image = ltrim($image, '/');

        // Menghindari URL /storage/storage/...
        if (str_starts_with($image, 'storage/')) {
            $image = substr(
                $image,
                strlen('storage/')
            );
        }

        return Storage::disk('public')->url(
            $image
        );
    }

    /**
     * Menghapus file gambar dari storage.
     */
    private function deleteImage(?string $image): void
    {
        if (empty($image)) {
            return;
        }

        // URL eksternal tidak dihapus dari storage lokal.
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return;
        }

        $image = ltrim($image, '/');

        // Mendukung data lama yang menyimpan
        // path dengan awalan "storage/".
        if (str_starts_with($image, 'storage/')) {
            $image = substr(
                $image,
                strlen('storage/')
            );
        }

        Storage::disk('public')->delete(
            $image
        );
    }
}
