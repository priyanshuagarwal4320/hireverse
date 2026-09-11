<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Company $company): RedirectResponse
    {
        $candidate = auth()->user()->candidate;

        abort_if(!$candidate, 403);
        abort_if(!$candidate->canReviewCompany($company->id), 403, 'You are not eligible to review this company.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        $company->reviews()->create([
            'candidate_id' => $candidate->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return back()->with('status', 'Thanks for your review!');
    }
}