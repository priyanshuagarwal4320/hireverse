<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $applications = Application::with(['candidate.user', 'jobPost.company'])->latest()->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.applications.index')->with('status', 'Application removed successfully.');
    }
}
