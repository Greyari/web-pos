<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Toko Komputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Toko Komputer</h1>
                <p class="text-sm text-blue-300">{{ auth()->user()->role }}</p>
            </div>

            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('products.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-box mr-3"></i>
                    Inventory
                </a>

                <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('transactions.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-receipt mr-3"></i>
                    Transaksi
                </a>

                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('customers.*') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Customer
                </a>

                @if(auth()->user()->role === 'owner')

                <a href="{{ route('report') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('report') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a>

                <a href="{{ route('report') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('report') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a>

                <a href="{{ route('pc-builder') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('pc-builder') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-desktop mr-3"></i>
                    Simulasi PC
                </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-3 hover:bg-blue-800 w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
