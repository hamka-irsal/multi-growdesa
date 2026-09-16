<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aparat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AparatController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        // Query data aparat
        $query = Aparat::with('user');

        // Pencarian berdasarkan nama user atau nama lama di tabel aparat
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $aparat = $query->paginate($perPage);

        // Ambil user yang memiliki role aparat
        $users = User::where('role', 'aparat')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.aparat.index', compact(
            'aparat',
            'users',
            'perPage',
            'search'
        ));
    }

    public function searchAparat(Request $request)
    {
        try {
            $query = $request->input('query');

            // Pencarian hanya berdasarkan nama lengkap
            $aparat = Aparat::where('nama', 'jabatan', 'like', '%' . $query . '%')->get();

            return response()->json([
                'success' => true,
                'data' => $aparat
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian aparat:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Aparat::query();
        if (!empty($search)) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $aparat = $query->paginate($perPage);

        return response()->json($aparat);
    }

    public function store(Request $request)
    {
        try {
            Log::info('📥 Data masuk ke store():', $request->all());

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'jabatan' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('❌ Validasi gagal:', $validator->errors()->toArray());

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Ambil user dan pastikan role-nya aparat
            $user = User::where('id', $request->user_id)
                ->where('role', 'aparat')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'user_id' => ['User yang dipilih bukan merupakan aparat.']
                    ]
                ], 422);
            }

            // Cek apakah user sudah terdaftar sebagai aparat
            $existingAparat = Aparat::where('user_id', $user->id)->first();

            if ($existingAparat) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'user_id' => ['Aparat tersebut sudah terdaftar.']
                    ]
                ], 422);
            }

            DB::beginTransaction();

            $aparat = new Aparat();

            // Simpan ID user
            $aparat->user_id = $user->id;

            // Nama otomatis dari tabel users
            $aparat->nama = $user->name;

            // Simpan jabatan
            $aparat->jabatan = $request->jabatan;

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                $filename = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs(
                    'public/foto_aparat',
                    $filename
                );

                $aparat->foto = str_replace('public/', '', $path);
            }

            $aparat->save();

            DB::commit();

            Log::info('✅ Data aparat berhasil disimpan:', [
                'id' => $aparat->id,
                'user_id' => $user->id,
                'nama' => $user->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Aparat berhasil ditambahkan!',
                'data' => $aparat
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('❌ Kesalahan saat menyimpan data:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => ['Terjadi kesalahan, coba lagi!']
                ]
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $aparat = Aparat::with('user')->findOrFail($id);

            $data = [
                'id' => $aparat->id,
                'user_id' => $aparat->user_id,

                // Nama diambil dari users
                'nama' => $aparat->user
                    ? $aparat->user->name
                    : $aparat->nama,

                'jabatan' => $aparat->jabatan,

                'foto_url' => $aparat->foto
                    ? asset('storage/' . $aparat->foto)
                    : null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {

            Log::error('❌ Gagal mengambil data aparat untuk edit:', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data aparat tidak ditemukan.',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('📥 Request update aparat masuk:', [
            'id' => $id,
            'data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('❌ Validasi gagal saat update:', [
                'errors' => $validator->errors()->toArray()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            // Ambil aparat
            $aparat = Aparat::findOrFail($id);

            // Pastikan user yang dipilih benar-benar role aparat
            $user = User::where('id', $request->user_id)
                ->where('role', 'aparat')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'user_id' => [
                            'User yang dipilih bukan merupakan aparat.'
                        ]
                    ]
                ], 422);
            }

            // Cek apakah user tersebut sudah digunakan oleh aparat lain
            $existingAparat = Aparat::where('user_id', $user->id)
                ->where('id', '!=', $aparat->id)
                ->first();

            if ($existingAparat) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'user_id' => [
                            'Aparat tersebut sudah terdaftar pada data aparat lain.'
                        ]
                    ]
                ], 422);
            }

            // Update user_id
            $aparat->user_id = $user->id;

            // Nama otomatis dari users.name
            $aparat->nama = $user->name;

            // Update jabatan
            $aparat->jabatan = $request->jabatan;

            // Jika ada foto baru
            if ($request->hasFile('foto')) {

                // Hapus foto lama
                if ($aparat->foto) {
                    Storage::disk('public')->delete($aparat->foto);
                }

                // Upload foto baru
                $file = $request->file('foto');

                $filename = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs(
                    'public/foto_aparat',
                    $filename
                );

                $aparat->foto = str_replace(
                    'public/',
                    '',
                    $path
                );
            }

            // Simpan perubahan
            $aparat->save();

            Log::info('✅ Data aparat berhasil diperbarui:', [
                'id' => $aparat->id,
                'user_id' => $user->id,
                'nama' => $user->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data aparat berhasil diperbarui!',
                'data' => $aparat
            ]);
        } catch (\Exception $e) {

            Log::error('❌ Kesalahan saat update aparat:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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


    public function destroy($id)
    {
        $aparat = Aparat::find($id);
        if (!$aparat) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }
        if ($aparat->foto) {
            Storage::disk('public')->delete($aparat->foto);
        }
        $aparat->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
