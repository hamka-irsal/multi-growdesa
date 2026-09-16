<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DetailBeritaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'judul' => $this->judul,

            'slug' => $this->slug,

            'kategori' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],

            // Isi lengkap berita
            'deskripsi' => $this->deskripsi,

            'penulis' => $this->penulis,

            'tanggal_publish' => $this->tanggal_publish
                ? $this->tanggal_publish->translatedFormat('d F Y')
                : null,

            'foto' => $this->foto
                ? url(Storage::url($this->foto))
                : null,

            'created_at' => $this->created_at
                ? $this->created_at->toDateTimeString()
                : null,

            'updated_at' => $this->updated_at
                ? $this->updated_at->toDateTimeString()
                : null,
        ];
    }
}
