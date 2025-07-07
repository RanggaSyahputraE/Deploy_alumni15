<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator dengan akses penuh ke sistem'
            ],
            [
                'name' => 'alumni',
                'description' => 'Alumni SMPN 15 Pekanbaru'
            ],
            [
                'name' => 'guru',
                'description' => 'Guru SMPN 15 Pekanbaru'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}