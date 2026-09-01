@extends('layouts.dashboard')

@section('page-title', 'Company Dashboard')

@section('content')
    <h1 class="text-xl font-extrabold mb-2">Company overview</h1>
    <p class="text-gray-500 text-sm">Welcome, Company! Only users with role = company can see this page.</p>
@endsection