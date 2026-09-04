<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(): View
    {
        $candidates = Candidate::with('user')->withCount('applications')->latest()->paginate(15);

        return view('admin.candidates.index', compact('candidates'));
    }
}