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

<body class="min-h-screen bg-[#f4f2ff] flex items-center justify-center p-6">

    <div class="w-full max-w-7xl bg-white rounded-[32px] shadow-xl overflow-hidden">

        <div class="grid lg:grid-cols-2">

            <!-- LEFT SIDE -->

            <img src="{{ asset('images/background/1.jpeg') }}" alt="">

            <!-- RIGHT SIDE -->
            <div class="flex items-center justify-center p-12">

                <div class="w-full max-w-md">

                    <div class="mb-10">

                        <div class="w-full flex justify-center">
                            <img src="{{ asset('images/logo/1.png') }}" alt="" class="w-[100px]">
                        </div>

                        <p class="text-gray-500 mt-4">
                            Sistem Booking Servis Bengkel
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- EMAIL -->
                        <div class="mb-5">
                            <label class="block mb-2 font-semibold text-gray-700">
                                Your email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                placeholder="Masukkan email">
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-8">
                            <label class="block mb-2 font-semibold text-gray-700">
                                Password
                            </label>

                            <div class="relative">
                                <input id="password" type="password" name="password"
                                    class="w-full h-14 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                    placeholder="Masukkan password">

                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2">

                                    <svg id="eyeIcon" class="w-5 h-5 text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                </button>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                            class="w-full h-14 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-lg">
                            Login
                        </button>

                        <!-- Register -->
                        <div class="text-center mt-8">
                            <span class="text-gray-500">
                                Belum punya akun?
                            </span>

                            <a href="{{ route('register') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-800">
                                Daftar
                            </a>
                        </div>

                    </form>

                </div>

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
