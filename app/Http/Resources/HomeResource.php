<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HomeResource extends JsonResource
{
    /**
     * Transform data home menjadi response API.
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Data Beranda Berhasil Diambil',

            'data' => [
                'iklan' => $this->resource['iklans']
                    ->map(function ($iklan) {
                        return [
                            'id' => $iklan->id,

                            'image' => $iklan->image
                                ? url(Storage::url($iklan->image))
                                : null,
                        ];
                    })
                    ->values(),

                'berita_terbaru' => $this->resource['berita_terbaru']
                    ->map(function ($berita) {
                        return [
                            'id' => $berita->id,

                            'judul' => $berita->judul,

                            'slug' => $berita->slug,

                            'kategori' => [
                                'id' => $berita->category?->id,
                                'name' => $berita->category?->name,
                                'slug' => $berita->category?->slug,
                            ],

                            'foto' => $berita->foto
                                ? url(Storage::url($berita->foto))
                                : null,

                            'tanggal_publish' => $berita->tanggal_publish
                                ? $berita->tanggal_publish
                                    ->locale('id')
                                    ->diffForHumans()
                                : null,
                        ];
                    })
                    ->values(),
            ],
        ];
    }
}
