<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Sistem Toko Komputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-gradient {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>
<body class="animated-gradient min-h-screen">

    <!-- Navbar -->
    <nav class="absolute top-0 w-full z-10">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">TechStore</span>
            </div>
            <a href="{{ route('login') }}" class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-opacity-90 transition">
                Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">

            <!-- Left Content -->
            <div class="text-white">
                <div class="inline-block mb-4 px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm">
                    🚀 Sistem Manajemen Terpadu
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Kelola Toko Komputer Anda dengan <span class="text-yellow-300">Lebih Mudah</span>
                </h1>
                <p class="text-xl text-white text-opacity-90 mb-8 leading-relaxed">
                    Platform all-in-one untuk manajemen produk, transaksi penjualan, dan laporan bisnis. Tingkatkan efisiensi toko Anda hingga 10x lipat!
                </p>

                <!-- Features Grid -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-3xl mb-2">📦</div>
                        <h3 class="font-semibold mb-1">Manajemen Produk</h3>
                        <p class="text-sm text-white text-opacity-75">Kelola stok dengan mudah</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-3xl mb-2">💳</div>
                        <h3 class="font-semibold mb-1">Transaksi Cepat</h3>
                        <p class="text-sm text-white text-opacity-75">Proses pembayaran instan</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-3xl mb-2">📊</div>
                        <h3 class="font-semibold mb-1">Laporan Real-time</h3>
                        <p class="text-sm text-white text-opacity-75">Dashboard analitik lengkap</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-3xl mb-2">🔒</div>
                        <h3 class="font-semibold mb-1">Keamanan Terjamin</h3>
                        <p class="text-sm text-white text-opacity-75">Data terenkripsi aman</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="bg-white text-purple-600 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105">
                        Mulai Sekarang →
                    </a>
                    <button class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-opacity-30 transition">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>

            <!-- Right Content - Floating Card -->
            <div class="float-animation">
                <div class="bg-white rounded-3xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition duration-500">
                    <div class="bg-linear-to-br from-purple-500 to-pink-500 rounded-2xl p-6 mb-6">
                        <div class="flex items-center justify-between text-white mb-4">
                            <span class="text-sm font-semibold">DASHBOARD PREVIEW</span>
                            <div class="flex gap-2">
                                <div class="w-3 h-3 bg-white rounded-full"></div>
                                <div class="w-3 h-3 bg-white bg-opacity-50 rounded-full"></div>
                                <div class="w-3 h-3 bg-white bg-opacity-50 rounded-full"></div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">Rp 125.4 Jt</div>
                        <div class="text-white text-opacity-75">Total Penjualan Bulan Ini</div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">234 Produk</div>
                                    <div class="text-sm text-gray-500">Total Inventori</div>
                                </div>
                            </div>
                            <div class="text-green-600 font-bold">+12%</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">1,247 Transaksi</div>
                                    <div class="text-sm text-gray-500">Bulan Ini</div>
                                </div>
                            </div>
                            <div class="text-green-600 font-bold">+28%</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Dipercaya oleh Ribuan Toko</h2>
                <p class="text-gray-600 text-lg">Bergabunglah dengan komunitas pemilik toko komputer modern</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">5,000+</div>
                    <div class="text-gray-600">Pengguna Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">50M+</div>
                    <div class="text-gray-600">Transaksi Diproses</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">99.9%</div>
                    <div class="text-gray-600">Uptime</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">24/7</div>
                    <div class="text-gray-600">Support</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-gray-400">© 2025 Sistem Toko Komputer. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
