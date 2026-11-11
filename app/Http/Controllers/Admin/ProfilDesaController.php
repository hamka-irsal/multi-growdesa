<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfilDesaController extends Controller
{
    /**
     * Ambil desa_id dari user yang sedang login.
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
     * Menampilkan data profil desa.
     */
    public function index()
    {
        try {

            $desaId = $this->currentDesaId();

            /*
            |--------------------------------------------------------------------------
            | Ambil profil hanya milik desa yang sedang login
            |--------------------------------------------------------------------------
            */

            $profilDesa = ProfilDesa::where(
                'desa_id',
                $desaId
            )->first();

            return view(
                'admin.profil-desa.index',
                compact('profilDesa')
            );

        } catch (\Exception $e) {

            Log::error(
                '❌ Gagal mengambil data profil desa:',
                [
                    'desa_id' => auth()->user()?->desa_id,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Terjadi kesalahan saat mengambil data profil desa.'
                );
        }
    }

    /**
     * Mengambil data profil desa untuk form edit.
     */
    public function edit($id)
    {
        try {

            $desaId = $this->currentDesaId();

            /*
            |--------------------------------------------------------------------------
            | Ambil profil berdasarkan ID DAN desa_id
            |--------------------------------------------------------------------------
            */

            $profilDesa = ProfilDesa::where(
                'desa_id',
                $desaId
            )->findOrFail($id);

            $data = [

                'id' => $profilDesa->id,

                // Profil utama
                'selamat_datang' => $profilDesa->selamat_datang,

                'nama_kepdes' => $profilDesa->nama_kepdes,

                'foto_kepdes_url' => $profilDesa->foto_kepdes
                    ? asset(
                        'storage/' .
                        $profilDesa->foto_kepdes
                    )
                    : null,

                'logo_desa_url' => $profilDesa->logo_desa
                    ? asset(
                        'storage/' .
                        $profilDesa->logo_desa
                    )
                    : null,

                'tentang_desa' => $profilDesa->tentang_desa,

                // Identitas desa
                'nama_desa' => $profilDesa->nama_desa,
                'kecamatan' => $profilDesa->kecamatan,
                'kabupaten' => $profilDesa->kabupaten,
                'provinsi' => $profilDesa->provinsi,
                'kode_pos' => $profilDesa->kode_pos,

                // Kontak desa
                'tlp_desa' => $profilDesa->tlp_desa,
                'email_desa' => $profilDesa->email_desa,
                'kontak_sekdes' => $profilDesa->kontak_sekdes,
                'kontak_babinsa' => $profilDesa->kontak_babinsa,
                'kontak_bhabinkamtibmas' =>
                    $profilDesa->kontak_bhabinkamtibmas,

                // Informasi desa
                'sejarah_desa' => $profilDesa->sejarah_desa,
                'visi' => $profilDesa->visi,
                'misi' => $profilDesa->misi,
                'alamat_kantor' => $profilDesa->alamat_kantor,
                'alamat_peta' => $profilDesa->alamat_peta,

                // Sosial media
                'sosmed_ig' => $profilDesa->sosmed_ig,
                'sosmed_fb' => $profilDesa->sosmed_fb,
                'sosmed_yt' => $profilDesa->sosmed_yt,
                'sosmed_tiktok' => $profilDesa->sosmed_tiktok,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Gagal mengambil data profil desa untuk edit:',
                [
                    'id' => $id,
                    'desa_id' => auth()->user()?->desa_id,
                    'message' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Data profil desa tidak ditemukan.',
            ], 404);
        }
    }

    /**
     * Update data profil desa.
     */
    public function update(
        Request $request,
        $id
    ) {

        $desaId = $this->currentDesaId();

        Log::info(
            '📥 Request update profil desa masuk:',
            [
                'id' => $id,
                'desa_id' => $desaId,
                'data' => $request->except([
                    'foto_kepdes',
                    'logo_desa',
                ]),
            ]
        );

        $validator = Validator::make(
            $request->all(),
            [

                // Profil utama
                'selamat_datang' =>
                    'nullable|string',

                'nama_kepdes' =>
                    'required|string|max:255',

                'foto_kepdes' =>
                    'nullable|image|mimes:jpg,jpeg,png|max:2048',

                'logo_desa' =>
                    'nullable|image|mimes:jpg,jpeg,png|max:2048',

                'tentang_desa' =>
                    'nullable|string',

                // Identitas desa
                'nama_desa' =>
                    'required|string|max:255',

                'kecamatan' =>
                    'required|string|max:255',

                'kabupaten' =>
                    'required|string|max:255',

                'provinsi' =>
                    'required|string|max:255',

                'kode_pos' =>
                    'required|string|max:10',

                // Kontak desa
                'tlp_desa' =>
                    'nullable|string|max:50',

                'email_desa' =>
                    'nullable|email|max:255',

                'kontak_sekdes' =>
                    'required|string|max:50',

                'kontak_babinsa' =>
                    'required|string|max:50',

                'kontak_bhabinkamtibmas' =>
                    'required|string|max:50',

                // Informasi desa
                'sejarah_desa' =>
                    'nullable|string',

                'visi' =>
                    'nullable|string',

                'misi' =>
                    'nullable|string',

                'alamat_kantor' =>
                    'nullable|string',

                'alamat_peta' =>
                    'nullable|string',

                // Sosial media
                'sosmed_ig' =>
                    'nullable|string|max:255',

                'sosmed_fb' =>
                    'nullable|string|max:255',

                'sosmed_yt' =>
                    'nullable|string|max:255',

                'sosmed_tiktok' =>
                    'nullable|string|max:255',
            ]
        );

        if ($validator->fails()) {

            Log::error(
                '❌ Validasi gagal saat update profil desa:',
                [
                    'desa_id' => $desaId,
                    'errors' =>
                        $validator->errors()->toArray(),
                ]
            );

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil profil hanya dari desa yang sedang login
            |--------------------------------------------------------------------------
            */

            $profilDesa = ProfilDesa::where(
                'desa_id',
                $desaId
            )->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Update Data Profil Desa
            |--------------------------------------------------------------------------
            */

            $profilDesa->selamat_datang =
                $request->selamat_datang;

            $profilDesa->nama_kepdes =
                $request->nama_kepdes;

            $profilDesa->tentang_desa =
                $request->tentang_desa;

            // Identitas desa
            $profilDesa->nama_desa =
                $request->nama_desa;

            $profilDesa->kecamatan =
                $request->kecamatan;

            $profilDesa->kabupaten =
                $request->kabupaten;

            $profilDesa->provinsi =
                $request->provinsi;

            $profilDesa->kode_pos =
                $request->kode_pos;

            // Kontak desa
            $profilDesa->tlp_desa =
                $request->tlp_desa;

            $profilDesa->email_desa =
                $request->email_desa;

            $profilDesa->kontak_sekdes =
                $request->kontak_sekdes;

            $profilDesa->kontak_babinsa =
                $request->kontak_babinsa;

            $profilDesa->kontak_bhabinkamtibmas =
                $request->kontak_bhabinkamtibmas;

            // Informasi desa
            $profilDesa->sejarah_desa =
                $request->sejarah_desa;

            $profilDesa->visi =
                $request->visi;

            $profilDesa->misi =
                $request->misi;

            $profilDesa->alamat_kantor =
                $request->alamat_kantor;

            $profilDesa->alamat_peta =
                $request->alamat_peta;

            // Sosial media
            $profilDesa->sosmed_ig =
                $request->sosmed_ig;

            $profilDesa->sosmed_fb =
                $request->sosmed_fb;

            $profilDesa->sosmed_yt =
                $request->sosmed_yt;

            $profilDesa->sosmed_tiktok =
                $request->sosmed_tiktok;

            /*
            |--------------------------------------------------------------------------
            | Upload Foto Kepala Desa
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto_kepdes')) {

                // Hapus foto lama
                if ($profilDesa->foto_kepdes) {

                    Storage::disk('public')
                        ->delete(
                            $profilDesa->foto_kepdes
                        );
                }

                $file =
                    $request->file('foto_kepdes');

                $filename =
                    time()
                    . '_kepdes_'
                    . $file->getClientOriginalName();

                $path =
                    $file->storeAs(
                        'public/foto_kepdes',
                        $filename
                    );

                $profilDesa->foto_kepdes =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Upload Logo Desa
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('logo_desa')) {

                // Hapus logo lama
                if ($profilDesa->logo_desa) {

                    Storage::disk('public')
                        ->delete(
                            $profilDesa->logo_desa
                        );
                }

                $file =
                    $request->file('logo_desa');

                $filename =
                    time()
                    . '_logo_'
                    . $file->getClientOriginalName();

                $path =
                    $file->storeAs(
                        'public/logo_desa',
                        $filename
                    );

                $profilDesa->logo_desa =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Pastikan desa_id tetap sesuai user login
            |--------------------------------------------------------------------------
            */

            $profilDesa->desa_id = $desaId;

            /*
            |--------------------------------------------------------------------------
            | Simpan Perubahan
            |--------------------------------------------------------------------------
            */

            $profilDesa->save();

            Log::info(
                '✅ Profil desa berhasil diperbarui:',
                [
                    'id' => $profilDesa->id,
                    'desa_id' => $profilDesa->desa_id,
                    'nama_desa' => $profilDesa->nama_desa,
                ]
            );

            return response()->json([
                'success' => true,
                'message' =>
                    'Profil desa berhasil diperbarui!',
                'data' => $profilDesa,
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat update profil desa:',
                [
                    'id' => $id,
                    'desa_id' => $desaId,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

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
}