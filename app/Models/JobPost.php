<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'job_title',
        'job_description',
        'job_type',
        'experience',
        'salary',
        'location',
        'vacancies',
        'last_date',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
    protected $casts = [
        'last_date' => 'date',
    ];
}