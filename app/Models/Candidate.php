<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mobile',
        'dob',
        'gender',
        'profile_photo',
        'resume',
        'qualification',
        'experience',
        'skills',
        'city',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
    public function savedJobs(): HasMany
    {
        return $this->hasMany(SavedJob::class);
    }
    public function profileCompletion()
    {
        $fields = ['mobile', 'dob', 'gender', 'profile_photo', 'resume', 'qualification', 'experience', 'skills', 'city'];
        $filled = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }
}
