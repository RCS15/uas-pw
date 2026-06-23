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

        <!-- Alert messages inside auth cards -->
        @include('shared.alert')

        <!-- Yield Card Content -->
        <div class="bg-white rounded-3xl border border-gray-100/80 shadow-xl shadow-gray-200/40 p-6 sm:p-8">
            @yield('content')
        </div>
        

    </div>
</body>
</html>
