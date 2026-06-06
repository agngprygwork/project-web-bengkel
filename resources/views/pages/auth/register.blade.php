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

<body class="min-h-screen bg-[#f4f2ff] flex items-center justify-center p-4 lg:p-6">

    ```
    <div class="w-full max-w-7xl bg-white rounded-[32px] shadow-xl overflow-hidden">

        <div class="grid lg:grid-cols-2">

            <!-- LEFT SECTION -->
            <img src="{{ asset('images/background/1.jpeg') }}" alt="">


            <!-- RIGHT SECTION -->
            <div class="flex items-center justify-center p-8 lg:p-12">

                <div class="w-full max-w-lg">

                    <!-- HEADER -->
                    <div class="mb-8">

                        <div class="text-4xl text-indigo-600 font-bold mb-4">
                            *
                        </div>

                        <h1 class="text-4xl font-bold text-gray-900">
                            Create an account
                        </h1>

                        <p class="text-gray-500 mt-3">
                            Daftar untuk menggunakan Sistem Booking Servis Bengkel
                        </p>

                    </div>

                    <!-- ALERT -->
                    @if (session('error'))
                        <div class="mb-4">
                            <x-alert type="error" :message="session('error')" />
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4">
                            <x-alert type="error"
                                message="Terjadi kesalahan, silakan periksa kembali data yang Anda masukkan." />
                        </div>
                    @endif

                    <!-- FORM -->
                    <form method="POST" action="{{ route('register') }}">

                        @csrf

                        <!-- NAME -->
                        <div class="mb-4">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Nama Lengkap
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('name') border-red-500 @enderror">

                            @error('name')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="contoh@email.com"
                                class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('email') border-red-500 @enderror">

                            @error('email')
                                <p class="text-sm text-red-500 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- PHONE + ADDRESS -->
                        <div class="grid md:grid-cols-2 gap-4 mb-4">

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Nomor Telepon
                                </label>

                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    placeholder="081234567890"
                                    class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('phone') border-red-500 @enderror">

                                @error('phone')
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Alamat
                                </label>

                                <input type="text" name="address" value="{{ old('address') }}"
                                    placeholder="Alamat lengkap"
                                    class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('address') border-red-500 @enderror">

                                @error('address')
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        <!-- PASSWORD -->
                        <div class="grid md:grid-cols-2 gap-4 mb-4">

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Password
                                </label>

                                <div class="relative">

                                    <input type="password" id="password" name="password" required
                                        placeholder="Minimal 8 karakter"
                                        class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">

                                    <button type="button" onclick="togglePassword('password', 'eyeIconPassword')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2">

                                        <svg id="eyeIconPassword" class="w-5 h-5 text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                    </button>

                                </div>

                            </div>

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Konfirmasi Password
                                </label>

                                <div class="relative">

                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        required placeholder="Ulangi password"
                                        class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">

                                    <button type="button"
                                        onclick="togglePassword('password_confirmation', 'eyeIconConfirm')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2">

                                        <svg id="eyeIconConfirm" class="w-5 h-5 text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                    </button>

                                </div>

                            </div>

                        </div>

                        @error('password')
                            <p class="text-sm text-red-500 mb-3">
                                {{ $message }}
                            </p>
                        @enderror

                        <!-- PASSWORD STRENGTH -->
                        <div class="mb-5 hidden" id="passwordStrength">

                            <div class="flex items-center gap-2">

                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strengthBar" class="h-full transition-all duration-300">
                                    </div>
                                </div>

                                <span id="strengthText" class="text-xs font-medium"></span>

                            </div>

                        </div>

                        <!-- TERMS -->
                        <div class="mb-6">

                            <label class="flex items-start gap-3">

                                <input type="checkbox" required name="terms"
                                    class="mt-1 w-4 h-4 text-indigo-600 rounded">

                                <span class="text-sm text-gray-600">

                                    Saya menyetujui

                                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-800">
                                        Syarat & Ketentuan
                                    </a>

                                    dan

                                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-800">
                                        Kebijakan Privasi
                                    </a>

                                </span>

                            </label>

                        </div>

                        <!-- SUBMIT -->
                        <button type="submit"
                            class="w-full h-14 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-lg">

                            Create Account

                        </button>

                        <!-- LOGIN LINK -->
                        <div class="text-center mt-8">

                            <span class="text-gray-500">
                                Sudah punya akun?
                            </span>

                            <a href="{{ route('login') }}"
                                class="text-indigo-600 font-semibold hover:text-indigo-800">

                                Login

                            </a>

                        </div>

                    </form>

                </div>

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

        const passwordInput =
            document.getElementById('password');

        const strengthContainer =
            document.getElementById('passwordStrength');

        const strengthBar =
            document.getElementById('strengthBar');

        const strengthText =
            document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {

            const password = this.value;

            if (!password.length) {
                strengthContainer.classList.add('hidden');
                return;
            }

            strengthContainer.classList.remove('hidden');

            let score = 0;

            if (password.length >= 8) score += 25;
            if (password.length >= 12) score += 25;
            if (/[A-Z]/.test(password)) score += 15;
            if (/[a-z]/.test(password)) score += 15;
            if (/[0-9]/.test(password)) score += 10;
            if (/[^a-zA-Z0-9]/.test(password)) score += 10;

            let color = '';
            let text = '';

            if (score < 30) {
                color = 'bg-red-500';
                text = 'Lemah';
            } else if (score < 60) {
                color = 'bg-yellow-500';
                text = 'Sedang';
            } else if (score < 80) {
                color = 'bg-blue-500';
                text = 'Kuat';
            } else {
                color = 'bg-green-500';
                text = 'Sangat Kuat';
            }

            strengthBar.className =
                `h-full transition-all duration-300 ${color}`;

            strengthBar.style.width =
                `${Math.min(score, 100)}%`;

            strengthText.textContent = text;
        });
    </script>

</body>

</html>
