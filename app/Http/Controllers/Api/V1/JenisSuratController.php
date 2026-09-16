<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Daftar Jenis Surat
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $jenisSurat = JenisSurat::orderBy('nama_jenis')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar jenis surat berhasil diambil.',
            'data' => [

                'header' => [
                    'title' => 'Pelayanan Surat Desa',
                    'subtitle' => 'Pilih jenis surat yang ingin Anda ajukan.',
                ],

                'menu' => [
                    'buat_surat' => [
                        'title' => 'Buat Surat Baru',
                        'subtitle' => 'Ajukan permohonan surat layanan desa',
                    ],
                    'riwayat_surat' => [
                        'title' => 'Riwayat Surat',
                        'subtitle' => 'Pantau status pengajuan surat Anda',
                        // 'total' => Surat::where('user_id', $user->id)->count(),
                    ],
                ],

                'total_jenis_surat' => $jenisSurat->count(),

                'jenis_surat' => $jenisSurat->map(function ($item) {

                    return [
                        'id' => $item->id,
                        'nama_jenis' => $item->nama_jenis,
                        'deskripsi' => $this->getDeskripsi($item->nama_jenis),
                        'nama_tabel' => $item->nama_tabel,
                    ];
                }),

            ],
        ]);
    }

    /**
     * Deskripsi otomatis berdasarkan nama surat
     */
    private function getDeskripsi($nama)
    {
        return match (strtolower($nama)) {

            'surat pengantar' => 'Pengantar untuk berbagai keperluan',

            'sktm',
            'surat keterangan tidak mampu'
                => 'Surat Keterangan Tidak Mampu',

            'sku',
            'surat keterangan usaha'
                => 'Surat Keterangan Usaha',

            'skd',
            'surat keterangan domisili'
                => 'Surat Keterangan Domisili',

            'surat keterangan hilang'
                => 'Laporan kehilangan dokumen',

            'surat keterangan mati'
                => 'Laporan peristiwa kematian',

            default => 'Layanan administrasi desa',
        };
    }
}
