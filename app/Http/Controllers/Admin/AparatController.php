<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aparat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AparatController extends Controller
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
     * Menampilkan daftar aparat berdasarkan desa.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Aparat::with('user')
            ->where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $aparat = $query->latest()->paginate($perPage);

        $users = User::where('desa_id', $desaId)
            ->where('role', 'aparat')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.aparat.index', compact(
            'aparat',
            'users',
            'perPage',
            'search'
        ));
    }

    /**
     * Pencarian aparat berdasarkan desa.
     */
    public function searchAparat(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();
            $search = $request->input('query', '');

            $aparat = Aparat::with('user')
                ->where('desa_id', $desaId)
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                })
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $aparat,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mencari aparat.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian aparat.',
            ], 500);
        }
    }

    /**
     * Pagination aparat berdasarkan desa.
     */
    public function paginate(Request $request)
    {
        $desaId = $this->currentDesaId();
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Aparat::with('user')
            ->where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return response()->json(
            $query->latest()->paginate($perPage)
        );
    }

    /**
     * Menambahkan aparat ke desa yang sedang dikelola.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Pastikan akun aparat berasal dari desa yang sama.
        $user = User::where('id', $request->user_id)
            ->where('desa_id', $desaId)
            ->where('role', 'aparat')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'user_id' => [
                        'Akun aparat tidak ditemukan pada desa Anda.'
                    ],
                ],
            ], 422);
        }

        // Cegah satu user terdaftar lebih dari sekali.
        $existingAparat = Aparat::where('desa_id', $desaId)
            ->where('user_id', $user->id)
            ->exists();

        if ($existingAparat) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'user_id' => [
                        'Aparat tersebut sudah terdaftar.'
                    ],
                ],
            ], 422);
        }

        try {
            $aparat = DB::transaction(function () use (
                $request,
                $desaId,
                $user
            ) {
                $aparat = new Aparat();

                // Tenant otomatis mengikuti akun yang login.
                $aparat->desa_id = $desaId;
                $aparat->user_id = $user->id;
                $aparat->nama = $user->name;
                $aparat->jabatan = $request->jabatan;

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');

                    $filename = time() . '_' .
                        uniqid() . '.' .
                        $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        'foto_aparat',
                        $filename,
                        'public'
                    );

                    $aparat->foto = $path;
                }

                $aparat->save();

                return $aparat;
            });

            return response()->json([
                'success' => true,
                'message' => 'Aparat berhasil ditambahkan!',
                'data' => $aparat,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan aparat.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan saat menyimpan aparat.'
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Mengambil data edit hanya dari desa yang sedang login.
     */
    public function edit($id)
    {
        try {
            $desaId = $this->currentDesaId();

            $aparat = Aparat::with('user')
                ->where('desa_id', $desaId)
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $aparat->id,
                    'user_id' => $aparat->user_id,
                    'nama' => $aparat->user?->name
                        ?? $aparat->nama,
                    'jabatan' => $aparat->jabatan,
                    'foto_url' => $aparat->foto
                        ? asset('storage/' . $aparat->foto)
                        : null,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data aparat tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data aparat untuk edit.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data aparat.',
            ], 500);
        }
    }

    /**
     * Memperbarui aparat dengan validasi desa.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cari aparat hanya di desa milik admin yang login.
        $aparat = Aparat::where('desa_id', $desaId)
            ->find($id);

        if (!$aparat) {
            return response()->json([
                'success' => false,
                'message' => 'Data aparat tidak ditemukan pada desa Anda.',
            ], 404);
        }

        // User yang dipilih juga harus berasal dari desa yang sama.
        $user = User::where('id', $request->user_id)
            ->where('desa_id', $desaId)
            ->where('role', 'aparat')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'user_id' => [
                        'Akun aparat tidak ditemukan pada desa Anda.'
                    ],
                ],
            ], 422);
        }

        // Pastikan user tidak digunakan oleh data aparat lain.
        $existingAparat = Aparat::where('desa_id', $desaId)
            ->where('user_id', $user->id)
            ->where('id', '!=', $aparat->id)
            ->exists();

        if ($existingAparat) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'user_id' => [
                        'Aparat tersebut sudah terdaftar pada data lain.'
                    ],
                ],
            ], 422);
        }

        try {
            DB::transaction(function () use (
                $request,
                $aparat,
                $user,
                $desaId
            ) {
                $aparat->desa_id = $desaId;
                $aparat->user_id = $user->id;
                $aparat->nama = $user->name;
                $aparat->jabatan = $request->jabatan;

                if ($request->hasFile('foto')) {
                    if ($aparat->foto) {
                        Storage::disk('public')->delete($aparat->foto);
                    }

                    $file = $request->file('foto');

                    $filename = time() . '_' .
                        uniqid() . '.' .
                        $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        'foto_aparat',
                        $filename,
                        'public'
                    );

                    $aparat->foto = $path;
                }

                $aparat->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Data aparat berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui aparat.', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan saat memperbarui aparat.'
                    ],
                ],
            ], 500);
        }
    }

    /**
     * Menghapus aparat hanya dari desa yang sedang login.
     */
    public function destroy($id)
    {
        $desaId = $this->currentDesaId();

        $aparat = Aparat::where('desa_id', $desaId)
            ->find($id);

        if (!$aparat) {
            return response()->json([
                'success' => false,
                'message' => 'Data aparat tidak ditemukan pada desa Anda.',
            ], 404);
        }

        try {
            if ($aparat->foto) {
                Storage::disk('public')->delete($aparat->foto);
            }

            $aparat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data aparat berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus aparat.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus aparat.',
            ], 500);
        }
    }
}
