<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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

            'kategori' => $this->kategori,

            'harga' => (float) $this->harga,

            'harga_format' => 'Rp ' . number_format(
                $this->harga,
                0,
                ',',
                '.'
            ),

            'foto' => $this->foto
                ? url(Storage::url($this->foto))
                : null,
        ];
    }
}
