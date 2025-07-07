<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobVacancy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'company_name',
        'location',
        'description',
        'requirements',
        'contact_email',
        'application_link',
        'deadline',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get the user that owns the job vacancy.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}