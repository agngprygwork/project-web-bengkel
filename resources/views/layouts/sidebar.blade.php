@php
    $role = Auth::user()->role;
@endphp

<aside class="w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white flex flex-col">
    <div class="p-6">
        <h2 class="text-2xl font-bold">Booking Bengkel</h2>
        <p class="text-sm text-blue-200 mt-1">Sistem Servis Motor</p>
    </div>

    <nav class="flex-1 mt-6">
        @if ($role == 'admin')
            {{-- resources/views/layouts/sidebar.blade.php --}}
            @php
                $role = Auth::user()->role;
                $currentRoute = Route::currentRouteName();
            @endphp

            <aside class="w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white flex flex-col">
                <div class="p-6">
                    <h2 class="text-2xl font-bold">Booking Bengkel</h2>
                    <p class="text-sm text-blue-200 mt-1">Sistem Servis Motor</p>
                </div>

                <nav class="flex-1 mt-6 overflow-y-auto">
                    @if ($role == 'admin')
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-6 py-3 transition {{ $currentRoute == 'admin.dashboard' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Customer Management -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Customer</div>
                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ str_starts_with($currentRoute, 'admin.users.') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span>Data Customer</span>
                            </a>
                        </div>

                        <!-- Mekanik Management -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Mekanik</div>
                            <a href="{{ route('admin.mekaniks.index') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ str_starts_with($currentRoute, 'admin.mekaniks.') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <span>Data Mekanik</span>
                            </a>
                        </div>

                        <!-- Service Management -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Service</div>
                            <a href="{{ route('admin.jenis-services.index') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ str_starts_with($currentRoute, 'admin.jenis-services.') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <span>Jenis Service</span>
                            </a>
                        </div>

                        <!-- Booking Management -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Booking</div>
                            <a href="{{ route('admin.bookings.index') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ str_starts_with($currentRoute, 'admin.bookings.') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Semua Booking</span>
                            </a>
                        </div>

                        <!-- Sparepart Management -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Inventory</div>
                            <a href="{{ route('admin.spareparts.index') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ str_starts_with($currentRoute, 'admin.spareparts.') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Sparepart</span>
                            </a>
                        </div>

                        <!-- Reports -->
                        <div class="mt-2">
                            <div class="px-6 py-2 text-xs text-blue-300 uppercase tracking-wider">Laporan</div>
                            <a href="{{ route('admin.reports.bookings') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ $currentRoute == 'admin.reports.bookings' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Laporan Booking</span>
                            </a>
                            <a href="{{ route('admin.reports.payments') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ $currentRoute == 'admin.reports.payments' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span>Laporan Pembayaran</span>
                            </a>
                            <a href="{{ route('admin.reports.services') }}"
                                class="flex items-center px-6 py-3 pl-11 transition {{ $currentRoute == 'admin.reports.services' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                                <span>Laporan Service</span>
                            </a>
                        </div>
                    @elseif($role == 'mekanik')
                        <a href="{{ route('mekanik.dashboard') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ $currentRoute == 'mekanik.dashboard' ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('mekanik.tasks.index') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>My Tasks</span>
                        </a>
                        <a href="{{ route('mekanik.schedule') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Jadwal</span>
                        </a>
                    @else
                        {{-- Customer Sidebar --}}
                        <a href="{{ route('customer.dashboard') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ $currentRoute == 'customer.dashboard' ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('customer.bookings.index') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ str_starts_with($currentRoute, 'customer.bookings.') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            <span>Booking Saya</span>
                        </a>
                        <a href="{{ route('customer.bookings.create') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Booking Baru</span>
                        </a>
                        <a href="{{ route('customer.payments.index') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ str_starts_with($currentRoute, 'customer.payments.') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span>Pembayaran</span>
                        </a>
                        <a href="{{ route('customer.history.index') }}"
                            class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ str_starts_with($currentRoute, 'customer.history.') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Riwayat Service</span>
                        </a>
                    @endif
                </nav>


            </aside>
        @elseif($role == 'mekanik')
            {{-- Mekanik Sidebar --}}
            <a href="{{ route('mekanik.dashboard') }}"
                class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span>My Tasks</span>
            </a>
        @else
            {{-- Customer Sidebar --}}
            <a href="{{ route('customer.dashboard') }}"
                class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span>New Booking</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span>My Bookings</span>
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-2 text-sm hover:bg-blue-700 rounded transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
