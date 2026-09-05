<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::with('user')->withCount('jobPosts')->latest()->paginate(15);

        return view('admin.companies.index', compact('companies'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->user()->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company account removed successfully.');
    }
}
