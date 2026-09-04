<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::with('user')->withCount('jobPosts')->latest()->paginate(15);

        return view('admin.companies.index', compact('companies'));
    }
}