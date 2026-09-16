<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $fotoUrl = null;

        if ($this->foto) {
            $fotoUrl = filter_var(
                $this->foto,
                FILTER_VALIDATE_URL
            )
                ? $this->foto
                : asset('storage/' . ltrim($this->foto, '/'));
        }

        return [
            'id' => $this->id,

            'judul' => $this->judul,

            'slug' => $this->slug,

            'kategori' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],

            'deskripsi' => $this->deskripsi,

            'penulis' => $this->penulis,

            'tanggal_publish' => $this->tanggal_publish
                ? \Carbon\Carbon::parse($this->tanggal_publish)
                ->translatedFormat('d M Y')
                : null,

            'foto' => $fotoUrl,

            'created_at' => $this->created_at?->toDateTimeString(),

            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
