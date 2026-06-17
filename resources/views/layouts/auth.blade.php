<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - FinBiz UMKM</title>
    
    <!-- Google Fonts / Bunny Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS and Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-700 antialiased min-h-screen flex flex-col justify-center items-center relative overflow-hidden">
    <!-- Geometric decorative elements for premium feel -->
    <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-emerald-500/5 blur-3xl"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] rounded-full bg-teal-500/5 blur-3xl"></div>

    <div class="w-full max-w-md px-4 py-8 z-10">
        <!-- Logo and Brand -->
        <div class="flex flex-col items-center mb-8">
            <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xl shadow-emerald-500/20 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-gray-900 font-extrabold text-2xl tracking-tight">FinBiz UMKM</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Pengelolaan Keuangan Pintar & Cepat</p>
        </div>

        <!-- Alert messages inside auth cards -->
        @include('shared.alert')

        <!-- Yield Card Content -->
        <div class="bg-white rounded-3xl border border-gray-100/80 shadow-xl shadow-gray-200/40 p-6 sm:p-8">
            @yield('content')
        </div>
        
        <!-- Footer info -->
        <div class="text-center mt-8 text-xs text-gray-400">
            <p>&copy; {{ date('Y') }} FinBiz UMKM. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
