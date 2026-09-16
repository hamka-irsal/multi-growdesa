<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class IklanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'image' => $this->getImageUrl(),

            'is_active' => (bool) $this->is_active,

            'created_at' => $this->created_at?->toDateTimeString(),

            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }

    /**
     * Mendapatkan URL gambar iklan.
     */
    private function getImageUrl(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        $image = trim($this->image);

        // Jika nilai image sudah berupa URL lengkap.
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Menghapus slash di bagian awal.
        $image = ltrim($image, '/');

        // Jika database menyimpan "storage/iklan/banner.jpg",
        // hapus prefix "storage/" agar tidak menjadi /storage/storage/.
        if (str_starts_with($image, 'storage/')) {
            $image = substr($image, strlen('storage/'));
        }

        // Menghasilkan URL berdasarkan disk public Laravel.
        return Storage::disk('public')->url($image);
    }
}
