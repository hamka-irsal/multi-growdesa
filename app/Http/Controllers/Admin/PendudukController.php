<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PendudukController extends Controller
{
    /**
     * Mengambil desa_id dari akun yang sedang login.
     */
    private function currentDesaId(): int
    {
        $desaId = auth()->user()?->desa_id;

        abort_unless($desaId, 403, 'Akun tidak terhubung dengan desa.');

        return (int) $desaId;
    }

    /**
     * Menampilkan halaman penduduk sesuai desa admin.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Penduduk::query()
            ->where('desa_id', $desaId)
            ->whereHas('user', function ($userQuery) {
                $userQuery->where('status_verifikasi', 'disetujui');
            });

        if (!empty($search)) {
            $query->where(
                'nama_lengkap',
                'like',
                "%{$search}%"
            );
        }

        $penduduk = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.penduduk.index',
            compact('penduduk', 'perPage', 'search')
        );
    }

    /**
     * Pencarian penduduk berdasarkan desa.
     */
    public function searchPenduduk(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();
            $query = $request->input('query', '');

            $penduduk = Penduduk::where('desa_id', $desaId)
                ->where(
                    'nama_lengkap',
                    'like',
                    '%' . $query . '%'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);
        } catch (\Exception $e) {
            Log::error(
                'Kesalahan saat pencarian penduduk:',
                [
                    'message' => $e->getMessage()
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    /**
     * Pagination penduduk sesuai desa.
     */
    public function paginate()
    {
        $desaId = $this->currentDesaId();

        $penduduk = Penduduk::with('user')
            ->where('desa_id', $desaId)
            ->whereHas('user', function ($query) {
                $query->where(
                    'status_verifikasi',
                    'disetujui'
                );
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return response()->json($penduduk);
    }

    /**
     * Menampilkan detail penduduk.
     */
    public function show($id)
    {
        $penduduk = Penduduk::where(
            'desa_id',
            $this->currentDesaId()
        )->find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Penduduk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penduduk
        ]);
    }

    /**
     * Menambahkan penduduk dengan desa_id otomatis.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        try {
            Log::info(
                'Data masuk ke store penduduk:',
                [
                    'data' => $request->except('foto'),
                    'desa_id' => $desaId
                ]
            );

            $validator = Validator::make(
                $request->all(),
                [
                    'nik' => 'nullable|digits:16|unique:penduduk,nik',
                    'nama_lengkap' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                    'pendidikan' => 'required|string|max:100',
                    'tempat_lahir' => 'required|string|max:100',
                    'jenis_pekerjaan' => 'required|string|max:100',
                    'tanggal_lahir' => 'required|date',
                    'golongan_darah' => 'nullable|string|max:5',
                    'agama' => 'required|string|max:50',
                    'status_perkawinan' => 'required|string|max:50',
                    'status_hubungan_dalam_keluarga' =>
                        'required|string|max:100',
                    'tanggal_perkawinan' => 'nullable|date',
                    'foto' =>
                        'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'alamat' => 'required|string',
                    'kewarganegaraan' =>
                        'required|string|max:50',
                    'ayah' => 'required|string|max:255',
                    'ibu' => 'required|string|max:255',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $penduduk = new Penduduk();

            // Tenant diambil dari akun admin yang login.
            $penduduk->desa_id = $desaId;

            // Mempertahankan logika user_id.
            $penduduk->user_id = auth()->id();

            $penduduk->nik = $request->nik;
            $penduduk->nama_lengkap = $request->nama_lengkap;
            $penduduk->jenis_kelamin = $request->jenis_kelamin;
            $penduduk->pendidikan = $request->pendidikan;
            $penduduk->tempat_lahir = $request->tempat_lahir;
            $penduduk->jenis_pekerjaan = $request->jenis_pekerjaan;
            $penduduk->tanggal_lahir = $request->tanggal_lahir;
            $penduduk->golongan_darah = $request->golongan_darah;
            $penduduk->agama = $request->agama;
            $penduduk->status_perkawinan =
                $request->status_perkawinan;

            $penduduk->status_hubungan_dalam_keluarga =
                $request->status_hubungan_dalam_keluarga;

            $penduduk->tanggal_perkawinan =
                $request->tanggal_perkawinan ?: null;

            $penduduk->alamat = $request->alamat;

            $penduduk->kewarganegaraan =
                $request->kewarganegaraan;

            $penduduk->ayah = $request->ayah;
            $penduduk->ibu = $request->ibu;

            // Upload foto.
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                $penduduk->foto = $file->storeAs(
                    'foto_penduduk',
                    $filename,
                    'public'
                );
            }

            $penduduk->save();

            DB::commit();

            Log::info(
                'Data penduduk berhasil disimpan:',
                [
                    'id' => $penduduk->id,
                    'desa_id' => $desaId
                ]
            );

            return response()->json([
                'success' => true,
                'message' =>
                    'Penduduk berhasil ditambahkan!',
                'data' => $penduduk
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error(
                'Kesalahan saat menyimpan data penduduk:',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            );

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!'
                    ]
                ],
                'debug' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Mengambil data edit hanya dari desa yang sama.
     */
    public function edit($id)
    {
        $data = Penduduk::where(
            'desa_id',
            $this->currentDesaId()
        )->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Memperbarui penduduk sesuai desa admin.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        // Pastikan data berasal dari desa admin yang login.
        $penduduk = Penduduk::where(
            'desa_id',
            $desaId
        )->find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        Log::info(
            'Request update penduduk masuk:',
            [
                'id' => $id,
                'desa_id' => $desaId,
                'data' => $request->except('foto')
            ]
        );

        $validator = Validator::make(
            $request->all(),
            [
                'nik' => [
                    'required',
                    'digits:16',
                    Rule::unique(
                        'penduduk',
                        'nik'
                    )->ignore($penduduk->id)
                ],

                'nama_lengkap' =>
                    'required|string|max:255',

                'jenis_kelamin' =>
                    'required|in:Laki-laki,Perempuan',

                'pendidikan' =>
                    'nullable|string|max:100',

                'tempat_lahir' =>
                    'required|string|max:100',

                'tanggal_lahir' =>
                    'required|date',

                'jenis_pekerjaan' =>
                    'nullable|string|max:100',

                'golongan_darah' =>
                    'nullable|string|max:5',

                'agama' =>
                    'required|string|max:50',

                'status_perkawinan' =>
                    'required|string|max:50',

                'status_hubungan_dalam_keluarga' =>
                    'nullable|string|max:100',

                'tanggal_perkawinan' =>
                    'nullable|date',

                'foto' =>
                    'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

                'alamat' =>
                    'required|string',

                'kewarganegaraan' =>
                    'required|string|max:50',

                'ayah' =>
                    'nullable|string|max:255',

                'ibu' =>
                    'nullable|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $penduduk->fill(
                $request->only([
                    'nik',
                    'nama_lengkap',
                    'jenis_kelamin',
                    'pendidikan',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'jenis_pekerjaan',
                    'golongan_darah',
                    'agama',
                    'status_perkawinan',
                    'status_hubungan_dalam_keluarga',
                    'tanggal_perkawinan',
                    'alamat',
                    'kewarganegaraan',
                    'ayah',
                    'ibu'
                ])
            );

            // desa_id tidak boleh diubah
            // dari request pengguna.
            $penduduk->desa_id = $desaId;

            // Upload foto baru jika ada.
            if ($request->hasFile('foto')) {

                if ($penduduk->foto) {
                    Storage::disk('public')
                        ->delete($penduduk->foto);
                }

                $file = $request->file('foto');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                $penduduk->foto = $file->storeAs(
                    'foto_penduduk',
                    $filename,
                    'public'
                );
            }

            $penduduk->save();

            Log::info(
                'Data penduduk berhasil diperbarui:',
                [
                    'id' => $penduduk->id,
                    'desa_id' => $desaId
                ]
            );

            return response()->json([
                'success' => true,
                'message' =>
                    'Data penduduk berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {

            Log::error(
                'Kesalahan saat update data penduduk:',
                [
                    'message' => $e->getMessage()
                ]
            );

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!'
                    ]
                ],
                'debug' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Menghapus penduduk hanya dari desa admin.
     */
    public function destroy($id)
    {
        $penduduk = Penduduk::where(
            'desa_id',
            $this->currentDesaId()
        )->find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        if ($penduduk->foto) {
            Storage::disk('public')
                ->delete($penduduk->foto);
        }

        $penduduk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
