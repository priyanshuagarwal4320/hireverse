<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->user()->company;

        if ($company && ! $company->is_verified && ! $request->routeIs('company.pending')) {
            return redirect()->route('company.pending');
        }

        return $next($request);
    }
}