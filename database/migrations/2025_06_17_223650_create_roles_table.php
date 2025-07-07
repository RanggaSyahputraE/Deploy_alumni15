<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, alumni, guru
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed initial roles
        \Illuminate\Support\Facades\DB::table('roles')->insert([
            [
                'name' => 'admin', 
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'alumni', 
                'description' => 'Alumni user',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'guru', 
                'description' => 'Teacher user',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};