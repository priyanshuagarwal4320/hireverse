<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CandidateController extends Controller
{
    public function index(): View
    {
        $candidates = Candidate::with('user')->withCount('applications')->latest()->paginate(15);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function destroy(Candidate $candidate): RedirectResponse
    {
        $candidate->user()->delete();

        return redirect()->route('admin.candidates.index')->with('status', 'Candidate account removed successfully.');
    }
}
