<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruRole = Role::where('name', 'guru')->first();

        if ($guruRole) {
            $teachersData = [
                [
                    'user' => [
                        'name' => 'Dra. Sari Dewi',
                        'email' => 'sari.dewi@smpn15.sch.id',
                        'password' => Hash::make('guru123'),
                    ],
                    'teacher' => [
                        'full_name' => 'Dra. Sari Dewi, M.Pd',
                        'nip' => '196505151990032001',
                        'phone_number' => '081234567890',
                        'address' => 'Jl. Pendidikan No. 123, Pekanbaru',
                    ]
                ],
                [
                    'user' => [
                        'name' => 'Drs. Bambang Sutrisno',
                        'email' => 'bambang.sutrisno@smpn15.sch.id',
                        'password' => Hash::make('guru123'),
                    ],
                    'teacher' => [
                        'full_name' => 'Drs. Bambang Sutrisno, M.Pd',
                        'nip' => '196803201992031002',
                        'phone_number' => '081987654321',
                        'address' => 'Jl. Guru No. 456, Pekanbaru',
                    ]
                ],
                [
                    'user' => [
                        'name' => 'Rina Marlina',
                        'email' => 'rina.marlina@smpn15.sch.id',
                        'password' => Hash::make('guru123'),
                    ],
                    'teacher' => [
                        'full_name' => 'Rina Marlina, S.Pd',
                        'nip' => '198012151999032003',
                        'phone_number' => '082345678901',
                        'address' => 'Jl. Sekolah No. 789, Pekanbaru',
                    ]
                ]
            ];

            foreach ($teachersData as $data) {
                // Buat user
                $user = User::firstOrCreate(
                    ['email' => $data['user']['email']],
                    array_merge($data['user'], ['role_id' => $guruRole->id])
                );

                // Buat data guru
                Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    $data['teacher']
                );
            }
        }
    }
}