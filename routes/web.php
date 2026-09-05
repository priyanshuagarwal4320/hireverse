<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\CandidateController as AdminCandidateController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\InterviewController as AdminInterviewController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'company' => redirect()->route('company.dashboard'),
            'candidate' => redirect()->route('candidate.dashboard'),
        };
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/company/dashboard', [DashboardController::class, 'company'])
        ->middleware('role:company')
        ->name('company.dashboard');

    Route::get('/candidate/dashboard', [DashboardController::class, 'candidate'])
        ->middleware('role:candidate')
        ->name('candidate.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/companies', [AdminCompanyController::class, 'index'])
        ->name('admin.companies.index');

    Route::get('/admin/candidates', [AdminCandidateController::class, 'index'])
        ->name('admin.candidates.index');

    Route::get('/admin/jobs', [AdminJobController::class, 'index'])
        ->name('admin.jobs.index');

    Route::get('/admin/applications', [AdminApplicationController::class, 'index'])
        ->name('admin.applications.index');

    Route::get('/admin/interviews', [AdminInterviewController::class, 'index'])
        ->name('admin.interviews.index');

    Route::get('/admin/results', [AdminResultController::class, 'index'])
        ->name('admin.results.index');
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/profile', [CompanyProfileController::class, 'edit'])
        ->name('company.profile.edit');

    Route::put('/company/profile', [CompanyProfileController::class, 'update'])
        ->name('company.profile.update');

    Route::get('/company/jobs', [JobPostController::class, 'index'])
        ->name('company.jobs.index');

    Route::get('/company/jobs/create', [JobPostController::class, 'create'])
        ->name('company.jobs.create');

    Route::post('/company/jobs', [JobPostController::class, 'store'])
        ->name('company.jobs.store');

    Route::get('/company/jobs/{job}/edit', [JobPostController::class, 'edit'])
        ->name('company.jobs.edit');

    Route::put('/company/jobs/{job}', [JobPostController::class, 'update'])
        ->name('company.jobs.update');

    Route::patch('/company/jobs/{job}/toggle-status', [JobPostController::class, 'toggleStatus'])
        ->name('company.jobs.toggle-status');

    Route::get('/company/jobs/{job}/applicants', [JobPostController::class, 'applicants'])
        ->name('company.jobs.applicants');

    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.update-status');

    Route::get('/applications/{application}/interview/create', [InterviewController::class, 'create'])
        ->name('interviews.create');

    Route::post('/applications/{application}/interview', [InterviewController::class, 'store'])
        ->name('interviews.store');

    Route::get('/interviews/{interview}/result/create', [ResultController::class, 'create'])
        ->name('results.create');

    Route::post('/interviews/{interview}/result', [ResultController::class, 'store'])
        ->name('results.store');

    Route::get('/interviews/{interview}/result/edit', [ResultController::class, 'edit'])
        ->name('results.edit');

    Route::put('/interviews/{interview}/result', [ResultController::class, 'update'])
        ->name('results.update');

    Route::get('/company/applications', [ApplicationController::class, 'companyIndex'])
        ->name('company.applications');

    Route::get('/company/interviews', [InterviewController::class, 'companyIndex'])
        ->name('company.interviews');
});

Route::middleware(['auth', 'role:candidate'])->group(function () {
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
        ->name('applications.store');

    Route::get('/candidate/interviews', [InterviewController::class, 'index'])
        ->name('candidate.interviews');

    Route::get('/candidate/results', [ResultController::class, 'index'])
        ->name('candidate.results');

    Route::get('/candidate/profile', [CandidateProfileController::class, 'edit'])
        ->name('candidate.profile.edit');

    Route::put('/candidate/profile', [CandidateProfileController::class, 'update'])
        ->name('candidate.profile.update');

    Route::get('/candidate/applications', [ApplicationController::class, 'index'])
        ->name('candidate.applications');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
