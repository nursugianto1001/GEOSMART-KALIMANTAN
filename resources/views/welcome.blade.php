{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Geographic Survey Management and Reporting Tool</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(22, 163, 74, 0.3);
            }

            50% {
                box-shadow: 0 0 30px rgba(22, 163, 74, 0.5);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(22, 163, 74, 0.1) 0%, transparent 50%);
        }

        .hero-gradient {
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 50%, #ffffff 100%);
        }
    </style>
</head>

<body class="bg-pattern min-h-screen antialiased font-['figtree']">
    <!-- Hero Section -->
    <div class="hero-gradient min-h-screen relative overflow-hidden">
        <!-- Navigation -->
        <nav class="container mx-auto px-6 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3 animate-fadeInUp">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-600 to-green-700 rounded-lg flex items-center justify-center animate-pulse-glow shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-6 h-6 stroke-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-green-900">GEOSMART</span>
                </div>

                @if (Route::has('login'))
                <div class="animate-fadeInUp" style="animation-delay: 0.2s;">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-lg transform hover:scale-105 shadow-md">
                        <span class="mr-2">Dashboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-lg transform hover:scale-105 shadow-md">
                        <span class="mr-2">Masuk</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @endauth
                </div>
                @endif
            </div>
        </nav>

        <!-- Main Hero Content -->
        <div class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="animate-fadeInUp">
                        <div class="inline-flex items-center px-4 py-2 bg-green-100 rounded-full text-green-700 text-sm font-medium mb-6 border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Geographic Survey Management and Reporting Tool
                        </div>

                        <h1 class="text-5xl lg:text-6xl font-bold text-green-900 leading-tight">
                            Pemetaan
                            <span class="bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                                Kemiskinan
                            </span>
                            Kalimantan
                        </h1>

                        <p class="text-xl text-green-700 leading-relaxed mt-6">
                            Platform digital terintegrasi untuk pendataan, verifikasi, dan analisis data kemiskinan berbasis geospasial di seluruh wilayah Kalimantan, Indonesia. Mendukung pengambilan keputusan yang tepat sasaran.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 animate-fadeInUp" style="animation-delay: 0.4s;">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-xl transform hover:scale-105 font-semibold shadow-md">
                            <span class="mr-2">Akses Sistem</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-xl transform hover:scale-105 font-semibold shadow-md">
                            <span class="mr-2">Mulai Survei</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </a>
                        @endauth

                        <button class="inline-flex items-center justify-center px-8 py-4 border-2 border-green-600 text-green-700 rounded-full hover:bg-green-50 transition-all duration-300 font-semibold shadow-sm hover:shadow-md">
                            <span class="mr-2">Demo Interaktif</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Stats Kalimantan -->
                    <div class="grid grid-cols-3 gap-6 pt-8 animate-fadeInUp" style="animation-delay: 0.6s;">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-800">5</div>
                            <div class="text-sm text-green-600 mt-1">Provinsi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-800">55+</div>
                            <div class="text-sm text-green-600 mt-1">Kabupaten/Kota</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-800">99.9%</div>
                            <div class="text-sm text-green-600 mt-1">Akurasi GPS</div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual - Dashboard Preview -->
                <div class="relative animate-fadeInUp" style="animation-delay: 0.8s;">
                    <div class="relative z-10 animate-float">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border border-green-100">
                            <div class="space-y-6">
                                <!-- Dashboard Header -->
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-green-900">Dashboard Survei Real-time</h3>
                                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                </div>

                                <!-- Map Preview -->
                                <div class="h-40 bg-gradient-to-br from-green-50 to-green-100 rounded-lg relative overflow-hidden border border-green-200">
                                    <!-- Gambar placeholder dengan pattern geografis -->
                                    <div class="w-full h-full bg-gradient-to-br from-green-100 via-green-200 to-green-300 relative">
                                        <!-- Pattern geografis -->
                                        <div class="absolute inset-0 opacity-30" style="background-image: 
            radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.4) 2px, transparent 2px),
            radial-gradient(circle at 75% 75%, rgba(22, 163, 74, 0.4) 1px, transparent 1px),
            linear-gradient(45deg, transparent 40%, rgba(34, 197, 94, 0.1) 50%, transparent 60%);
            background-size: 30px 30px, 20px 20px, 40px 40px;">
                                        </div>

                                        <!-- Bentuk pulau Kalimantan sederhana dengan CSS -->
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-16 bg-green-300 rounded-lg opacity-60 shadow-inner" style="border-radius: 60% 40% 40% 60% / 50% 50% 50% 50%;"></div>
                                    </div>

                                    <!-- Kalimantan Points -->
                                    <div class="absolute top-6 left-8 w-3 h-3 bg-red-500 rounded-full animate-pulse shadow-lg" title="Sangat Miskin - Kalbar">
                                        <div class="absolute inset-0 bg-red-500 rounded-full animate-ping opacity-75"></div>
                                    </div>

                                    <div class="absolute top-12 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-orange-500 rounded-full animate-pulse shadow-lg" style="animation-delay: 0.5s;" title="Miskin - Kalteng">
                                        <div class="absolute inset-0 bg-orange-500 rounded-full animate-ping opacity-75" style="animation-delay: 0.5s;"></div>
                                    </div>

                                    <div class="absolute top-8 right-8 w-4 h-4 bg-yellow-500 rounded-full animate-pulse shadow-lg" style="animation-delay: 1s;" title="Rentan Miskin - Kaltim">
                                        <div class="absolute inset-0 bg-yellow-500 rounded-full animate-ping opacity-75" style="animation-delay: 1s;"></div>
                                    </div>

                                    <div class="absolute bottom-8 left-1/3 w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg" style="animation-delay: 1.5s;" title="Tidak Miskin - Kalsel">
                                        <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75" style="animation-delay: 1.5s;"></div>
                                    </div>

                                    <div class="absolute top-4 right-1/3 w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-lg" style="animation-delay: 2s;" title="Data Terbatas - Kalut">
                                        <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-75" style="animation-delay: 2s;"></div>
                                    </div>

                                    <!-- Kalimantan Label -->
                                    <div class="absolute bottom-2 left-2 text-xs text-green-800 font-semibold bg-white bg-opacity-95 px-3 py-1 rounded-full shadow-lg border border-green-200">
                                        🗺️ Pulau Kalimantan
                                    </div>

                                    <!-- Legend mini -->
                                    <div class="absolute top-2 right-2 bg-white bg-opacity-95 p-2 rounded-lg shadow-lg text-xs">
                                        <div class="flex items-center space-x-1 mb-1">
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            <span class="text-green-800 font-medium">Sangat Miskin</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span class="text-green-800 font-medium">Tidak Miskin</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistics -->
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-green-700">Kalimantan Barat</span>
                                        <span class="text-sm font-semibold text-green-800">2,845 KK</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-green-700">Kalimantan Tengah</span>
                                        <span class="text-sm font-semibold text-green-800">1,967 KK</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-green-700">Kalimantan Timur</span>
                                        <span class="text-sm font-semibold text-green-800">3,122 KK</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-green-700">Kalimantan Selatan</span>
                                        <span class="text-sm font-semibold text-green-800">2,456 KK</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-green-700">Kalimantan Utara</span>
                                        <span class="text-sm font-semibold text-green-800">1,234 KK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-green-100 rounded-full opacity-60 animate-float" style="animation-delay: 1s;"></div>
                    <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-green-200 rounded-full opacity-40 animate-float" style="animation-delay: 2s;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 animate-fadeInUp">
                <h2 class="text-4xl font-bold text-green-900 mb-4">Fitur Sistem Terintegrasi</h2>
                <p class="text-xl text-green-700 max-w-3xl mx-auto">
                    Platform lengkap untuk pendataan, verifikasi, dan analisis kemiskinan dengan teknologi geospasial terdepan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: Survei Digital -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-green-100 card-hover animate-fadeInUp">
                    <div class="relative">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl mb-6 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-900 mb-4">Survei Digital Komprehensif</h3>
                        <p class="text-green-700 leading-relaxed">
                            Form survei digital lengkap dengan 25 indikator kemiskinan, validasi GPS otomatis, dan sistem scoring terintegrasi untuk penilaian akurat kondisi keluarga.
                        </p>
                        <div class="mt-6">
                            <span class="inline-flex items-center text-green-600 font-semibold text-sm">
                                <span class="mr-2">25 Indikator Kemiskinan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Verifikasi Admin -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-green-100 card-hover animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="relative">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl mb-6 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3.75 5.25a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-900 mb-4">Sistem Verifikasi Terpusat</h3>
                        <p class="text-green-700 leading-relaxed">
                            Dashboard admin untuk verifikasi data survei, manajemen petugas lapangan, dan monitoring real-time progress survei di seluruh wilayah Kalimantan.
                        </p>
                        <div class="mt-6">
                            <span class="inline-flex items-center text-green-600 font-semibold text-sm">
                                <span class="mr-2">Multi-level Approval</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Analitik & Laporan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-green-100 card-hover animate-fadeInUp" style="animation-delay: 0.4s;">
                    <div class="relative">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl mb-6 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-900 mb-4">Analitik & Pelaporan</h3>
                        <p class="text-green-700 leading-relaxed">
                            Visualisasi data interaktif, export laporan PDF/Excel, dan analisis statistik mendalam untuk mendukung pengambilan keputusan berbasis data.
                        </p>
                        <div class="mt-6">
                            <span class="inline-flex items-center text-green-600 font-semibold text-sm">
                                <span class="mr-2">Export PDF & Excel</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Stack Section -->
    <section class="py-20 bg-gradient-to-br from-green-50 to-green-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 animate-fadeInUp">
                <h2 class="text-4xl font-bold text-green-900 mb-4">Teknologi yang Digunakan</h2>
                <p class="text-xl text-green-700 max-w-3xl mx-auto">
                    Dibangun dengan teknologi modern dan terpercaya untuk performa optimal
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-md text-center border border-green-200">
                    <div class="text-3xl mb-3">🚀</div>
                    <h4 class="font-semibold text-green-900">Laravel 10</h4>
                    <p class="text-sm text-green-600">PHP Framework</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md text-center border border-green-200">
                    <div class="text-3xl mb-3">🗺️</div>
                    <h4 class="font-semibold text-green-900">Leaflet.js</h4>
                    <p class="text-sm text-green-600">Interactive Maps</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md text-center border border-green-200">
                    <div class="text-3xl mb-3">📊</div>
                    <h4 class="font-semibold text-green-900">Chart.js</h4>
                    <p class="text-sm text-green-600">Data Visualization</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md text-center border border-green-200">
                    <div class="text-3xl mb-3">🎨</div>
                    <h4 class="font-semibold text-green-900">Tailwind CSS</h4>
                    <p class="text-sm text-green-600">Modern Styling</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-4xl mx-auto animate-fadeInUp">
                <h2 class="text-4xl font-bold text-green-900 mb-6">
                    Bergabunglah dalam Misi Pengentasan Kemiskinan di Kalimantan
                </h2>
                <p class="text-xl text-green-700 mb-10 leading-relaxed">
                    Dengan teknologi geospasial terdepan, mari bersama-sama membangun Kalimantan yang lebih sejahtera melalui data yang akurat dan actionable insights.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-xl transform hover:scale-105 font-semibold shadow-md">
                        <span class="mr-2">Akses Dashboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-xl transform hover:scale-105 font-semibold shadow-md">
                        <span class="mr-2">Mulai Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-800 to-green-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-6 h-6 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">GEOSMART</span>
                    </div>
                    <p class="text-green-100 mb-4 max-w-md">
                        Sistem Pemetaan Kemiskinan berbasis teknologi geospasial untuk pendataan masyarakat miskin di Kalimantan, Indonesia.
                    </p>
                    <div class="text-sm text-green-200">
                        <p>📍 Pulau Kalimantan, Indonesia</p>
                        <p>📧 @nursgnto</p>
                        <p>📞 +62 2253660177</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-green-100 mb-4">Fitur Sistem</h4>
                    <ul class="space-y-2 text-green-200">
                        <li><a href="#" class="hover:text-white transition-colors">Survei Digital</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pemetaan GPS</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Dashboard Admin</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Analitik Data</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-green-100 mb-4">Wilayah Kalimantan</h4>
                    <ul class="space-y-2 text-green-200">
                        <li><a href="#" class="hover:text-white transition-colors">Kalimantan Barat</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kalimantan Tengah</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kalimantan Timur</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kalimantan Selatan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kalimantan Utara</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-green-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-green-200 text-sm">
                        &copy; Geographic Survey Management and Reporting Tool for Kalimantan, Indonesia 2025.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-green-200 hover:text-white text-sm transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="text-green-200 hover:text-white text-sm transition-colors">Syarat Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeInUp');
                    }
                });
            }, observerOptions);

            // Observe all elements that should animate
            document.querySelectorAll('.card-hover, section').forEach(el => {
                observer.observe(el);
            });

            // Add parallax effect to floating elements
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.animate-float');

                parallaxElements.forEach(element => {
                    const speed = 0.5;
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
            });
        });
    </script>
</body>

</html>