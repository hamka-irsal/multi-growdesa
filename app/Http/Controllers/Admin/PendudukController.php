<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Penduduk::query()
            ->whereHas('user', function ($userQuery) {
                $userQuery->where(
                    'status_verifikasi',
                    'disetujui'
                );
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

    public function searchPenduduk(Request $request)
    {
        try {
            $query = $request->input('query');

            // Pencarian hanya berdasarkan nama lengkap
            $penduduk = Penduduk::where('nama_lengkap', 'like', '%' . $query . '%')->get();

            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian penduduk:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    public function paginate()
    {
        $penduduk = Penduduk::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status_verifikasi', 'disetujui');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return response()->json($penduduk);
    }

    public function show($id)
    {
        $penduduk = Penduduk::find($id);

        if ($penduduk) {
            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Penduduk tidak ditemukan'
        ], 404);
    }

    public function store(Request $request)
    {
        try {
            Log::info('📥 Data masuk ke store():', $request->except('foto'));

            // Validasi input
            $validator = Validator::make($request->all(), [
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
                'status_hubungan_dalam_keluarga' => 'required|string|max:50',
                'tanggal_perkawinan' => 'nullable|date',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alamat' => 'required|string',
                'desa_kelurahan' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'dusun' => 'nullable|string|max:100',
                'kabupaten_kota' => 'required|string|max:100',
                'provinsi' => 'required|string|max:100',
                'kewarganegaraan' => 'required|string|max:50',
                'ayah' => 'required|string|max:255',
                'ibu' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::error('❌ Validasi gagal:', $validator->errors()->toArray());

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $penduduk = new Penduduk();
            $penduduk->user_id = auth()->id(); // <-- INI YANG HILANG, WAJIB DIISI
            $penduduk->nik = $request->nik;
            $penduduk->nama_lengkap = $request->nama_lengkap;
            $penduduk->jenis_kelamin = $request->jenis_kelamin;
            $penduduk->pendidikan = $request->pendidikan;
            $penduduk->tempat_lahir = $request->tempat_lahir;
            $penduduk->jenis_pekerjaan = $request->jenis_pekerjaan;
            $penduduk->tanggal_lahir = $request->tanggal_lahir;
            $penduduk->golongan_darah = $request->golongan_darah;
            $penduduk->agama = $request->agama;
            $penduduk->status_perkawinan = $request->status_perkawinan;
            $penduduk->status_hubungan_dalam_keluarga = $request->status_hubungan_dalam_keluarga;
            $penduduk->tanggal_perkawinan = $request->tanggal_perkawinan ?: null;
            $penduduk->alamat = $request->alamat;
            $penduduk->desa_kelurahan = $request->desa_kelurahan;
            $penduduk->kecamatan = $request->kecamatan;
            $penduduk->dusun = $request->dusun;
            $penduduk->kabupaten_kota = $request->kabupaten_kota;
            $penduduk->provinsi = $request->provinsi;
            $penduduk->kewarganegaraan = $request->kewarganegaraan;
            $penduduk->ayah = $request->ayah;
            $penduduk->ibu = $request->ibu;

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_penduduk', $filename, 'public');
                $penduduk->foto = $path;
            }

            $penduduk->save();
            DB::commit();

            Log::info('✅ Data penduduk berhasil disimpan:', ['id' => $penduduk->id]);

            return response()->json([
                'success' => true,
                'message' => 'Penduduk berhasil ditambahkan!',
                'data' => $penduduk
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('❌ Kesalahan saat menyimpan data:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => ['general' => ['Terjadi kesalahan, coba lagi!']],
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Penduduk::find($id);

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Request update masuk:', ['id' => $id, 'data' => $request->all()]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
            'pendidikan' => 'nullable|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_pekerjaan' => 'nullable|string|max:100',
            'golongan_darah' => 'nullable|string|max:5',
            'agama' => 'required|string|max:50',
            'status_perkawinan' => 'required|string|max:50',
            'status_hubungan_dalam_keluarga' => 'nullable|string|max:100',
            'tanggal_perkawinan' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'dusun' => 'nullable|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kewarganegaraan' => 'required|string|max:50',
            'ayah' => 'nullable|string|max:255',
            'ibu' => 'nullable|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Log::error('Validasi gagal:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Ambil data penduduk berdasarkan ID
            $penduduk = Penduduk::findOrFail($id);

            // Update data penduduk
            $penduduk->update([
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan' => $request->pendidikan,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_pekerjaan' => $request->jenis_pekerjaan,
                'golongan_darah' => $request->golongan_darah,
                'agama' => $request->agama,
                'status_perkawinan' => $request->status_perkawinan,
                'status_hubungan_dalam_keluarga' => $request->status_hubungan_dalam_keluarga,
                'tanggal_perkawinan' => $request->tanggal_perkawinan,
                'alamat' => $request->alamat,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'dusun' => $request->dusun,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi,
                'kewarganegaraan' => $request->kewarganegaraan,
                'ayah' => $request->ayah,
                'ibu' => $request->ibu,
            ]);

            // Jika ada unggahan foto baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($penduduk->foto) {
                    Storage::disk('public')->delete($penduduk->foto);
                }

                // Simpan foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/foto_penduduk', $filename);
                $penduduk->foto = str_replace('public/', '', $path);
                $penduduk->save();
            }

            Log::info('Data penduduk berhasil diperbarui:', ['id' => $penduduk->id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Kesalahan saat update data:', ['message' => $e->getMessage()]);
            return response()->json(['errors' => ['general' => ['Terjadi kesalahan, coba lagi!']]], 500);
        }
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::find($id);
        if (!$penduduk) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $penduduk->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
