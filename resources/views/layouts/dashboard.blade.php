<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireVerse - @yield('page-title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col">
            @include('partials.topbar')

            <main class="flex-1 p-7">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>

</body>
</html>