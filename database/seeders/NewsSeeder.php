<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@smpn15.sch.id')->first();
        $guru = User::whereHas('role', function($query) {
            $query->where('name', 'guru');
        })->first();

        if ($admin) {
            $newsData = [
                [
                    'user_id' => $admin->id,
                    'title' => 'Selamat Datang di Sistem Informasi Alumni SMPN 15',
                    'content' => 'Kami dengan bangga memperkenalkan Sistem Informasi Alumni SMPN 15 Pekanbaru. Sistem ini dirancang untuk memfasilitasi komunikasi dan networking antara alumni, guru, dan sekolah. Melalui platform ini, alumni dapat memperbarui data pribadi, mencari teman-teman alumni, dan mendapatkan informasi terbaru dari sekolah.',
                ],
                [
                    'user_id' => $admin->id,
                    'title' => 'Reuni Akbar Alumni SMPN 15 Tahun 2024',
                    'content' => 'SMPN 15 Pekanbaru akan mengadakan Reuni Akbar Alumni pada tanggal 15 Desember 2024. Acara ini akan dihadiri oleh alumni dari berbagai angkatan. Pendaftaran dapat dilakukan melalui sistem ini atau menghubungi panitia. Mari kita berkumpul kembali dan mengenang masa-masa indah di SMPN 15.',
                ],
                [
                    'user_id' => $admin->id,
                    'title' => 'Program Beasiswa untuk Alumni Berprestasi',
                    'content' => 'Yayasan Alumni SMPN 15 membuka program beasiswa untuk alumni yang ingin melanjutkan pendidikan ke jenjang yang lebih tinggi. Beasiswa ini ditujukan untuk alumni yang memiliki prestasi akademik dan non-akademik yang baik. Informasi lengkap dapat dilihat di pengumuman resmi sekolah.',
                ]
            ];

            foreach ($newsData as $news) {
                News::firstOrCreate(
                    ['title' => $news['title']],
                    $news
                );
            }
        }

        if ($guru) {
            News::firstOrCreate(
                ['title' => 'Tips Sukses Berkarir untuk Alumni'],
                [
                    'user_id' => $guru->id,
                    'title' => 'Tips Sukses Berkarir untuk Alumni',
                    'content' => 'Sebagai guru yang telah lama mengabdi di SMPN 15, saya ingin berbagi beberapa tips untuk alumni dalam membangun karir yang sukses. Pertama, terus belajar dan mengembangkan skill. Kedua, bangun networking yang kuat. Ketiga, jangan takut untuk mengambil tantangan baru. Keempat, selalu ingat nilai-nilai yang telah diajarkan di sekolah.',
                ]
            );
        }
    }
}