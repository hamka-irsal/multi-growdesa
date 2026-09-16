<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DetailProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'nama_produk' => $this->nama_produk,

            'slug' => $this->slug,

            'deskripsi' => $this->deskripsi,

            'harga' => (float) $this->harga,

            'harga_format' => 'Rp ' . number_format(
                $this->harga,
                0,
                ',',
                '.'
            ),

            'stok' => (int) $this->stok,

            'foto' => $this->foto
                ? url(Storage::url($this->foto))
                : null,

            'kategori' => [
                'name' => $this->kategori,
                'slug' => $this->kategori
                    ? \Illuminate\Support\Str::slug($this->kategori)
                    : null,
            ],

            'asal_desa' => $this->asal_desa,

            'kontak' => $this->kontak,

            'created_at' => $this->created_at
                ? $this->created_at->toDateTimeString()
                : null,

            'updated_at' => $this->updated_at
                ? $this->updated_at->toDateTimeString()
                : null,
        ];
    }
}
