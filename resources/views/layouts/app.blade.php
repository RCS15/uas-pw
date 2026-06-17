<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Aplikasi Keuangan UMKM</title>
    
    <!-- Google Fonts / Bunny Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS and Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS or Custom JS can be added here. We'll use clean inline script for instant responsive interaction -->
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50/50 text-gray-700 antialiased min-h-screen flex flex-col">

    <!-- Wrapper -->
    <div class="flex flex-1 relative overflow-hidden">
        
        <!-- Mobile Sidebar Backdrop -->
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-gray-900/40 z-40 transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"></div>

        <!-- Sidebar Section (Desktop Sidebar) -->
        <aside id="sidebar-container" class="hidden lg:flex flex-shrink-0 z-50">
            @if(request()->is('admin*'))
                @include('shared.sidebar-admin')
            @else
                @include('shared.sidebar-nonadmin')
            @endif
        </aside>

        <!-- Mobile Sidebar Container (Sliding Drawer) -->
        <div id="mobile-sidebar" class="fixed top-0 bottom-0 left-0 w-64 bg-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col shadow-2xl">
            @if(request()->is('admin*'))
                @include('shared.sidebar-admin')
            @else
                @include('shared.sidebar-nonadmin')
            @endif
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-y-auto">
            
            <!-- Navbar Header -->
            <header class="bg-white border-b border-gray-100 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 py-4 h-16 shadow-sm shadow-gray-500/5">
                
                <!-- Toggle Button Mobile & Branding -->
                <div class="flex items-center gap-3">
                    <button id="btn-sidebar-toggle" class="p-2 -ml-2 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-800 lg:hidden focus:outline-none focus:ring-2 focus:ring-emerald-500/20" aria-label="Toggle Sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="lg:hidden flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            F
                        </div>
                        <span class="text-sm font-bold text-gray-800">FinBiz UMKM</span>
                    </div>
                    
                    <!-- Page Header Title for Desktop -->
                    <h2 class="hidden lg:block text-gray-800 font-bold text-lg">
                        @yield('header_title', 'Ringkasan')
                    </h2>
                </div>

                <!-- Right Side: Session Info & Profile Dropdown -->
                <div class="flex items-center gap-4">
                    
                    <!-- Role Quick Switch Demo Badge -->
                    <div class="flex items-center gap-1.5">
                        <a href="{{ request()->is('admin*') ? route('nonadmin.dashboard') : route('admin.dashboard') }}" 
                           class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full border bg-white shadow-sm transition-all duration-150 {{ request()->is('admin*') ? 'text-teal-700 border-teal-200 hover:bg-teal-50' : 'text-emerald-700 border-emerald-200 hover:bg-emerald-50' }}"
                           title="Klik untuk berpindah role (Demo)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Pindah Role: {{ request()->is('admin*') ? 'Kasir' : 'Admin' }}
                        </a>
                    </div>

                    <!-- Profile Dropdown Component -->
                    <div class="relative">
                        <button id="btn-profile-dropdown" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-gray-50 focus:outline-none transition-colors duration-150">
                            <div class="w-8 h-8 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shadow-inner">
                                {{ request()->is('admin*') ? 'AD' : 'SK' }}
                            </div>
                            <span class="hidden md:inline text-sm font-semibold text-gray-700">
                                {{ request()->is('admin*') ? 'Admin Keuangan' : 'Staf Kasir 1' }}
                            </span>
                            <svg class="hidden md:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div id="profile-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-gray-200/50 py-1.5 z-40 transform scale-95 opacity-0 pointer-events-none transition-all duration-150 origin-top-right">
                            <div class="px-4 py-2 border-b border-gray-50 lg:hidden">
                                <p class="text-xs font-semibold text-emerald-600 uppercase">{{ request()->is('admin*') ? 'Admin Role' : 'Staff Role' }}</p>
                                <p class="text-sm font-bold text-gray-800 truncate">{{ request()->is('admin*') ? 'Admin Keuangan' : 'Staf Kasir 1' }}</p>
                            </div>
                            
                            <a href="{{ request()->is('admin*') ? route('admin.dashboard') : route('nonadmin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil Saya
                            </a>
                            
                            <a href="{{ request()->is('admin*') ? route('nonadmin.dashboard') : route('admin.dashboard') }}" class="sm:hidden flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Berpindah Role
                            </a>

                            <div class="border-t border-gray-50 my-1"></div>
                            
                            <a href="{{ route('auth.login') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar Aplikasi
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Main Content Section -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Alert/Flash Message Reusable Component -->
                @include('shared.alert')

                <!-- Actual Yield Content -->
                @yield('content')
            </main>

            <!-- Footer Section -->
            <footer class="bg-white border-t border-gray-100 py-4 px-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-2 mt-auto">
                <p>&copy; {{ date('Y') }} FinBiz UMKM. Semua Hak Dilindungi.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-emerald-600 transition-colors">Kebijakan Privasi</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-emerald-600 transition-colors">Ketentuan Layanan</a>
                </div>
            </footer>

        </div>
    </div>

    <!-- Script for Sidebar Mobile Toggle and Profile Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Mobile Variables
            const btnSidebarToggle = document.getElementById('btn-sidebar-toggle');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');
            
            // Profile Dropdown Variables
            const btnProfileDropdown = document.getElementById('btn-profile-dropdown');
            const profileDropdownMenu = document.getElementById('profile-dropdown-menu');

            // Open/Close Mobile Sidebar
            function toggleMobileSidebar() {
                const isOpen = !mobileSidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
                    mobileSidebarBackdrop.classList.remove('opacity-100');
                } else {
                    mobileSidebar.classList.remove('-translate-x-full');
                    mobileSidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                    mobileSidebarBackdrop.classList.add('opacity-100');
                }
            }

            if(btnSidebarToggle) {
                btnSidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleMobileSidebar();
                });
            }

            if(mobileSidebarBackdrop) {
                mobileSidebarBackdrop.addEventListener('click', function() {
                    toggleMobileSidebar();
                });
            }

            // Profile Dropdown Open/Close
            if(btnProfileDropdown) {
                btnProfileDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = !profileDropdownMenu.classList.contains('opacity-0');
                    if (isOpen) {
                        closeProfileDropdown();
                    } else {
                        openProfileDropdown();
                    }
                });
            }

            function openProfileDropdown() {
                profileDropdownMenu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                profileDropdownMenu.classList.add('opacity-100', 'scale-100');
            }

            function closeProfileDropdown() {
                profileDropdownMenu.classList.remove('opacity-100', 'scale-100');
                profileDropdownMenu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            }

            // Close dropdowns and mobile menus when clicking outside
            document.addEventListener('click', function(event) {
                // Check if click was outside profile dropdown
                if (btnProfileDropdown && !btnProfileDropdown.contains(event.target) && !profileDropdownMenu.contains(event.target)) {
                    closeProfileDropdown();
                }
                
                // Check if click was outside mobile sidebar and not on toggle button
                if (mobileSidebar && !mobileSidebar.contains(event.target) && btnSidebarToggle && !btnSidebarToggle.contains(event.target)) {
                    if (!mobileSidebar.classList.contains('-translate-x-full')) {
                        toggleMobileSidebar();
                    }
                }
            });
        });
    </script>
</body>
</html>
