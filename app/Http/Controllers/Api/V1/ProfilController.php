<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Menampilkan profil akun.
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('penduduk');

        return new ProfilResource(
            true,
            'Profil berhasil diambil.',
            $user
        );
    }

    /**
     * Memperbarui profil akun.
     */
    public function update(Request $request)
    {
        $user = $request->user()->load('penduduk');

        if (!$user->penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'email' => [
                'sometimes',
                'email',
                'unique:users,email,' . $user->id,
            ],
            'no_hp' => 'sometimes|string|min:10|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        DB::beginTransaction();

        try {
            $penduduk = $user->penduduk;

            /**
             * Upload foto profil.
             */
            if ($request->hasFile('foto')) {
                if (
                    $penduduk->foto &&
                    Storage::disk('public')->exists($penduduk->foto)
                ) {
                    Storage::disk('public')->delete($penduduk->foto);
                }

                $validated['foto'] = $request
                    ->file('foto')
                    ->store('penduduk/foto', 'public');
            }

            /**
             * Update tabel users.
             */
            $user->update([
                'email' => $validated['email'] ?? $user->email,
                'password' => !empty($validated['password'])
                    ? bcrypt($validated['password'])
                    : $user->password,
            ]);

            /**
             * Update tabel penduduk.
             */
            $penduduk->update([
                'no_hp' => $validated['no_hp'] ?? $penduduk->no_hp,
                'foto' => $validated['foto'] ?? $penduduk->foto,
            ]);

            DB::commit();

            return new ProfilResource(
                true,
                'Profil berhasil diperbarui.',
                $user->fresh()->load('penduduk')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menghapus foto profil.
     */
    public function hapusFoto(Request $request)
    {
        $user = $request->user()->load('penduduk');

        if (!$user->penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        $penduduk = $user->penduduk;

        if (!$penduduk->foto) {
            return response()->json([
                'success' => false,
                'message' => 'Foto profil belum tersedia.',
            ], 404);
        }

        if (Storage::disk('public')->exists($penduduk->foto)) {
            Storage::disk('public')->delete($penduduk->foto);
        }

        $penduduk->update([
            'foto' => null,
        ]);

        return new ProfilResource(
            true,
            'Foto profil berhasil dihapus.',
            $user->fresh()->load('penduduk')
        );
    }
}
