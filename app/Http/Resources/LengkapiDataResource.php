<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LengkapiDataResource extends JsonResource
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
        /*
        |--------------------------------------------------------------------------
        | STEP 1 - Informasi Pribadi
        |--------------------------------------------------------------------------
        */

        $step1 = filled($this->jenis_kelamin)
            && filled($this->tempat_lahir)
            && filled($this->tanggal_lahir)
            && filled($this->golongan_darah)
            && filled($this->agama)
            && filled($this->kewarganegaraan)
            && filled($this->pendidikan);

        /*
        |--------------------------------------------------------------------------
        | STEP 2 - Pekerjaan dan Keluarga
        |--------------------------------------------------------------------------
        */

        $step2 = filled($this->jenis_pekerjaan)
            && filled($this->status_perkawinan)
            && filled($this->status_hubungan_dalam_keluarga)
            && filled($this->ayah)
            && filled($this->ibu);

        /*
        |--------------------------------------------------------------------------
        | STEP 3 - Alamat dan Dokumen
        |--------------------------------------------------------------------------
        |
        | Field dusun tidak dijadikan syarat karena bersifat nullable.
        | Field kode_pos tidak dijadikan syarat karena belum digunakan
        | pada validasi updateStep3().
        |
        */

        $step3 = filled($this->alamat)
            && filled($this->desa_kelurahan)
            && filled($this->kecamatan)
            && filled($this->kabupaten_kota)
            && filled($this->provinsi)
            && filled($this->foto_ktp)
            && filled($this->foto_selfie);

        /*
        |--------------------------------------------------------------------------
        | HITUNG PROGRESS
        |--------------------------------------------------------------------------
        */

        $completed = $step1 && $step2 && $step3;

        $currentStep = match (true) {
            $completed => 3,
            $step1 && $step2 => 3,
            $step1 => 2,
            default => 1,
        };

        $percentage = match (true) {
            $completed => 100,
            $step1 && $step2 => 66,
            $step1 => 33,
            default => 0,
        };

        return [
            'success' => $this->status,
            'message' => $this->message,

            'data' => [

                // Identitas
                'id' => $this->id,
                'user_id' => $this->user_id,
                'nik' => $this->nik,
                'nama_lengkap' => $this->nama_lengkap,

                // Informasi Pribadi
                'jenis_kelamin' => $this->jenis_kelamin,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'golongan_darah' => $this->golongan_darah,
                'agama' => $this->agama,
                'kewarganegaraan' => $this->kewarganegaraan,
                'pendidikan' => $this->pendidikan,

                // Pekerjaan dan Keluarga
                'jenis_pekerjaan' => $this->jenis_pekerjaan,
                'status_perkawinan' => $this->status_perkawinan,
                'tanggal_perkawinan' => $this->tanggal_perkawinan,
                'status_hubungan_dalam_keluarga' => $this->status_hubungan_dalam_keluarga,
                'ayah' => $this->ayah,
                'ibu' => $this->ibu,

                // Alamat
                'alamat' => $this->alamat,
                'dusun' => $this->dusun,
                'desa_kelurahan' => $this->desa_kelurahan,
                'kecamatan' => $this->kecamatan,
                'kabupaten_kota' => $this->kabupaten_kota,
                'provinsi' => $this->provinsi,

                // Dokumen
                'foto' => $this->foto
                    ? asset('storage/' . $this->foto)
                    : null,

                'foto_selfie' => $this->foto_selfie
                    ? asset('storage/' . $this->foto_selfie)
                    : null,

                'foto_ktp' => $this->foto_ktp
                    ? asset('storage/' . $this->foto_ktp)
                    : null,

                // Progress Wizard
                'progress' => [
                    'current_step' => $currentStep,
                    'total_step' => 3,
                    'completed' => $completed,
                    'percentage' => $percentage,
                ],

                // Timestamp
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
