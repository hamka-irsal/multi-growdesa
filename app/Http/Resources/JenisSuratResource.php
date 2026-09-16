<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class JenisSuratResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource->map(function ($item) {

                return [
                    'id' => $item->id,
                    'nama_jenis' => $item->nama_jenis,
                    'slug' => Str::slug($item->nama_jenis),
                    'deskripsi' => $this->getDeskripsi($item->nama_jenis),
                    'icon' => $this->getIcon($item->nama_jenis),
                    'route' => '/buat-surat/' . Str::slug($item->nama_jenis),
                ];
            })->values()
        ];
    }

    /**
     * Deskripsi tiap surat
     */
    private function getDeskripsi($nama)
    {
        return match ($nama) {
            'Surat Pengantar' => 'Pengantar untuk berbagai keperluan',
            'SKTM' => 'Surat Keterangan Tidak Mampu',
            'SKU' => 'Surat Keterangan Usaha',
            'SKD' => 'Surat Keterangan Domisili',
            'Surat Keterangan Hilang' => 'Laporan kehilangan dokumen',
            'Surat Keterangan Mati' => 'Laporan peristiwa kematian',
            default => 'Pelayanan administrasi desa',
        };
    }

    /**
     * Icon sesuai React Native
     */
    private function getIcon($nama)
    {
        return match ($nama) {
            'Surat Pengantar' => 'file-text',
            'SKTM' => 'users',
            'SKU' => 'briefcase',
            'SKD' => 'map-pin',
            'Surat Keterangan Hilang' => 'search',
            'Surat Keterangan Mati' => 'smile',
            default => 'file',
        };
    }
}
