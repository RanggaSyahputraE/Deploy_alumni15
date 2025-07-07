<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniEducation extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'alumni_educations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumni_id',
        'institution_name',
        'degree',
        'major',
        'start_year',
        'end_year',
    ];

    /**
     * Get the alumni that owns the education.
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }
}


