<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use Illuminate\View\View;

class InterviewController extends Controller
{
    public function index(): View
    {
        $interviews = Interview::with(['application.candidate.user', 'application.jobPost.company'])
            ->orderBy('interview_date')
            ->paginate(15);

        return view('admin.interviews.index', compact('interviews'));
    }
}