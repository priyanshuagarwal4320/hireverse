<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;

Route::get('/', function () {
    return view('welcome');
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
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
