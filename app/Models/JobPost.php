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
        'skills',
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
    public function matchPercentage($candidateSkills)
    {
        if (! $this->skills || ! $candidateSkills) {
            return null;
        }

        $jobSkills = array_filter(array_map('trim', explode(',', strtolower($this->skills))));
        $candidateSkillsList = array_filter(array_map('trim', explode(',', strtolower($candidateSkills))));

        if (count($jobSkills) === 0) {
            return null;
        }

        $matched = count(array_intersect($jobSkills, $candidateSkillsList));

        return round(($matched / count($jobSkills)) * 100);
    }
    public function incrementViews()
    {
        $this->increment('views_count');
    }
    protected $casts = [
        'last_date' => 'date',
    ];
}
