<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobVacancy;
use App\Models\User;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@smpn15.sch.id')->first();

        if ($admin) {
            $jobVacanciesData = [
                [
                    'user_id' => $admin->id,
                    'title' => 'Software Developer',
                    'company_name' => 'PT. Teknologi Digital Indonesia',
                    'location' => 'Pekanbaru, Riau',
                    'description' => 'Kami mencari Software Developer yang berpengalaman dalam pengembangan aplikasi web dan mobile. Kandidat ideal memiliki kemampuan programming yang kuat dan dapat bekerja dalam tim.',
                    'requirements' => 'S1 Teknik Informatika/Sistem Informasi, Pengalaman minimal 2 tahun, Menguasai PHP, JavaScript, MySQL, Framework Laravel/CodeIgniter',
                    'contact_email' => 'hr@teknologidigital.co.id',
                    'application_link' => 'https://teknologidigital.co.id/careers',
                    'deadline' => '2024-12-31',
                ],
                [
                    'user_id' => $admin->id,
                    'title' => 'Marketing Executive',
                    'company_name' => 'PT. Mandiri Sejahtera',
                    'location' => 'Pekanbaru, Riau',
                    'description' => 'Posisi Marketing Executive untuk mengembangkan strategi pemasaran dan meningkatkan brand awareness perusahaan. Kandidat harus memiliki kreativitas tinggi dan kemampuan komunikasi yang baik.',
                    'requirements' => 'S1 Marketing/Komunikasi, Pengalaman di bidang marketing minimal 1 tahun, Kemampuan presentasi yang baik, Menguasai digital marketing',
                    'contact_email' => 'recruitment@mandirisejahtera.co.id',
                    'application_link' => null,
                    'deadline' => '2024-11-30',
                ],
                [
                    'user_id' => $admin->id,
                    'title' => 'Guru Matematika',
                    'company_name' => 'SMA Swasta Harapan Bangsa',
                    'location' => 'Pekanbaru, Riau',
                    'description' => 'Dibutuhkan guru Matematika untuk mengajar di SMA Swasta Harapan Bangsa. Kandidat harus memiliki passion dalam mengajar dan dapat menciptakan suasana belajar yang menyenangkan.',
                    'requirements' => 'S1 Pendidikan Matematika/Matematika, Memiliki sertifikat pendidik, Pengalaman mengajar minimal 1 tahun, Menguasai teknologi pembelajaran',
                    'contact_email' => 'info@harapanbangsa.sch.id',
                    'application_link' => null,
                    'deadline' => '2024-10-31',
                ]
            ];

            foreach ($jobVacanciesData as $jobVacancy) {
                JobVacancy::firstOrCreate(
                    [
                        'title' => $jobVacancy['title'],
                        'company_name' => $jobVacancy['company_name']
                    ],
                    $jobVacancy
                );
            }
        }
    }
}