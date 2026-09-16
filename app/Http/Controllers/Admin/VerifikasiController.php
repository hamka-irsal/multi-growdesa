<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerifikasiController extends Controller
{
    /**
     * Menampilkan halaman verifikasi pengguna.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $status = $request->input('status');
        $role = $request->input('role');

        // Ambil user dengan role penduduk dan aparat
        $query = User::with(['penduduk', 'aparat'])
            ->whereIn('role', ['penduduk', 'aparat']);

        // Filter berdasarkan pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status verifikasi
        if (!empty($status)) {
            $query->where('status_verifikasi', $status);
        }

        // Filter berdasarkan role
        if (!empty($role) && in_array($role, ['penduduk', 'aparat'])) {
            $query->where('role', $role);
        }

        // Pagination
        $users = $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.verifikasi.index',
            compact(
                'users',
                'perPage',
                'search',
                'status',
                'role'
            )
        );
    }

    /**
     * Menambahkan pengguna baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',

            'nik' => 'required|string|max:16|unique:users,nik',

            'email' => 'required|email|max:255|unique:users,email',

            'level' => 'required|in:penduduk,aparat',

            'password' => 'required|string|min:8|confirmed',

        ], [

            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.max' => 'NIK maksimal 16 karakter.',
            'nik.unique' => 'NIK sudah terdaftar.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'level.required' => 'Role wajib dipilih.',
            'level.in' => 'Role yang dipilih tidak valid.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | 1. SIMPAN USER
        |--------------------------------------------------------------------------
        */

            $user = User::create([
                'name' => $request->name,
                'nik' => $request->nik,
                'email' => $request->email,

                // Role mengikuti pilihan form
                'role' => $request->level,

                // HAPUS jika kolom level tidak ada di tabel users
                // 'level' => $request->level,

                'password' => Hash::make($request->password),

                'status_verifikasi' => 'pending',
            ]);


            /*
        |--------------------------------------------------------------------------
        | 2. SIMPAN DATA PENDUDUK
        |--------------------------------------------------------------------------
        |
        | Data lainnya akan dilengkapi melalui fitur Lengkapi Data.
        |
        */

            $penduduk = new Penduduk();

            $penduduk->user_id = $user->id;
            $penduduk->nik = $user->nik;
            $penduduk->nama_lengkap = $user->name;

            // Data sementara sampai dilengkapi
            $penduduk->pendidikan = '-';
            $penduduk->tempat_lahir = '-';
            $penduduk->jenis_pekerjaan = '-';
            $penduduk->agama = '-';
            $penduduk->status_perkawinan = '-';
            $penduduk->status_hubungan_dalam_keluarga = '-';

            $penduduk->alamat = '-';
            $penduduk->desa_kelurahan = '-';
            $penduduk->kecamatan = '-';
            $penduduk->kabupaten_kota = '-';
            $penduduk->provinsi = '-';

            $penduduk->kewarganegaraan = 'Indonesia';

            $penduduk->ayah = '-';
            $penduduk->ibu = '-';

            $penduduk->save();


            /*
        |--------------------------------------------------------------------------
        | 3. COMMIT
        |--------------------------------------------------------------------------
        */

            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | 4. LOG
        |--------------------------------------------------------------------------
        */

            Log::info(
                'User dan data penduduk berhasil ditambahkan.',
                [
                    'user_id' => $user->id,
                    'penduduk_id' => $penduduk->id,
                    'name' => $user->name,
                    'nik' => $user->nik,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status_verifikasi' => $user->status_verifikasi,
                ]
            );


            /*
        |--------------------------------------------------------------------------
        | 5. RESPONSE
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil ditambahkan.',
                'data' => [
                    'id' => $user->id,
                    'penduduk_id' => $penduduk->id,
                    'name' => $user->name,
                    'nik' => $user->nik,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status_verifikasi' => $user->status_verifikasi,
                ],
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error(
                'Gagal menambahkan user dan penduduk.',
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan pengguna.',
                // Untuk sementara bisa dibuka saat debugging
                // 'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Pencarian data pengguna untuk AJAX.
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $users = User::with('penduduk')
                ->where('role', 'penduduk')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%')
                        ->orWhere('nik', 'like', '%' . $query . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian verifikasi pengguna:', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian pengguna.',
            ], 500);
        }
    }

    /**
     * Pagination data verifikasi untuk AJAX.
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $status = $request->input('status');
        $role = $request->input('role');

        // Ambil user dengan role penduduk dan aparat
        $query = User::with(['penduduk', 'aparat'])
            ->whereIn('role', ['penduduk', 'aparat']);

        // Filter pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter status verifikasi
        if (!empty($status)) {
            $query->where('status_verifikasi', $status);
        }

        // Filter role
        if (!empty($role) && in_array($role, ['penduduk', 'aparat'])) {
            $query->where('role', $role);
        }

        // Pagination
        $users = $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Menampilkan detail pengguna dan data penduduk.
     */
    public function show($id)
    {
        try {
            $user = User::with('penduduk')
                ->where('role', 'penduduk')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nik' => $user->nik,
                    'role' => $user->role,
                    'level' => $user->level,
                    'status_verifikasi' => $user->status_verifikasi,
                    'created_at' => $user->created_at
                        ? $user->created_at->format('d-m-Y H:i')
                        : null,

                    'penduduk' => $user->penduduk,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat mengambil detail verifikasi:', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data pengguna tidak ditemukan.',
            ], 404);
        }
    }

    /**
     * Mengubah status verifikasi pengguna.
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ], [
            'status_verifikasi.required' => 'Status verifikasi wajib dipilih.',
            'status_verifikasi.in' => 'Status verifikasi tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            // Ambil user dengan role penduduk ATAU aparat
            $user = User::whereIn('role', ['penduduk', 'aparat'])
                ->findOrFail($id);

            // Update status verifikasi
            $user->update([
                'status_verifikasi' => $request->status_verifikasi,
            ]);

            Log::info('Status verifikasi berhasil diperbarui', [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'status_verifikasi' => $user->status_verifikasi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status verifikasi berhasil diperbarui.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'status_verifikasi' => $user->status_verifikasi,
                ],
            ], 200);
        } catch (\Exception $e) {

            Log::error('Gagal mengubah status verifikasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    /**
     * Menghapus pengguna verifikasi.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Cari user penduduk atau aparat
        |--------------------------------------------------------------------------
        */
            $user = User::whereIn('role', ['penduduk', 'aparat'])
                ->findOrFail($id);


            /*
        |--------------------------------------------------------------------------
        | Simpan informasi untuk log sebelum user dihapus
        |--------------------------------------------------------------------------
        */
            $userInfo = [
                'id' => $user->id,
                'name' => $user->name,
                'nik' => $user->nik,
                'email' => $user->email,
                'role' => $user->role,
            ];


            /*
        |--------------------------------------------------------------------------
        | Hapus data penduduk jika ada
        |--------------------------------------------------------------------------
        */
            if ($user->penduduk) {
                $user->penduduk->delete();
            }


            /*
        |--------------------------------------------------------------------------
        | Jika user memiliki data aparat, hapus juga
        |--------------------------------------------------------------------------
        |
        | Ini diperlukan jika akun tersebut sudah pernah
        | dibuat sebagai aparat di tabel aparat.
        |
        */
            if ($user->aparat) {
                $user->aparat->delete();
            }


            /*
        |--------------------------------------------------------------------------
        | Hapus user
        |--------------------------------------------------------------------------
        */
            $user->delete();


            /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */
            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | Log
        |--------------------------------------------------------------------------
        */
            Log::info(
                '✅ Pengguna verifikasi berhasil dihapus:',
                $userInfo
            );


            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error(
                '❌ Gagal menghapus pengguna verifikasi:',
                [
                    'id' => $id,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );


            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus pengguna.'
            ], 500);
        }
    }
}
