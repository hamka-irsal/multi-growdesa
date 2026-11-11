<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukController extends Controller
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
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Produk::where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        $produk = $query
            ->latest()
            ->paginate($perPage);

        return view(
            'admin.produk.index',
            compact(
                'produk',
                'perPage',
                'search'
            )
        );
    }

    /**
     * Pencarian produk.
     */
    public function search(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();

            $query = $request->input('query');

            $produk = Produk::where('desa_id', $desaId)
                ->where(function ($q) use ($query) {
                    $q->where(
                        'nama_produk',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhere(
                        'kategori',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhere(
                        'asal_desa',
                        'like',
                        '%' . $query . '%'
                    );
                })
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $produk
            ]);
        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat pencarian produk:',
                [
                    'message' => $e->getMessage(),
                    'desa_id' => auth()->user()?->desa_id
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    /**
     * Pagination produk.
     */
    public function paginate(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $produk = Produk::where('desa_id', $desaId)
            ->when(
                $search,
                function ($query, $search) {
                    $query->where(
                        'nama_produk',
                        'like',
                        "%{$search}%"
                    );
                }
            )
            ->latest()
            ->paginate($perPage);

        return response()->json($produk);
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        try {

            Log::info(
                '📥 Data masuk ke store() produk:',
                [
                    'desa_id' => $desaId,
                    'data' => $request->except('foto')
                ]
            );

            $validator = Validator::make(
                $request->all(),
                [
                    'nama_produk' => 'required|string|max:255',
                    'deskripsi' => 'nullable|string',
                    'harga' => 'required|numeric|min:0',
                    'stok' => 'required|integer|min:0',
                    'kategori' => 'nullable|string|max:100',
                    'asal_desa' => 'required|string|max:100',
                    'kontak' => 'required|string|max:100',
                    'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]
            );

            if ($validator->fails()) {

                Log::error(
                    '❌ Validasi produk gagal:',
                    $validator->errors()->toArray()
                );

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Generate Slug Unik Per Desa
            |--------------------------------------------------------------------------
            */

            $slug = Str::slug(
                $request->nama_produk
            );

            $originalSlug = $slug;
            $counter = 1;

            while (
                Produk::where('desa_id', $desaId)
                    ->where('slug', $slug)
                    ->exists()
            ) {

                $slug =
                    $originalSlug .
                    '-' .
                    $counter;

                $counter++;
            }

            /*
            |--------------------------------------------------------------------------
            | Membuat Data Produk
            |--------------------------------------------------------------------------
            */

            $produk = new Produk();

            // PENTING:
            // desa_id diambil dari user yang login
            // bukan dari request.
            $produk->desa_id = $desaId;

            $produk->nama_produk =
                $request->nama_produk;

            $produk->slug =
                $slug;

            $produk->deskripsi =
                $request->deskripsi;

            $produk->harga =
                $request->harga;

            $produk->stok =
                $request->stok;

            $produk->kategori =
                $request->kategori;

            $produk->asal_desa =
                $request->asal_desa;

            $produk->kontak =
                $request->kontak;

            /*
            |--------------------------------------------------------------------------
            | Upload Foto Produk
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                $file =
                    $request->file('foto');

                $filename =
                    time() .
                    '_' .
                    $file->getClientOriginalName();

                $path =
                    $file->storeAs(
                        'public/foto_produk',
                        $filename
                    );

                /*
                | Simpan path tanpa "public/"
                |
                | Contoh:
                | foto_produk/1785654810_popmie.jpg
                */
                $produk->foto =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Produk
            |--------------------------------------------------------------------------
            */

            $produk->save();

            DB::commit();

            Log::info(
                '✅ Produk berhasil disimpan:',
                [
                    'id' => $produk->id,
                    'desa_id' => $produk->desa_id,
                    'foto' => $produk->foto,
                    'slug' => $produk->slug
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'data' => $produk
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error(
                '❌ Kesalahan saat menyimpan produk:',
                [
                    'message' => $e->getMessage(),
                    'desa_id' => $desaId
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

    /**
     * Menampilkan data produk untuk edit.
     */
    public function edit($id)
    {
        $desaId = $this->currentDesaId();

        $produk = Produk::where('desa_id', $desaId)
            ->findOrFail($id);

        $data = [
            'id' => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'slug' => $produk->slug,
            'deskripsi' => $produk->deskripsi,
            'harga' => $produk->harga,
            'stok' => $produk->stok,
            'kategori' => $produk->kategori,
            'asal_desa' => $produk->asal_desa,
            'kontak' => $produk->kontak,
            'foto_url' => $produk->foto
                ? asset('storage/' . $produk->foto)
                : null,
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Update produk.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        Log::info(
            '📥 Request update produk:',
            [
                'id' => $id,
                'desa_id' => $desaId,
                'data' => $request->except('foto')
            ]
        );

        $validator = Validator::make(
            $request->all(),
            [
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'kategori' => 'nullable|string|max:100',
                'asal_desa' => 'required|string|max:100',
                'kontak' => 'required|string|max:100',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]
        );

        if ($validator->fails()) {

            Log::error(
                '❌ Validasi gagal saat update produk:',
                $validator->errors()->toArray()
            );

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil Produk Hanya Dari Desa Yang Sedang Login
            |--------------------------------------------------------------------------
            */

            $produk = Produk::where('desa_id', $desaId)
                ->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Update Data Produk
            |--------------------------------------------------------------------------
            */

            $produk->nama_produk =
                $request->nama_produk;

            $produk->deskripsi =
                $request->deskripsi;

            $produk->harga =
                $request->harga;

            $produk->stok =
                $request->stok;

            $produk->kategori =
                $request->kategori;

            $produk->asal_desa =
                $request->asal_desa;

            $produk->kontak =
                $request->kontak;

            /*
            |--------------------------------------------------------------------------
            | Generate Slug Unik Per Desa
            |--------------------------------------------------------------------------
            */

            $slug = Str::slug(
                $request->nama_produk
            );

            $originalSlug = $slug;
            $counter = 1;

            while (
                Produk::where('desa_id', $desaId)
                    ->where('slug', $slug)
                    ->where('id', '!=', $produk->id)
                    ->exists()
            ) {

                $slug =
                    $originalSlug .
                    '-' .
                    $counter;

                $counter++;
            }

            $produk->slug = $slug;

            /*
            |--------------------------------------------------------------------------
            | Update Foto
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                if ($produk->foto) {

                    Storage::disk('public')
                        ->delete(
                            $produk->foto
                        );
                }

                $file =
                    $request->file('foto');

                $filename =
                    time() .
                    '_' .
                    $file->getClientOriginalName();

                $path =
                    $file->storeAs(
                        'public/foto_produk',
                        $filename
                    );

                $produk->foto =
                    str_replace(
                        'public/',
                        '',
                        $path
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Perubahan
            |--------------------------------------------------------------------------
            */

            $produk->desa_id = $desaId;

            $produk->save();

            Log::info(
                '✅ Produk berhasil diperbarui:',
                [
                    'id' => $produk->id,
                    'desa_id' => $produk->desa_id,
                    'slug' => $produk->slug
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui.',
                'data' => $produk
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat update produk:',
                [
                    'message' => $e->getMessage(),
                    'desa_id' => $desaId,
                    'produk_id' => $id
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

    /**
     * Hapus produk.
     */
    public function destroy($id)
    {
        $desaId = $this->currentDesaId();

        $produk = Produk::where('desa_id', $desaId)
            ->find($id);

        if (!$produk) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus Foto
        |--------------------------------------------------------------------------
        */

        if ($produk->foto) {

            Storage::disk('public')
                ->delete(
                    $produk->foto
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus Produk
        |--------------------------------------------------------------------------
        */

        $produk->delete();

        Log::info(
            '🗑️ Produk berhasil dihapus:',
            [
                'id' => $id,
                'desa_id' => $desaId
            ]
        );

        return response()->json([
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}