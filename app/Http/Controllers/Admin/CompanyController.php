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

    public function destroy(Company $company): RedirectResponse
    {
        $company->user()->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company account removed successfully.');
    }
}
