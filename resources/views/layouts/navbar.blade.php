{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
    <div class="flex items-center">
        <button id="sidebarToggle" class="lg:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <h1 class="text-xl font-semibold text-gray-800 ml-4">@yield('page-title', 'Dashboard')</h1>
    </div>

    <div class="flex items-center space-x-4">
        <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-gray-700">{{ Auth::user()->name }}</span>

            </button>
        </div>
    </div>
</nav>
