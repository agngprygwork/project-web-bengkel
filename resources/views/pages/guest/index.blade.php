{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Bengkel - Sistem Servis Motor Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        }

        .service-card:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .stat-counter {
            font-size: 2.5rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-blue-600">Booking Bengkel</span>
            </div>

            <div class="hidden md:flex items-center gap-6">
                <a href="#services" class="text-gray-600 hover:text-blue-600 transition">Layanan</a>
                <a href="#about" class="text-gray-600 hover:text-blue-600 transition">Tentang</a>
                <a href="#mekaniks" class="text-gray-600 hover:text-blue-600 transition">Mekanik</a>
                <a href="#testimonials" class="text-gray-600 hover:text-blue-600 transition">Testimoni</a>
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Daftar
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t px-4 py-4 space-y-3">
            <a href="#services" class="block text-gray-600 hover:text-blue-600 transition">Layanan</a>
            <a href="#about" class="block text-gray-600 hover:text-blue-600 transition">Tentang</a>
            <a href="#mekaniks" class="block text-gray-600 hover:text-blue-600 transition">Mekanik</a>
            <a href="#testimonials" class="block text-gray-600 hover:text-blue-600 transition">Testimoni</a>
            <div class="pt-3 border-t flex gap-3">
                <a href="{{ route('login') }}"
                    class="flex-1 text-center text-blue-600 font-semibold py-2 border border-blue-600 rounded-lg">Login</a>
                <a href="{{ route('register') }}"
                    class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center pt-16">
        <div class="container mx-auto px-4 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                        Servis Motor <br>
                        <span class="text-yellow-300">Cepat & Terpercaya</span>
                    </h1>
                    <p class="text-lg md:text-xl text-blue-100 mb-8">
                        Booking service motor online dengan mudah. Dapatkan mekanik profesional
                        dan harga transparan hanya di Booking Bengkel.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}"
                            class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg font-semibold hover:bg-yellow-300 transition transform hover:scale-105">
                            Booking Sekarang
                        </a>
                        <a href="#services"
                            class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition border border-white/30">
                            Lihat Layanan
                        </a>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">{{ number_format($stats['customers']) }}</p>
                            <p class="text-sm text-blue-200">Customer Puas</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">{{ number_format($stats['services_completed']) }}
                            </p>
                            <p class="text-sm text-blue-200">Service Selesai</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">{{ number_format($stats['mekaniks']) }}</p>
                            <p class="text-sm text-blue-200">Mekanik Profesional</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">{{ $stats['years_experience'] }}+</p>
                            <p class="text-sm text-blue-200">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Layanan Kami</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Kami menyediakan berbagai layanan service motor berkualitas dengan harga terjangkau
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                    <div class="service-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="p-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->nama_service }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($service->deskripsi ?? 'Layanan service motor profesional', 80) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">Rp
                                    {{ number_format($service->harga, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">{{ $service->estimasi_waktu }} menit</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">Belum ada layanan tersedia</div>
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('register') }}"
                    class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Layanan
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                        Kenapa Memilih <span class="text-blue-600">Booking Bengkel</span>
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Mekanik Profesional</h4>
                                <p class="text-gray-600 text-sm">Tim mekanik berpengalaman dan tersertifikasi</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Booking Mudah</h4>
                                <p class="text-gray-600 text-sm">Pesan service online kapan saja, di mana saja</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Harga Transparan</h4>
                                <p class="text-gray-600 text-sm">Harga jelas tanpa biaya tersembunyi</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Garansi Kepuasan</h4>
                                <p class="text-gray-600 text-sm">Kepuasan customer adalah prioritas kami</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                <p class="text-3xl font-bold text-blue-600">100%</p>
                                <p class="text-sm text-gray-600">Kepuasan Customer</p>
                            </div>
                            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                <p class="text-3xl font-bold text-green-600">24/7</p>
                                <p class="text-sm text-gray-600">Layanan Online</p>
                            </div>
                            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                <p class="text-3xl font-bold text-purple-600">5+</p>
                                <p class="text-sm text-gray-600">Tahun Pengalaman</p>
                            </div>
                            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                <p class="text-3xl font-bold text-orange-600">50+</p>
                                <p class="text-sm text-gray-600">Mekanik Terlatih</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mekaniks Section -->
    <section id="mekaniks" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Tim Mekanik Profesional</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Ditangani oleh mekanik berpengalaman dan bersertifikat di bidangnya
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($mekaniks as $mekanik)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="p-6 text-center">
                            <div
                                class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl font-bold text-blue-600">
                                    {{ substr($mekanik->user->name ?? 'M', 0, 1) }}
                                </span>
                            </div>
                            <h4 class="font-semibold text-gray-800">{{ $mekanik->user->name ?? 'Mekanik' }}</h4>
                            <p class="text-sm text-blue-600">{{ $mekanik->spesialis ?? 'General' }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $mekanik->pengalaman_tahun ?? 0 }} tahun
                                pengalaman</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">Belum ada data mekanik</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Testimoni Customer</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Apa kata mereka yang sudah menggunakan layanan kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-card bg-gray-50 rounded-xl p-6 shadow-md">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-lg font-bold text-blue-600">
                                    {{ substr($testimonial->customer->user->name ?? 'C', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    {{ $testimonial->customer->user->name ?? 'Customer' }}</h4>
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= ($testimonial->rating ?? 5))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm italic">"{{ $testimonial->content }}"</p>
                        <p class="text-xs text-gray-400 mt-3">
                            {{ \Carbon\Carbon::parse($testimonial->created_at)->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Siap untuk Service Motor Anda?
            </h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                Booking sekarang dan dapatkan pelayanan terbaik dari mekanik profesional kami
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg font-semibold hover:bg-yellow-300 transition transform hover:scale-105">
                    Booking Sekarang
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition border border-white/30">
                    Login
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold">Booking Bengkel</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Sistem booking service motor online terpercaya di Indonesia.
                    </p>
                </div>

                <div>
                    <h5 class="font-semibold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Service Ringan</a></li>
                        <li><a href="#" class="hover:text-white transition">Service Besar</a></li>
                        <li><a href="#" class="hover:text-white transition">Tune Up</a></li>
                        <li><a href="#" class="hover:text-white transition">Ganti Oli</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-semibold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-semibold mb-4">Hubungi Kami</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            +62 812 3456 7890
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            info@bookingbengkel.com
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} | Universitas Harkat Negri - D III Teknik Komputer
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu
                    document.getElementById('mobileMenu').classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>
