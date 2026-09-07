<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request): View
{
    $candidates = Candidate::with('user')
        ->withCount('applications')
        ->when($request->search, function ($query, $search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('admin.candidates.index', compact('candidates'));
}

    public function destroy(Candidate $candidate): RedirectResponse
    {
        $candidate->user()->delete();

        return redirect()->route('admin.candidates.index')->with('status', 'Candidate account removed successfully.');
    }
}
