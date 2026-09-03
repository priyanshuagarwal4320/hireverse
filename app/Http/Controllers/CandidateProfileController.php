<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateProfileController extends Controller
{
    public function edit(): View
    {
        $candidate = auth()->user()->candidate;

        return view('candidate.profile', compact('candidate'));
    }

    public function update(Request $request): RedirectResponse
{
    $candidate = auth()->user()->candidate;

    $validated = $request->validate([
        'mobile' => ['nullable', 'string', 'max:20'],
        'dob' => ['nullable', 'date', 'before:today'],
        'gender' => ['nullable', 'in:male,female,other'],
        'qualification' => ['nullable', 'string', 'max:255'],
        'experience' => ['nullable', 'string', 'max:255'],
        'skills' => ['nullable', 'string', 'max:500'],
        'city' => ['nullable', 'string', 'max:255'],
        'profile_photo' => ['nullable', 'image', 'max:2048'],
        'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
    ]);

    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
    }

    if ($request->hasFile('resume')) {
        $validated['resume'] = $request->file('resume')->store('resumes', 'public');
    }

    $candidate->update($validated);

    return redirect()->route('candidate.profile.edit')->with('status', 'Profile updated successfully.');
}
}