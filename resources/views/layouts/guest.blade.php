<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireVerse - @yield('page-title', 'Login')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">

    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-5" style="background:#f2f4f8;">
        <div class="w-full max-w-4xl flex rounded-3xl overflow-hidden shadow-sm" style="min-height: 560px;">

            {{-- Left panel --}}
            <div class="hidden lg:flex flex-1 flex-col items-center justify-center relative overflow-hidden p-10"
                style="background:#171a2e;">
                <div class="absolute rounded-full"
                    style="width:420px; height:420px; top:-230px; right:-160px; background:#242840;"></div>
                <div class="absolute rounded-full"
                    style="width:340px; height:340px; bottom:-200px; left:-110px; background:#2c2f4c;"></div>

                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center mb-12" style="gap:2px;">
                        <div class="flex flex-col items-center" style="width:76px;">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-2"
                                style="background:#262a44; color:#8b8fc9;">
                                <i class="fas fa-briefcase text-sm"></i>
                            </div>
                            <span class="text-xs font-bold uppercase"
                                style="color:#8184a0; letter-spacing:.08em;">Post</span>
                        </div>
                        <div style="width:28px; height:1px; background:#363a55;"></div>
                        <div class="flex flex-col items-center" style="width:76px;">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-2 text-white"
                                style="background:#6c5ce7;">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </div>
                            <span class="text-xs font-bold uppercase"
                                style="color:#8184a0; letter-spacing:.08em;">Apply</span>
                        </div>
                        <div style="width:28px; height:1px; background:#363a55;"></div>
                        <div class="flex flex-col items-center" style="width:76px;">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-2"
                                style="background:#262a44; color:#8b8fc9;">
                                <i class="fas fa-handshake text-sm"></i>
                            </div>
                            <span class="text-xs font-bold uppercase"
                                style="color:#8184a0; letter-spacing:.08em;">Hire</span>
                        </div>
                    </div>

                    <svg width="72" height="72" viewBox="0 0 100 100" class="mx-auto mb-5">
                        <rect width="100" height="100" rx="24" fill="#262a44" />
                        <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#a89af7" />
                        <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#a89af7" />
                        <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#ffffff" />
                    </svg>
                    <h2 class="text-white font-extrabold text-2xl mb-2">Hire<span style="color:#a89af7;">Verse</span>
                    </h2>
                    <p class="text-sm italic" style="color:#9599ac; max-width:270px;">"Where talent meets opportunity"
                    </p>
                </div>
            </div>

            {{-- Right panel --}}
            <div class="flex-1 bg-white flex flex-col justify-center p-10 lg:p-12">
                <div class="flex items-center gap-2 mb-1">
                    <svg width="28" height="28" viewBox="0 0 100 100">
                        <rect width="100" height="100" rx="24" fill="#171a2e" />
                        <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
                        <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
                        <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#ffffff" />
                    </svg>
                    <span class="font-extrabold text-lg">Hire<span style="color:#6c5ce7;">Verse</span></span>
                </div>
                <p class="text-xs font-semibold italic text-gray-400 mb-7">Where talent meets opportunity</p>

                {{ $slot }}
            </div>

        </div>
    </div>

</body>

</html>
