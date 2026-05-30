{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Booking Servis Bengkel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Booking Bengkel</h1>
                <p class="text-blue-100">Sistem Informasi Booking Servis Motor</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-8 pt-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Login</h2>
                    <p class="text-gray-500 text-center mt-2">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="mx-8 mb-4">
                        <x-alert type="success" :message="session('success')" />
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-8 mb-4">
                        <x-alert type="error" :message="session('error')" />
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-8 mb-4">
                        <x-alert type="error" message="Terjadi kesalahan pada form login" />
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="px-8 pb-8">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                autofocus
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                placeholder="contoh@email.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Login
                    </button>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-blue-600 hover:text-blue-800 font-semibold transition">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <p class="text-white text-sm text-center mb-2">Akun Demo:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs text-white">
                    <div class="bg-white/20 rounded p-2">
                        <strong>Admin:</strong><br>
                        admin@bengkel.com<br>
                        password
                    </div>
                    <div class="bg-white/20 rounded p-2">
                        <strong>Mekanik:</strong><br>
                        mekanik@bengkel.com<br>
                        password
                    </div>
                    <div class="bg-white/20 rounded p-2">
                        <strong>Customer:</strong><br>
                        customer@bengkel.com<br>
                        password
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-blue-100 text-sm">
                    &copy; {{ date('Y') }} Sistem Booking Servis Bengkel. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>

</html>
