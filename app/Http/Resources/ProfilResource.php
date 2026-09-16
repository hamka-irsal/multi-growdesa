<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);

        $this->status = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        $penduduk = $this->penduduk;

        // Status warga berdasarkan field status_verifikasi pada tabel users
        $statusWarga = match ($this->status_verifikasi) {
            'disetujui' => 'TERVERIFIKASI',
            'ditolak' => 'DITOLAK',
            'pending' => 'PENDING',
            default => 'BELUM VERIFIKASI',
        };


        // Progress Lengkapi Data
        $step = 1;

        if (
            !empty($penduduk?->jenis_kelamin) &&
            !empty($penduduk?->tempat_lahir) &&
            !empty($penduduk?->tanggal_lahir) &&
            !empty($penduduk?->golongan_darah) &&
            !empty($penduduk?->agama) &&
            !empty($penduduk?->kewarganegaraan) &&
            !empty($penduduk?->pendidikan)
        ) {
            $step = 2;
        }

        if (
            !empty($penduduk?->jenis_pekerjaan) &&
            !empty($penduduk?->status_perkawinan) &&
            !empty($penduduk?->status_hubungan_dalam_keluarga) &&
            !empty($penduduk?->ayah) &&
            !empty($penduduk?->ibu)
        ) {
            $step = 3;
        }

        $completed =
            !empty($penduduk?->alamat) &&
            !empty($penduduk?->rt) &&
            !empty($penduduk?->rw) &&
            !empty($penduduk?->desa_kelurahan) &&
            !empty($penduduk?->kecamatan) &&
            !empty($penduduk?->kabupaten_kota) &&
            !empty($penduduk?->provinsi) &&
            !empty($penduduk?->foto_ktp) &&
            !empty($penduduk?->foto_selfie);

        return [
            'success' => $this->status,
            'message' => $this->message,

            'data' => [
                'id' => $this->id,

                'nama_lengkap' => $penduduk?->nama_lengkap,
                'nik' => $penduduk?->nik,
                'email' => $this->email,
                'no_hp' => $penduduk?->no_hp,

                'foto' => $penduduk?->foto
                    ? asset('storage/' . $penduduk->foto)
                    : null,

                'status_warga' => $statusWarga,

                // Untuk halaman akun
                'statistik' => [
                    'surat_proses' => 0,
                    'surat_selesai' => 0,
                ],

                // Untuk halaman Edit Profil
                'progress' => [
                    'current_step' => $step,
                    'total_step' => 3,
                    'completed' => $completed,
                    'percentage' => match (true) {
                        $completed => 100,
                        $step == 3 => 66,
                        $step == 2 => 66,
                        default => 33,
                    },
                ],

                'updated_at' => $penduduk?->updated_at,
            ],
        ];
    }
}
