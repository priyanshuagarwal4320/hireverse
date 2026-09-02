<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(): View
    {
        $company = auth()->user()->company;

        $fields = ['company_name', 'website', 'phone', 'industry', 'address', 'about'];
        $filled = collect($fields)->filter(fn($field) => !empty($company->$field))->count();
        $completeness = round(($filled / count($fields)) * 100);

        return view('company.profile', compact('company', 'completeness'));
    }

    public function update(Request $request): RedirectResponse
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'industry' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'max:2000'],
        ]);

        $company->update($validated);

        return redirect()->route('company.profile.edit')->with('status', 'Profile updated successfully.');
    }
}
