<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotifResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Berita
            |--------------------------------------------------------------------------
            |
            | Hanya menampilkan berita yang dibuat dalam 24 jam terakhir.
            | Berita yang sudah lebih dari 24 jam tidak akan ditampilkan,
            | baik pada akun lama maupun akun baru.
            |
            */

            'berita' => collect($this->resource['berita'] ?? [])
                ->filter(function ($item) {

                    if (!$item->created_at) {
                        return false;
                    }

                    return Carbon::parse($item->created_at)
                        ->greaterThanOrEqualTo(
                            Carbon::now()->subHours(24)
                        );
                })
                ->sortByDesc(function ($item) {
                    return Carbon::parse($item->created_at);
                })
                ->map(function ($item) {
                    return [
                        'id' => $item->id,

                        'judul' => $item->judul,

                        'deskripsi' => $item->deskripsi,

                        'waktu' => $item->created_at
                            ? Carbon::parse($item->created_at)
                                ->locale('id')
                                ->diffForHumans()
                            : null,
                    ];
                })
                ->values(),

            /*
            |--------------------------------------------------------------------------
            | Surat
            |--------------------------------------------------------------------------
            */

            'surat' => collect($this->resource['surat'] ?? [])
                ->map(function ($item) {

                    $namaSurat = $item->jenisSurat?->nama_surat ?? 'Surat';

                    if ($item->status_surat === 'selesai') {

                        $judul = 'Pengajuan Surat Disetujui';

                        $deskripsi =
                            $namaSurat .
                            ' Anda telah berhasil diverifikasi dan ditandatangani oleh Kepala Desa.';

                    } elseif ($item->status_surat === 'tolak') {

                        $judul = 'Pengajuan Surat Ditolak';

                        $deskripsi =
                            $namaSurat .
                            ' Pengajuan surat Anda ditolak.'
                            . (
                                !empty($item->keterangan)
                                    ? ' ' . $item->keterangan
                                    : ''
                            );

                    } else {

                        $judul = 'Status Pengajuan Surat';

                        $deskripsi =
                            $namaSurat .
                            ' mengalami perubahan status.';
                    }

                    return [
                        'id' => $item->id,

                        'judul' => $judul,

                        'deskripsi' => $deskripsi,

                        'waktu' => $item->updated_at
                            ? Carbon::parse($item->updated_at)
                                ->locale('id')
                                ->diffForHumans()
                            : null,
                    ];
                })
                ->values(),

            /*
            |--------------------------------------------------------------------------
            | Verifikasi Akun
            |--------------------------------------------------------------------------
            */

            'verifikasi' => collect($this->resource['verifikasi'] ?? [])
                ->map(function ($item) {

                    if ($item->status_verifikasi === 'disetujui') {

                        $judul = 'Verifikasi Profil Berhasil';

                        $deskripsi =
                            'Selamat! Pembaharuan data diri dan kelengkapan berkas Anda telah terverifikasi oleh Admin Desa.';

                    } elseif ($item->status_verifikasi === 'ditolak') {

                        $judul = 'Verifikasi Profil Ditolak';

                        $deskripsi =
                            'Verifikasi data diri dan kelengkapan berkas Anda ditolak oleh Admin Desa.';

                    } else {

                        $judul = 'Status Verifikasi Profil';

                        $deskripsi =
                            'Status verifikasi profil Anda telah diperbarui.';
                    }

                    return [
                        'id' => $item->id,

                        'judul' => $judul,

                        'deskripsi' => $deskripsi,

                        'waktu' => $item->updated_at
                            ? Carbon::parse($item->updated_at)
                                ->locale('id')
                                ->diffForHumans()
                            : null,
                    ];
                })
                ->values(),
        ];
    }
}
