<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuratResource;
use App\Http\Resources\SuratRiwayatResource;
use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    /**
     * Riwayat Surat
     *
     * Endpoint:
     * GET /api/v1/surat
     *
     * Filter:
     * GET /api/v1/surat?status=proses
     * GET /api/v1/surat?status=selesai
     * GET /api/v1/surat?status=tolak
     */
    public function index(Request $request)
    {
        /**
         * Validasi filter status
         */
        $request->validate([
            'status' => [
                'nullable',
                'string',
                'in:proses,selesai,tolak',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        /**
         * Ambil user beserta data penduduk
         */
        $user = $request->user()->load('penduduk');

        /**
         * Pastikan user memiliki data penduduk
         */
        if (!$user->penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        /**
         * Query riwayat surat milik penduduk
         */
        $query = Surat::with([
            'jenisSurat',
        ])
            ->where(
                'penduduk_id',
                $user->penduduk->id
            );

        /**
         * Filter berdasarkan status
         */
        if ($request->filled('status')) {
            $query->where(
                'status_surat',
                $request->status
            );
        }

        /**
         * Ambil riwayat surat terbaru
         */
        $surat = $query
            ->orderByDesc('tanggal_pengajuan')
            ->orderByDesc('id')
            ->paginate(
                $request->input(
                    'per_page',
                    10
                )
            );

        /**
         * Response riwayat surat
         */
        return SuratRiwayatResource::collection(
            $surat
        )
            ->additional([
                'success' => true,

                'message' =>
                $request->filled('status')
                    ? 'Riwayat surat dengan status ' .
                    $request->status .
                    ' berhasil diambil.'
                    : 'Riwayat surat berhasil diambil.',
            ]);
    }

    /**
     * Detail Surat
     *
     * Endpoint:
     * GET /api/v1/surat/{id}
     */
    public function show(Request $request, $id)
    {
        /**
         * Ambil user beserta data penduduk
         */
        $user = $request->user()->load('penduduk');

        /**
         * Pastikan user memiliki data penduduk
         */
        if (!$user->penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        /**
         * Ambil surat dan pastikan surat
         * merupakan milik penduduk yang login
         */
        $surat = Surat::with([
            'penduduk',
            'jenisSurat',
        ])
            ->where(
                'id',
                $id
            )
            ->where(
                'penduduk_id',
                $user->penduduk->id
            )
            ->first();

        /**
         * Surat tidak ditemukan
         */
        if (!$surat) {
            return response()->json([
                'success' => false,
                'message' => 'Surat tidak ditemukan.',
            ], 404);
        }

        /**
         * Response detail surat
         *
         * SuratResource akan membaca:
         * - model
         * - fields
         * - slug
         * - nama
         * - icon
         * - color
         *
         * dari config/surat.php
         */
        return new SuratResource(
            true,
            'Detail surat berhasil diambil.',
            $surat
        );
    }

    /**
     * Ajukan Surat
     *
     * Endpoint:
     * POST /api/v1/surat
     *
     * Contoh body:
     *
     * {
     *     "slug": "surat-pengantar",
     *     "keperluan_antar": "Pengurusan administrasi",
     *     "keterangan_antar": "Keterangan tambahan"
     * }
     */
    public function store(Request $request)
    {
        /**
         * Ambil user beserta data penduduk
         */
        $user = $request->user()->load('penduduk');

        /**
         * Pastikan user memiliki data penduduk
         */
        if (!$user->penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan.',
            ], 404);
        }

        /**
         * Validasi slug
         */
        $request->validate([
            'slug' => [
                'required',
                'string',
            ],
        ]);

        /**
         * Ambil seluruh konfigurasi surat
         */
        $semuaConfig = config('surat', []);

        /**
         * Cari konfigurasi surat berdasarkan slug
         *
         * Contoh:
         * surat_kehilangan
         */
        $config = collect($semuaConfig)->first(
            function ($item) use ($request) {
                return ($item['slug'] ?? null) === $request->slug;
            }
        );

        /**
         * Konfigurasi surat tidak ditemukan
         */
        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis surat tidak ditemukan.',
            ], 404);
        }

        /**
         * Pastikan surat diaktifkan untuk API Mobile
         */
        if (
            isset($config['api_enabled']) &&
            $config['api_enabled'] === false
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis surat belum tersedia untuk aplikasi.',
            ], 403);
        }

        /**
         * Cari jenis surat pada database
         * berdasarkan nama_tabel
         *
         * Contoh:
         * nama_tabel = surat_kehilangan
         */
        $jenisSurat = JenisSurat::where(
            'nama_tabel',
            $request->slug
        )->first();

        /**
         * Data jenis surat tidak ditemukan
         */
        if (!$jenisSurat) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis surat tidak ditemukan.',
            ], 404);
        }

        /**
         * Validasi input tambahan
         * berdasarkan konfigurasi surat
         */
        $validated = $request->validate(
            $config['validation'] ?? []
        );

        /**
         * Ambil model detail surat
         */
        $model = $config['model'] ?? null;

        /**
         * Pastikan model tersedia
         */
        if (
            empty($model) ||
            !class_exists($model)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Model jenis surat tidak ditemukan.',
            ], 500);
        }

        DB::beginTransaction();

        try {

            /**
             * Ambil data penduduk dari user yang login
             */
            $penduduk = $user->penduduk;

            /**
             * Simpan data utama ke tabel surat
             *
             * kode_unik tidak dikirim dari controller
             * karena sudah dibuat otomatis pada
             * event creating() di model Surat.
             */
            $surat = Surat::create([

                'penduduk_id' =>
                $penduduk->id,

                'jenis_surat_id' =>
                $jenisSurat->id,

                'no_surat' =>
                null,

                'nama_lengkap' =>
                $penduduk->nama_lengkap,

                'tanggal_pengajuan' =>
                now(),

                'tanggal_dibuat' =>
                null,

                'status_surat' =>
                'proses',

                'persetujuan' =>
                null,

                'dibuat_oleh' =>
                null,

                'keterangan' =>
                $config['keterangan'] ?? null,

                'file_surat' =>
                null,

            ]);

            /**
             * Ambil hanya field yang diizinkan
             * berdasarkan konfigurasi surat
             */
            $dataTambahan = collect($validated)
                ->only(
                    $config['fields'] ?? []
                )
                ->toArray();

            /**
             * Tambahkan penduduk_id secara otomatis
             *
             * Tidak perlu dikirim dari Mobile/Postman.
             */
            $dataTambahan['penduduk_id'] =
                $penduduk->id;

            /**
             * Tambahkan surat_id secara otomatis
             *
             * Tidak perlu dikirim dari Mobile/Postman.
             */
            $dataTambahan['surat_id'] =
                $surat->id;

            /**
             * Simpan data detail surat
             *
             * Contoh:
             * SuratKehilangan
             * SuratPengantar
             * SuratKematian
             * SuratUsaha
             */
            $model::create(
                $dataTambahan
            );

            /**
             * Simpan seluruh perubahan
             */
            DB::commit();

            /**
             * Ambil ulang relasi
             */
            $surat->load([
                'penduduk',
                'jenisSurat',
            ]);

            /**
             * Response pengajuan berhasil
             */
            return new SuratResource(
                true,
                'Pengajuan surat berhasil dibuat.',
                $surat
            );
        } catch (\Throwable $e) {

            /**
             * Batalkan seluruh proses
             */
            DB::rollBack();

            /**
             * Simpan error ke log Laravel
             */
            report($e);

            /**
             * Tampilkan error sementara untuk debugging
             */
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan surat.',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
