<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'job_post_id',
        'applied_date',
        'status',
    ];
    protected $casts = [
        'applied_date' => 'date',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class);
    }

    public function currentStage()
    {
        if ($this->status == 'rejected') {
            return 'Not selected';
        }

        if ($this->status == 'selected') {
            return 'Selected';
        }

        if ($this->interview) {
            return 'Interview scheduled';
        }

        if ($this->status == 'shortlisted') {
            return 'Shortlisted';
        }

        return 'Applied';
    }
}