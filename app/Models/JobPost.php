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
        'category',
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
    public function similarJobs()
    {
        return JobPost::where('status', 'open')
            ->where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->latest()
            ->take(3)
            ->get();
    }
    protected $casts = [
        'last_date' => 'date',
    ];
}
