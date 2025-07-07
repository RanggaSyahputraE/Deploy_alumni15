<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\AlumniWork;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumniRole = Role::where('name', 'alumni')->first();

        if ($alumniRole) {
            // Data alumni contoh
            $alumniData = [
                [
                    'user' => [
                        'name' => 'Budi Santoso',
                        'email' => 'budi.santoso@gmail.com',
                        'password' => Hash::make('password123'),
                    ],
                    'alumni' => [
                        'full_name' => 'Budi Santoso',
                        'place_of_birth' => 'Pekanbaru',
                        'date_of_birth' => '1995-05-15',
                        'gender' => 'Laki-laki',
                        'address' => 'Jl. Sudirman No. 123, Pekanbaru',
                        'graduation_year' => 2010,
                        'phone_number' => '081234567890',
                        'social_media_facebook' => 'https://facebook.com/budisantoso',
                        'social_media_instagram' => 'https://instagram.com/budisantoso',
                    ],
                    'educations' => [
                        [
                            'institution_name' => 'SMAN 1 Pekanbaru',
                            'degree' => 'SMA',
                            'major' => 'IPA',
                            'start_year' => 2010,
                            'end_year' => 2013,
                        ],
                        [
                            'institution_name' => 'Universitas Riau',
                            'degree' => 'S1',
                            'major' => 'Teknik Informatika',
                            'start_year' => 2013,
                            'end_year' => 2017,
                        ]
                    ],
                    'works' => [
                        [
                            'company_name' => 'PT. Teknologi Nusantara',
                            'position' => 'Software Developer',
                            'description' => 'Mengembangkan aplikasi web dan mobile',
                            'start_date' => '2017-08-01',
                            'end_date' => '2020-12-31',
                            'is_current' => false,
                        ],
                        [
                            'company_name' => 'PT. Digital Indonesia',
                            'position' => 'Senior Developer',
                            'description' => 'Lead developer untuk proyek e-commerce',
                            'start_date' => '2021-01-01',
                            'end_date' => null,
                            'is_current' => true,
                        ]
                    ]
                ],
                [
                    'user' => [
                        'name' => 'Siti Nurhaliza',
                        'email' => 'siti.nurhaliza@gmail.com',
                        'password' => Hash::make('password123'),
                    ],
                    'alumni' => [
                        'full_name' => 'Siti Nurhaliza',
                        'place_of_birth' => 'Pekanbaru',
                        'date_of_birth' => '1996-08-20',
                        'gender' => 'Perempuan',
                        'address' => 'Jl. Ahmad Yani No. 456, Pekanbaru',
                        'graduation_year' => 2011,
                        'phone_number' => '081987654321',
                        'social_media_facebook' => 'https://facebook.com/sitinurhaliza',
                        'social_media_instagram' => 'https://instagram.com/sitinurhaliza',
                    ],
                    'educations' => [
                        [
                            'institution_name' => 'SMAN 2 Pekanbaru',
                            'degree' => 'SMA',
                            'major' => 'IPS',
                            'start_year' => 2011,
                            'end_year' => 2014,
                        ],
                        [
                            'institution_name' => 'Universitas Islam Negeri Sultan Syarif Kasim',
                            'degree' => 'S1',
                            'major' => 'Pendidikan Bahasa Indonesia',
                            'start_year' => 2014,
                            'end_year' => 2018,
                        ]
                    ],
                    'works' => [
                        [
                            'company_name' => 'SMPN 5 Pekanbaru',
                            'position' => 'Guru Bahasa Indonesia',
                            'description' => 'Mengajar mata pelajaran Bahasa Indonesia',
                            'start_date' => '2018-07-01',
                            'end_date' => null,
                            'is_current' => true,
                        ]
                    ]
                ],
                [
                    'user' => [
                        'name' => 'Ahmad Rizki',
                        'email' => 'ahmad.rizki@gmail.com',
                        'password' => Hash::make('password123'),
                    ],
                    'alumni' => [
                        'full_name' => 'Ahmad Rizki Pratama',
                        'place_of_birth' => 'Pekanbaru',
                        'date_of_birth' => '1997-03-10',
                        'gender' => 'Laki-laki',
                        'address' => 'Jl. Diponegoro No. 789, Pekanbaru',
                        'graduation_year' => 2012,
                        'phone_number' => '082345678901',
                        'social_media_linkedin' => 'https://linkedin.com/in/ahmadrizki',
                    ],
                    'educations' => [
                        [
                            'institution_name' => 'SMAN 3 Pekanbaru',
                            'degree' => 'SMA',
                            'major' => 'IPA',
                            'start_year' => 2012,
                            'end_year' => 2015,
                        ],
                        [
                            'institution_name' => 'Institut Teknologi Bandung',
                            'degree' => 'S1',
                            'major' => 'Teknik Elektro',
                            'start_year' => 2015,
                            'end_year' => 2019,
                        ]
                    ],
                    'works' => [
                        [
                            'company_name' => 'PT. Listrik Negara (PLN)',
                            'position' => 'Engineer',
                            'description' => 'Maintenance sistem kelistrikan',
                            'start_date' => '2019-09-01',
                            'end_date' => null,
                            'is_current' => true,
                        ]
                    ]
                ]
            ];

            foreach ($alumniData as $data) {
                // Buat user
                $user = User::firstOrCreate(
                    ['email' => $data['user']['email']],
                    array_merge($data['user'], ['role_id' => $alumniRole->id])
                );

                // Buat data alumni
                $alumni = Alumni::firstOrCreate(
                    ['user_id' => $user->id],
                    $data['alumni']
                );

                // Buat data pendidikan
                foreach ($data['educations'] as $education) {
                    AlumniEducation::firstOrCreate(
                        [
                            'alumni_id' => $alumni->id,
                            'institution_name' => $education['institution_name']
                        ],
                        $education
                    );
                }

                // Buat data pekerjaan
                foreach ($data['works'] as $work) {
                    AlumniWork::firstOrCreate(
                        [
                            'alumni_id' => $alumni->id,
                            'company_name' => $work['company_name'],
                            'position' => $work['position']
                        ],
                        $work
                    );
                }
            }
        }
    }
}