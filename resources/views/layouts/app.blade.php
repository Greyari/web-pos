<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Toko Komputer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        html {
            font-family: "Poppins", system-ui, sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white !important;
        }
    </style>
</head>

<body class="bg-blue-950 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden bg-blue-950">

        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden">
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-950 text-white flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 no-scrollbar overflow-y-auto">
            <div class="p-8 mb-4 flex items-center justify-between shrink-0">
                <h1 class="text-3xl font-bold italic ml-6">NATOPC</h1>
                <button @click="sidebarOpen = false" class="lg:hidden text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 space-y-2 px-4 no-scrollbar">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-sm transition-all rounded-xl {{ request()->routeIs('dashboard') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="7" x="3" y="3" rx="1" />
                        <rect width="7" height="7" x="14" y="3" rx="1" />
                        <rect width="7" height="7" x="14" y="14" rx="1" />
                        <rect width="7" height="7" x="3" y="14" rx="1" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('dashboard') ? 'font-semibold' : 'font-normal' }}">Dashboard</span>
                </a>

                <a href="{{ route('transactions.index') }}" class="flex items-center px-6 py-3 text-sm transition-all rounded-xl {{ request()->routeIs('transactions.*') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('transactions.*') ? 'font-semibold' : 'font-normal' }} text-sm">Transaction</span>
                </a>

                <a href="{{ route('report') }}" class="flex items-center px-6 py-3 text-sm transition-all rounded-xl {{ request()->routeIs('report') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                        <path d="M12 11h4" />
                        <path d="M12 16h4" />
                        <path d="M8 11h.01" />
                        <path d="M8 16h.01" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('report') ? 'font-semibold' : 'font-normal' }} text-sm">Report</span>
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center text-sm px-6 py-3 transition-all rounded-xl {{ request()->routeIs('products.*') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v6" />
                        <path d="M16.76 3a2 2 0 0 1 1.8 1.1l2.23 4.479a2 2 0 0 1 .21.891V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.472a2 2 0 0 1 .211-.894L5.45 4.1A2 2 0 0 1 7.24 3z" />
                        <path d="M3.054 9.013h17.893" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('products.*') ? 'font-semibold' : 'font-normal' }} text-sm">Product</span>
                </a>

                <a href="{{ route('customers.index') }}" class="flex text-sm items-center px-6 py-3 transition-all rounded-xl {{ request()->routeIs('customers.*') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 2v2" />
                        <path d="M7 22v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2" />
                        <path d="M8 2v2" />
                        <circle cx="12" cy="11" r="3" />
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('customers.*') ? 'font-semibold' : 'font-normal' }}">Customer</span>
                </a>

                @if(auth()->user()->role === 'owner')
                <a href="{{ route('supplier.index') }}" class="flex items-center text-sm px-6 py-3 transition-all rounded-xl {{ request()->routeIs('supplier.*') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck-icon lucide-truck">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                        <path d="M15 18H9" />
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                        <circle cx="17" cy="18" r="2" />
                        <circle cx="7" cy="18" r="2" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('supplier.*') ? 'font-semibold' : 'font-normal' }}">Supplier</span>
                </a>

                <a href="{{ route('users.index') }}" class="flex text-sm items-center px-6 py-3 transition-all rounded-xl {{ request()->routeIs('users.index') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                    <span class="ml-3 {{ request()->routeIs('users.index') ? 'font-semibold' : 'font-normal' }}">User</span>
                </a>

                <a href="{{ route('pc-builder') }}" class="flex items-center text-sm px-6 py-3 transition-all rounded-xl {{ request()->routeIs('pc-builder') ? 'nav-active' : 'hover:bg-white/20 text-white' }}">
                    <i class="fas fa-desktop text-sm"></i>
                    <span class="ml-3 {{ request()->routeIs('pc-builder') ? 'font-semibold' : 'font-normal' }}">PC Simulation</span>
                </a>
                @endif
            </nav>

            <div class="p-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-blue-100 px-6 hover:text-white transition-colors w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        </svg>
                        <span class="ml-3 text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-white">
            <header class="h-20 lg:h-10 flex items-center justify-between lg:justify-end px-6 lg:px-12 bg-white">
                <button @click="sidebarOpen = true" class="lg:hidden text-blue-950 p-2 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </header>

            <section class="flex-1 overflow-y-auto">
                <div class="bg-white lg:rounded-[40px] min-h-full px-4 lg:px-10 py-0">
                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif
                    @yield('content')
                </div>
            </section>
        </main>
    </div>
</body>

</html>