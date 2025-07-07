<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'address',
        'graduation_year',
        'phone_number',
        'social_media_facebook',
        'social_media_instagram',
        'social_media_linkedin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Get the user that owns the alumni.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the educations for the alumni.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(AlumniEducation::class);
    }

    /**
     * Get the works for the alumni.
     */
    public function works(): HasMany
    {
        return $this->hasMany(AlumniWork::class);
    }
}