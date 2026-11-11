<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ManajemenSuratController extends Controller
{
    /**
     * Pilihan nilai yang diizinkan (sesuai kolom pada migrasi).
     */
    private const SUMBER_PENGAJUAN = ['warga', 'admin', 'keduanya'];
    private const STATUS = ['aktif', 'nonaktif'];

    /**
     * Mengambil desa_id dari user yang sedang login.
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
     * Menerapkan pencarian & filter pada query jenis surat.
     */
    private function applyFilters($query, Request $request, ?string $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_jenis', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('format_nomor', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (in_array($request->input('status'), self::STATUS, true)) {
            $query->where('status', $request->input('status'));
        }

        if (in_array($request->input('sumber_pengajuan'), self::SUMBER_PENGAJUAN, true)) {
            $query->where('sumber_pengajuan', $request->input('sumber_pengajuan'));
        }

        return $query;
    }

    /**
     * Membatasi nilai perPage agar aman.
     */
    private function perPage(Request $request): int
    {
        $perPage = (int) $request->input('perPage', 10);

        return min(max($perPage, 1), 100);
    }

    /**
     * Aturan validasi yang dipakai bersama oleh store & update.
     */
    private function rules(int $desaId, ?int $ignoreId = null): array
    {
        $uniquePerDesa = function (string $column) use ($desaId, $ignoreId) {
            return Rule::unique('jenis_surat', $column)
                ->where(fn($q) => $q->where('desa_id', $desaId))
                ->ignore($ignoreId);
        };

        return [
            'kode' => [
                'nullable',
                'string',
                'max:50',
                $uniquePerDesa('kode'),
            ],
            'nama_jenis' => [
                'required',
                'string',
                'max:150',
                $uniquePerDesa('nama_jenis'),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                $uniquePerDesa('slug'),
            ],
            'deskripsi' => ['nullable', 'string'],
            'format_nomor' => ['required', 'string', 'max:100'],
            'sumber_pengajuan' => [
                'required',
                Rule::in(self::SUMBER_PENGAJUAN),
            ],
            'status' => [
                'required',
                Rule::in(self::STATUS),
            ],
            // Legacy: tidak wajib lagi, tapi bila diisi harus valid.
            'nama_tabel' => [
                'nullable',
                'string',
                'max:255',
                $uniquePerDesa('nama_tabel'),
                function ($attribute, $value, $fail) {
                    if ($value === null || $value === '') {
                        return;
                    }

                    try {
                        if (!Schema::hasTable($value)) {
                            $fail("Nama tabel '$value' tidak ditemukan dalam database.");
                        }
                    } catch (\Throwable $e) {
                        $fail(
                            'Terjadi kesalahan saat memeriksa nama tabel: '
                                . $e->getMessage()
                        );
                    }
                },
            ],
        ];
    }

    /**
     * Pesan validasi kustom (Bahasa Indonesia).
     */
    private function messages(): array
    {
        return [
            'kode.unique' => 'Kode jenis surat tersebut sudah digunakan.',
            'nama_jenis.unique' => 'Nama jenis surat tersebut sudah digunakan.',
            'slug.unique' => 'Slug tersebut sudah digunakan.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'nama_tabel.unique' => 'Nama tabel tersebut sudah digunakan.',
            'sumber_pengajuan.in' => 'Sumber pengajuan harus warga, admin, atau keduanya.',
            'status.in' => 'Status harus aktif atau nonaktif.',
        ];
    }

    /**
     * Mengisi nilai default sebelum validasi.
     */
    private function prepareInput(Request $request): void
    {
        $request->merge([
            'sumber_pengajuan' => $request->input('sumber_pengajuan') ?: 'keduanya',
            'status' => $request->input('status') ?: 'aktif',
            'kode' => $request->filled('kode')
                ? strtoupper(trim($request->input('kode')))
                : null,
            'slug' => $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : null,
        ]);
    }

    /**
     * Membuat slug unik per desa dari nama jenis surat.
     */
    private function generateUniqueSlug(
        string $namaJenis,
        int $desaId,
        ?int $ignoreId = null
    ): string {
        $base = Str::slug($namaJenis) ?: 'surat';
        $base = Str::limit($base, 90, '');
        $slug = $base;
        $i = 2;

        while (
            JenisSurat::where('desa_id', $desaId)
            ->where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Menampilkan daftar jenis surat.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $this->perPage($request);
        $search = $request->input('search');

        $query = JenisSurat::where('desa_id', $desaId);
        $this->applyFilters($query, $request, $search);

        $jenisSurat = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view(
            'admin.surat.manajemen',
            compact('jenisSurat', 'perPage', 'search')
        );
    }

    /**
     * Mencari jenis surat menggunakan AJAX.
     */
    public function search(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();

            $query = JenisSurat::where('desa_id', $desaId);
            $this->applyFilters($query, $request, $request->input('query'));

            $jenisSurat = $query
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $jenisSurat
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat pencarian Jenis Surat:', [
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    /**
     * Menampilkan data jenis surat dengan pagination.
     */
    public function paginate(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();

            $perPage = $this->perPage($request);

            $query = JenisSurat::where('desa_id', $desaId);
            $this->applyFilters($query, $request, $request->input('query'));

            $jenisSurat = $query
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return response()->json($jenisSurat);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat memuat data Jenis Surat:', [
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data!'
            ], 500);
        }
    }

    /**
     * Menyimpan jenis surat baru.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        $this->prepareInput($request);

        $validator = Validator::make(
            $request->all(),
            $this->rules($desaId),
            $this->messages()
        );

        if ($validator->fails()) {
            Log::error('❌ Validasi jenis surat gagal:', [
                'desa_id' => $desaId,
                'errors' => $validator->errors()->toArray()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $slug = $request->filled('slug')
                ? $request->slug
                : $this->generateUniqueSlug($request->nama_jenis, $desaId);

            $jenisSurat = JenisSurat::create([
                'desa_id' => $desaId,
                'kode' => $request->kode,
                'nama_jenis' => $request->nama_jenis,
                'slug' => $slug,
                'deskripsi' => $request->deskripsi,
                'format_nomor' => $request->format_nomor,
                'sumber_pengajuan' => $request->sumber_pengajuan,
                'status' => $request->status,
                'nama_tabel' => $request->nama_tabel,
            ]);

            Log::info('✅ Jenis surat berhasil ditambahkan:', [
                'id' => $jenisSurat->id,
                'desa_id' => $desaId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis surat berhasil ditambahkan!',
                'data' => $jenisSurat
            ], 201);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat menyimpan jenis surat:', [
                'desa_id' => $desaId,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => ['Terjadi kesalahan, coba lagi!']
                ]
            ], 500);
        }
    }

    /**
     * Mengambil data jenis surat berdasarkan ID untuk edit.
     */
    public function edit($id)
    {
        try {
            $desaId = $this->currentDesaId();

            $jenisSurat = JenisSurat::where('desa_id', $desaId)
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $jenisSurat->id,
                    'kode' => $jenisSurat->kode,
                    'nama_jenis' => $jenisSurat->nama_jenis,
                    'slug' => $jenisSurat->slug,
                    'deskripsi' => $jenisSurat->deskripsi,
                    'format_nomor' => $jenisSurat->format_nomor,
                    'sumber_pengajuan' => $jenisSurat->sumber_pengajuan,
                    'status' => $jenisSurat->status,
                    'nama_tabel' => $jenisSurat->nama_tabel,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Gagal mengambil jenis surat untuk edit:', [
                'id' => $id,
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data jenis surat tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Memperbarui data jenis surat.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        Log::info('📥 Request update jenis surat masuk:', [
            'id' => $id,
            'desa_id' => $desaId,
            'data' => $request->all()
        ]);

        // Pastikan data milik desa yang sedang login.
        $jenisSurat = JenisSurat::where('desa_id', $desaId)->find($id);

        if (!$jenisSurat) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis surat tidak ditemukan!'
            ], 404);
        }

        $this->prepareInput($request);

        $validator = Validator::make(
            $request->all(),
            $this->rules($desaId, $jenisSurat->id),
            $this->messages()
        );

        if ($validator->fails()) {
            Log::error('❌ Validasi gagal saat update jenis surat:', $validator->errors()->toArray());

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Slug: pakai input bila ada, pertahankan yang lama,
            // atau buat baru jika data lama belum punya slug.
            if ($request->filled('slug')) {
                $slug = $request->slug;
            } elseif (!empty($jenisSurat->slug)) {
                $slug = $jenisSurat->slug;
            } else {
                $slug = $this->generateUniqueSlug(
                    $request->nama_jenis,
                    $desaId,
                    $jenisSurat->id
                );
            }

            $jenisSurat->update([
                'desa_id' => $desaId,
                'kode' => $request->kode,
                'nama_jenis' => $request->nama_jenis,
                'slug' => $slug,
                'deskripsi' => $request->deskripsi,
                'format_nomor' => $request->format_nomor,
                'sumber_pengajuan' => $request->sumber_pengajuan,
                'status' => $request->status,
                'nama_tabel' => $request->nama_tabel,
            ]);

            Log::info('✅ Data jenis surat berhasil diperbarui:', [
                'id' => $jenisSurat->id,
                'desa_id' => $desaId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis surat berhasil diperbarui!',
                'data' => $jenisSurat->fresh()
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat update jenis surat:', [
                'id' => $id,
                'desa_id' => $desaId,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'general' => ['Terjadi kesalahan, coba lagi!']
                ]
            ], 500);
        }
    }

    /**
     * Menghapus jenis surat berdasarkan ID.
     */
    public function destroy($id)
    {
        try {
            $desaId = $this->currentDesaId();

            // Hanya boleh menghapus jenis surat milik desa yang sedang login.
            $jenisSurat = JenisSurat::where('desa_id', $desaId)->find($id);

            if (!$jenisSurat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jenis surat tidak ditemukan!'
                ], 404);
            }

            $jenisSurat->delete();

            Log::info('✅ Jenis surat berhasil dihapus:', [
                'id' => $id,
                'desa_id' => $desaId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis surat berhasil dihapus.'
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Kesalahan saat menghapus jenis surat:', [
                'id' => $id,
                'desa_id' => auth()->user()?->desa_id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus jenis surat!'
            ], 500);
        }
    }
}
