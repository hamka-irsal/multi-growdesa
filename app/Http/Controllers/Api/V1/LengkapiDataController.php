<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LengkapiDataResource;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LengkapiDataController extends Controller
{
    /**
     * Ambil data penduduk
     */
    public function show(Request $request)
    {
        $penduduk = Penduduk::where('user_id', $request->user()->id)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan'
            ], 404);
        }

        return new LengkapiDataResource(
            true,
            'Data penduduk berhasil diambil',
            $penduduk
        );
    }

    /**

     * Lengkapi / Update Data Penduduk
     */
    public function updateStep1(Request $request)
    {
        $user = $request->user();

        $penduduk = Penduduk::where('user_id', $user->id)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'required|in:A,B,AB,O,-',
            'agama' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
        ]);

        $penduduk->update($validated);

        return new LengkapiDataResource(
            true,
            'Informasi pribadi berhasil diperbarui.',
            $penduduk->fresh()
        );
    }

    /**

     * Update data pekerjaan dan keluarga.
     */
    public function updateStep2(Request $request)
    {
        $user = $request->user();

        $penduduk = Penduduk::where('user_id', $user->id)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'jenis_pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:100',
            'tanggal_perkawinan' => 'nullable|date',
            'status_hubungan_dalam_keluarga' => 'required|string|max:100',
            'ayah' => 'required|string|max:255',
            'ibu' => 'required|string|max:255',
        ]);

        $penduduk->update($validated);

        return new LengkapiDataResource(
            true,
            'Data pekerjaan dan keluarga berhasil diperbarui.',
            $penduduk->fresh()
        );
    }

    /**

     * Update alamat dan dokumen penduduk.
     */
    public function updateStep3(Request $request)
    {
        $user = $request->user();

        $penduduk = Penduduk::where('user_id', $user->id)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'alamat' => 'required|string',
            'dusun' => 'nullable|string|max:100',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',

            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'foto_selfie' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',


        ]);

        DB::beginTransaction();

        try {
            /**
             * Upload foto KTP.
             */
            if ($request->hasFile('foto_ktp')) {
                if (
                    $penduduk->foto_ktp &&
                    Storage::disk('public')->exists($penduduk->foto_ktp)
                ) {
                    Storage::disk('public')->delete($penduduk->foto_ktp);
                }

                $validated['foto_ktp'] = $request
                    ->file('foto_ktp')
                    ->store('penduduk/ktp', 'public');
            }

            /**
             * Upload foto selfie.
             */
            if ($request->hasFile('foto_selfie')) {
                if (
                    $penduduk->foto_selfie &&
                    Storage::disk('public')->exists($penduduk->foto_selfie)
                ) {
                    Storage::disk('public')->delete($penduduk->foto_selfie);
                }

                $validated['foto_selfie'] = $request
                    ->file('foto_selfie')
                    ->store('penduduk/selfie', 'public');
            }

            /**
             * Update data penduduk.
             *
             * status_verifikasi tidak dimasukkan ke dalam $validated,
             * sehingga status yang sudah disetujui atau ditolak
             * tidak berubah menjadi pending.
             */
            $penduduk->update($validated);

            /**
             * Jika seluruh data sudah lengkap dan status sebelumnya
             * belum pernah diproses, status tetap atau menjadi pending.
             *
             * Status disetujui dan ditolak tidak akan diubah.
             */
            if (
                $user->status_verifikasi === null ||
                $user->status_verifikasi === ''
            ) {
                $user->update([
                    'status_verifikasi' => 'pending',
                ]);
            }

            DB::commit();

            return new LengkapiDataResource(
                true,
                'Alamat dan dokumen berhasil diperbarui.',
                $penduduk->fresh()
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
