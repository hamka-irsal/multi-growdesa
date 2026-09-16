<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Iklan;
use Carbon\Carbon;

class IklanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $iklan_data = [
            [
                'image' => 'iklan-1.jpg',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'iklan-2.jpg',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'iklan-3.jpg',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Iklan::insert($iklan_data);
    }
}
