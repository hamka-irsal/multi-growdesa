<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $berita_data = [];
        $kategori_names = ['Pengumuman', 'Kegiatan', 'Pembangunan', 'Kesehatan'];
        $kategori_ids = [];

        // Create Categories first
        foreach ($kategori_names as $name) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $kategori_ids[] = $cat->id;
        }

        for ($i = 1; $i <= 15; $i++) {
            $judul = 'Contoh Berita Desa ke-' . $i;
            $berita_data[] = [
                'judul'           => $judul,
                'slug'            => Str::slug($judul),
                'category_id'     => $kategori_ids[array_rand($kategori_ids)],
                'deskripsi'       => '<p>Ini adalah isi detail dari berita percobaan ke-' . $i . '. Berita ini di-generate secara otomatis untuk keperluan testing API.</p>',
                'penulis'         => 'Admin Desa',
                'tanggal_publish' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'foto'            => 'default-berita.jpg',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ];
        }

        Berita::insert($berita_data);
    }
}
