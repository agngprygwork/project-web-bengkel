{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Sistem Booking Servis Bengkel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-500 to-blue-700 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Daftar Akun Baru</h1>
                <p class="text-blue-100">Bergabunglah untuk memesan service motor</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-8 pt-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Registrasi</h2>
                    <p class="text-gray-500 text-center mt-2">Isi form di bawah untuk mendaftar</p>
                </div>

                <!-- Alert Messages -->
                @if (session('error'))
                    <div class="mx-8 mb-4">
                        <x-alert type="error" :message="session('error')" />
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-8 mb-4">
                        <x-alert type="error" message="Terjadi kesalahan, silakan periksa form Anda" />
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="px-8 pb-8">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                autofocus
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Email <span class="text-red-500">*</span>
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
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                placeholder="contoh@email.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                placeholder="081234567890">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <textarea name="address" id="address" rows="2"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('address') border-red-500 @enderror"
                                placeholder="Jl. Contoh No. 123, RT 01 RW 02, Kelurahan, Kecamatan, Kota">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
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
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon1" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer"
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

                    <!-- Confirm Password Field -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Masukkan password lagi">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon2" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" required
                                class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">
                                Saya menyetujui
                                <a href="#" class="text-green-600 hover:text-green-800">Syarat & Ketentuan</a>
                                dan
                                <a href="#" class="text-green-600 hover:text-green-800">Kebijakan Privasi</a>
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mb-4" id="passwordStrength" style="display: none;">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full transition-all duration-300" style="width: 0%">
                                </div>
                            </div>
                            <span id="strengthText" class="text-xs font-medium"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Daftar Sekarang
                    </button>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-green-600 hover:text-green-800 font-semibold transition">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>
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
        function togglePassword(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);

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

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthDiv = document.getElementById('passwordStrength');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }

            strengthDiv.style.display = 'block';

            let strength = 0;
            let color = '';
            let text = '';

            // Length check
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;

            // Complexity checks
            if (/[a-z]/.test(password)) strength += 15;
            if (/[A-Z]/.test(password)) strength += 15;
            if (/[0-9]/.test(password)) strength += 10;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 10;

            // Determine strength level
            if (strength < 30) {
                color = 'bg-red-500';
                text = 'Lemah';
            } else if (strength < 60) {
                color = 'bg-yellow-500';
                text = 'Sedang';
            } else if (strength < 80) {
                color = 'bg-blue-500';
                text = 'Kuat';
            } else {
                color = 'bg-green-500';
                text = 'Sangat Kuat';
            }

            strengthBar.className = `h-full transition-all duration-300 ${color}`;
            strengthBar.style.width = `${Math.min(strength, 100)}%`;
            strengthText.textContent = text;
            strengthText.className = `text-xs font-medium ${color.replace('bg-', 'text-')}`;
        });
    </script>
</body>

</html>
