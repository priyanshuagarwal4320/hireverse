<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'candidate_id',
        'company_id',
        'rating',
        'review',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}