<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // ✅ disesuaikan dari 'role' ke 'role_id'
        'profile_photo_path',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        
        
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ✅ ditambahkan: relasi ke tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ✅ diperbaiki: gunakan relasi role->name, bukan field string langsung
    public function isAdmin()
    {
        return $this->role?->name === 'admin';
    }

    public function isAlumni()
    {
        return $this->role?->name === 'alumni';
    }

    public function isGuru()
    {
        return $this->role?->name === 'guru';
    }

    // Relationships
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }
}
