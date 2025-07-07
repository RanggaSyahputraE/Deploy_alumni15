<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slidersData = [
            [
                'image_path' => 'sliders/slider1.jpg',
                'caption' => 'Selamat Datang di Sistem Informasi Alumni SMPN 15 Pekanbaru',
                'order' => 1,
            ],
            [
                'image_path' => 'sliders/slider2.jpg',
                'caption' => 'Membangun Jaringan Alumni yang Kuat dan Solid',
                'order' => 2,
            ],
            [
                'image_path' => 'sliders/slider3.jpg',
                'caption' => 'Bersama Memajukan Pendidikan di Indonesia',
                'order' => 3,
            ]
        ];

        foreach ($slidersData as $slider) {
            Slider::firstOrCreate(
                ['caption' => $slider['caption']],
                $slider
            );
        }
    }
}