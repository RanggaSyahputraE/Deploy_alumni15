<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@smpn15.sch.id'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('admin123'),
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}