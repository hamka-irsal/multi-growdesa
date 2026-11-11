<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DesaController extends Controller
{
    /**
     * Menampilkan daftar desa
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Desa::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('kode_desa', 'like', "%{$search}%");
            });
        }

        $desa = $query
            ->latest()
            ->paginate($perPage);

        return view('superadmin.desa.index', compact(
            'desa',
            'perPage',
            'search'
        ));
    }

    /**
     * Pencarian desa
     */
    public function searchDesa(Request $request)
    {
        try {
            $query = $request->input('query');

            $desa = Desa::where(function ($q) use ($query) {
                $q->where('nama_desa', 'like', '%' . $query . '%')
                    ->orWhere('domain', 'like', '%' . $query . '%')
                    ->orWhere('kecamatan', 'like', '%' . $query . '%')
                    ->orWhere('kabupaten', 'like', '%' . $query . '%')
                    ->orWhere('kode_desa', 'like', '%' . $query . '%');
            })
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $desa
            ]);
        } catch (\Exception $e) {

            Log::error('Kesalahan saat pencarian desa:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    /**
     * Pagination data desa
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Desa::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('kode_desa', 'like', "%{$search}%");
            });
        }

        $desa = $query
            ->latest()
            ->paginate($perPage);

        return response()->json($desa);
    }

    /**
     * Menyimpan desa + akun admindesa
     */
    public function store(Request $request)
    {
        Log::info('Request tambah desa:', $request->all());

        $validator = Validator::make($request->all(), [
            'nama_desa' => 'required|string|max:255',

            'domain' => [
                'required',
                'string',
                'max:255',
                'unique:desa,domain',
            ],

            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',

            'kode_desa' => [
                'nullable',
                'string',
                'max:255',
                'unique:desa,kode_desa',
            ],

            'status' => 'nullable|boolean',

            // Data akun admindesa
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | 1. BUAT DESA
        |--------------------------------------------------------------------------
        */

            $desa = Desa::create([
                'nama_desa' => $request->nama_desa,
                'domain' => $request->domain,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'kode_desa' => $request->kode_desa,
                'status' => $request->has('status')
                    ? $request->boolean('status')
                    : true,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 2. BUAT PROFIL DESA
        |--------------------------------------------------------------------------
        |
        | Identitas desa dari tabel desa langsung disalin ke profil_desa.
        |
        */

            $profilDesa = ProfilDesa::create([
                'desa_id' => $desa->id,

                'nama_desa' => $desa->nama_desa,
                'kecamatan' => $desa->kecamatan,
                'kabupaten' => $desa->kabupaten,
                'provinsi' => $desa->provinsi,

                // Belum tersedia pada form Desa
                'kode_pos' => '-',

                // Field wajib pada profil_desa
                'nama_kepdes' => '-',
                'kontak_sekdes' => '-',
                'kontak_babinsa' => '-',
                'kontak_bhabinkamtibmas' => '-',
            ]);


            /*
        |--------------------------------------------------------------------------
        | 3. CARI / BUAT ROLE ADMINDESA
        |--------------------------------------------------------------------------
        */

            $admindesaRole = Role::firstOrCreate([
                'name' => 'admindesa',
                'guard_name' => 'api',
            ]);


            /*
        |--------------------------------------------------------------------------
        | 4. BUAT USER ADMINDESA
        |--------------------------------------------------------------------------
        */

            $admindesa = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),

                'desa_id' => $desa->id,

                'role' => 'admindesa',
                'status_verifikasi' => 'disetujui',
            ]);


            /*
        |--------------------------------------------------------------------------
        | 5. ASSIGN ROLE SPATIE
        |--------------------------------------------------------------------------
        */

            $admindesa->assignRole($admindesaRole);


            /*
        |--------------------------------------------------------------------------
        | 6. COMMIT
        |--------------------------------------------------------------------------
        */

            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | 7. LOG
        |--------------------------------------------------------------------------
        */

            Log::info('Desa, profil desa dan akun admindesa berhasil dibuat.', [
                'desa_id' => $desa->id,
                'profil_desa_id' => $profilDesa->id,
                'nama_desa' => $desa->nama_desa,
                'domain' => $desa->domain,
                'user_id' => $admindesa->id,
                'email' => $admindesa->email,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 8. RESPONSE
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'success' => true,
                'message' => 'Desa, profil desa dan akun Admindesa berhasil dibuat.',

                'data' => [
                    'desa' => $desa,

                    'profil_desa' => $profilDesa,

                    'admindesa' => [
                        'id' => $admindesa->id,
                        'name' => $admindesa->name,
                        'email' => $admindesa->email,
                        'desa_id' => $admindesa->desa_id,
                        'role' => $admindesa->role,
                    ],
                ]
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Kesalahan saat membuat desa, profil desa dan akun admindesa:', [
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

    /**
     * Mengambil data desa untuk edit
     */
    public function edit($id)
    {
        try {

            $desa = Desa::findOrFail($id);

            /*
        |--------------------------------------------------------------------------
        | Ambil profil desa
        |--------------------------------------------------------------------------
        */

            $profilDesa = ProfilDesa::where('desa_id', $desa->id)->first();

            /*
        |--------------------------------------------------------------------------
        | Ambil akun admin desa
        |--------------------------------------------------------------------------
        */

            $admindesa = User::where('desa_id', $desa->id)
                ->where('role', 'admindesa')
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data desa berhasil diambil.',

                'data' => [
                    'id' => $desa->id,

                    'nama_desa' => $desa->nama_desa ?? '',
                    'domain' => $desa->domain ?? '',
                    'kecamatan' => $desa->kecamatan ?? '',
                    'kabupaten' => $desa->kabupaten ?? '',
                    'provinsi' => $desa->provinsi ?? '',
                    'kode_desa' => $desa->kode_desa ?? '',
                    'status' => (bool) $desa->status,

                    /*
                |--------------------------------------------------------------------------
                | Data profil desa
                |--------------------------------------------------------------------------
                */

                    'profil_desa' => $profilDesa,

                    /*
                |--------------------------------------------------------------------------
                | Data admin desa
                |--------------------------------------------------------------------------
                */

                    'admin_name' => $admindesa?->name ?? '',
                    'admin_email' => $admindesa?->email ?? '',
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            Log::warning('Data desa tidak ditemukan saat edit.', [
                'desa_id' => $id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data desa tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {

            Log::error('Gagal mengambil data desa untuk edit.', [
                'desa_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data desa.'
            ], 500);
        }
    }

    /**
     * Update desa
     */
    public function update(Request $request, $id)
    {
        $desa = Desa::findOrFail($id);

        $adminId = User::where('desa_id', $desa->id)
            ->where('role', 'admindesa')
            ->value('id');

        $validator = Validator::make($request->all(), [
            'nama_desa' => 'required|string|max:255',

            'domain' => [
                'required',
                'string',
                'max:255',
                'unique:desa,domain,' . $desa->id,
            ],

            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',

            'kode_desa' => [
                'nullable',
                'string',
                'max:255',
                'unique:desa,kode_desa,' . $desa->id,
            ],

            'status' => 'required|boolean',

            // Admin desa
            'admin_name' => 'required|string|max:255',

            'admin_email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $adminId,
            ],

            // Password boleh kosong saat update
            'admin_password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | 1. UPDATE DESA
        |--------------------------------------------------------------------------
        */

            $desa->nama_desa = $request->nama_desa;
            $desa->domain = $request->domain;
            $desa->kecamatan = $request->kecamatan;
            $desa->kabupaten = $request->kabupaten;
            $desa->provinsi = $request->provinsi;
            $desa->kode_desa = $request->kode_desa;
            $desa->status = $request->boolean('status');

            $desa->save();


            /*
        |--------------------------------------------------------------------------
        | 2. UPDATE / BUAT PROFIL DESA
        |--------------------------------------------------------------------------
        |
        | desa_id digunakan sebagai kunci hubungan.
        |
        */

            $profilDesa = ProfilDesa::updateOrCreate(
                [
                    'desa_id' => $desa->id,
                ],
                [
                    'nama_desa' => $desa->nama_desa,
                    'kecamatan' => $desa->kecamatan,
                    'kabupaten' => $desa->kabupaten,
                    'provinsi' => $desa->provinsi,

                    /*
                |--------------------------------------------------------------------------
                | Field wajib profil_desa
                |--------------------------------------------------------------------------
                |
                | Jika profil sudah ada, field berikut tidak akan diubah.
                | Jika profil baru dibuat, diberikan nilai sementara.
                |
                */

                    'kode_pos' => '-',

                    'nama_kepdes' => '-',
                    'kontak_sekdes' => '-',
                    'kontak_babinsa' => '-',
                    'kontak_bhabinkamtibmas' => '-',
                ]
            );


            /*
        |--------------------------------------------------------------------------
        | 3. UPDATE ADMIN DESA
        |--------------------------------------------------------------------------
        */

            $admindesa = User::where('desa_id', $desa->id)
                ->where('role', 'admindesa')
                ->first();

            if ($admindesa) {

                $admindesa->name = $request->admin_name;
                $admindesa->email = $request->admin_email;

                if (!empty($request->admin_password)) {
                    $admindesa->password = Hash::make(
                        $request->admin_password
                    );
                }

                $admindesa->save();
            }


            /*
        |--------------------------------------------------------------------------
        | 4. COMMIT
        |--------------------------------------------------------------------------
        */

            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | 5. LOG
        |--------------------------------------------------------------------------
        */

            Log::info('Desa, profil desa dan akun admindesa berhasil diperbarui.', [
                'desa_id' => $desa->id,
                'profil_desa_id' => $profilDesa->id,
                'admin_id' => $admindesa?->id,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 6. RESPONSE
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'success' => true,
                'message' => 'Data desa dan profil desa berhasil diperbarui.',

                'data' => [
                    'desa' => $desa,
                    'profil_desa' => $profilDesa,

                    'admindesa' => $admindesa ? [
                        'id' => $admindesa->id,
                        'name' => $admindesa->name,
                        'email' => $admindesa->email,
                        'desa_id' => $admindesa->desa_id,
                        'role' => $admindesa->role,
                    ] : null,
                ]
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Kesalahan saat update desa:', [
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

    /**
     * Menghapus desa
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $desa = Desa::find($id);

            if (!$desa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data desa tidak ditemukan.'
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Hapus user admindesa
            |--------------------------------------------------------------------------
            */

            User::where('desa_id', $desa->id)
                ->where('role', 'admindesa')
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus desa
            |--------------------------------------------------------------------------
            */

            $desa->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data desa dan akun Admindesa berhasil dihapus.'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Kesalahan saat menghapus desa:', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus desa.'
            ], 500);
        }
    }
}
