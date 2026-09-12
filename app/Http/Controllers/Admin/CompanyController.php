<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $companies = Company::with('user')
            ->withCount('jobPosts')
            ->when($request->search, function ($query, $search) {
                $query->where('company_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.companies.index', compact('companies'));
    }

    public function toggleVerification(Company $company): RedirectResponse
    {
        $company->update(['is_verified' => ! $company->is_verified]);

        $status = $company->is_verified ? 'verified' : 'unverified';

        return redirect()->route('admin.companies.index')->with('status', "Company marked as {$status}.");
    }

        public function show(Company $company): View
    {
        $company->load('jobPosts');

        return view('admin.companies.show', compact('company'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->user()->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company account removed successfully.');
    }
}
