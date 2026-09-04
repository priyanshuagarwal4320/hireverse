<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function index(): View
    {
        $results = Result::with(['interview.application.candidate.user', 'interview.application.jobPost'])
            ->latest()
            ->paginate(15);

        return view('admin.results.index', compact('results'));
    }
}