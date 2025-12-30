<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Toko Komputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="animated-gradient min-h-screen flex items-center justify-center p-4">

    <!-- Back Button -->
    <a href="/" class="absolute top-6 left-6 text-white flex items-center gap-2 hover:gap-3 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span class="font-semibold">Kembali</span>
    </a>

    <div class="w-full max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">

        <!-- Left Side - Branding -->
        <div class="hidden md:block text-white fade-in">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold">TechStore System</span>
            </div>

            <h2 class="text-4xl font-bold mb-6 leading-tight">
                Selamat Datang Kembali! 👋
            </h2>
            <p class="text-xl text-white text-opacity-90 mb-8">
                Masuk ke dashboard Anda dan kelola bisnis toko komputer dengan mudah dan efisien.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-3 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Dashboard Real-time</span>
                </div>
                <div class="flex items-center gap-3 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Laporan Lengkap</span>
                </div>
                <div class="flex items-center gap-3 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Keamanan Terjamin</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 fade-in">

            <!-- Mobile Logo -->
            <div class="md:hidden flex items-center justify-center gap-3 mb-8">
                <div class="w-12 h-12 bg-linear-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800">TechStore</span>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Login ke Dashboard</h1>
                <p class="text-gray-600">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition outline-none"
                            placeholder="nama@email.com"
                            required
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition outline-none"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Lupa password?</a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-linear-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:scale-[1.02] transition transform"
                >
                    Masuk ke Dashboard
                </button>
            </form>
            
            <!-- Footer Text -->
            <p class="text-center text-sm text-gray-500 mt-8">
                Belum punya akun? <a href="#" class="font-semibold text-purple-600 hover:text-purple-700">Daftar sekarang</a>
            </p>
        </div>

    </div>

</body>
</html>
