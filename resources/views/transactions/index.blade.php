@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#fcfcfc] overflow-hidden">
    {{-- LEFT SIDE --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Header & Filters --}}
        <div class="px-5">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-black text-[#1a1c1e] tracking-tight italic">Transaction</h1>
                <div class="flex gap-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" class="w-72 pl-11 pr-4 py-3 bg-white border-none shadow-sm rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-sm font-medium" placeholder="Search menu...">
                    </div>
                    <button class="p-3 bg-white shadow-sm rounded-2xl hover:bg-gray-50 transition-colors">
                        <svg class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex gap-3 mb-6 overflow-x-auto no-scrollbar">
                <button class="px-8 py-2.5 bg-[#1a1c1e] text-white rounded-full text-sm font-bold shadow-lg shadow-black/10">Cakes</button>
                <button class="px-8 py-2.5 bg-white text-gray-500 rounded-full text-sm font-bold shadow-sm hover:shadow-md transition-all">Pastry</button>
                <button class="px-8 py-2.5 bg-white text-gray-500 rounded-full text-sm font-bold shadow-sm hover:shadow-md transition-all">Ice Cream</button>
            </div>
        </div>

        {{-- Grid Area --}}
        <div class="flex-1 overflow-y-auto px-8 pb-8 no-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-product-card name="Raspberry Tart" category="Dessert" supplier="A" price="8.12" image="https://images.unsplash.com/photo-1519915028121-7d3463d20b13?q=80&w=400" />
                <x-product-card name="Lemon Tart" category="Dessert" supplier="A" price="2.86" image="https://images.unsplash.com/photo-1519915028121-7d3463d20b13?q=80&w=400" />
                <x-product-card name="Chocolate Tart" category="Dessert" supplier="B" price="6.12" image="https://images.unsplash.com/photo-1506459225024-1428097a7e18?q=80&w=400" />
                <x-product-card name="Fruit Tart" category="Dessert" supplier="A" price="6.12" image="https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=400" />
                <x-product-card name="Chocolate Cake" category="Dessert" supplier="C" price="24.86" image="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=400" />
                <x-product-card name="Mini Chocolate Cake" category="Dessert" supplier="C" price="6.12" image="https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=400" />
            </div>
        </div>
    </div>

    {{-- SIDEBAR: CURRENT ORDER --}}
    <div class="w-105 bg-white border-l border-gray-100 flex flex-col">
        <div class="p-8 flex flex-col h-full">
            <h2 class="text-2xl font-black text-[#1a1c1e] mb-8">Current Order</h2>

            {{-- User Info --}}
            <div class="flex items-center gap-4 mb-8 p-4 bg-[#f8f9fa] rounded-4xl">
                <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xl shadow-inner">EW</div>
                <div>
                    <p class="text-lg font-bold text-[#1a1c1e]">Emma Wang</p>
                    <p class="text-sm font-bold text-gray-400">Regular Customer</p>
                </div>
            </div>

            {{-- Order List --}}
            <div class="flex-1 overflow-y-auto no-scrollbar space-y-6">
                <div class="flex items-center gap-4 group">
                    <img src="https://images.unsplash.com/photo-1519915028121-7d3463d20b13?q=80&w=100" class="w-16 h-16 rounded-[1.2rem] object-cover shadow-sm">
                    <div class="flex-1">
                        <p class="font-bold text-[#1a1c1e]">Raspberry Tart</p>
                        <p class="text-sm font-black text-gray-900 mt-1">£8.12</p>
                    </div>
                    <div class="flex items-center gap-3 bg-[#f8f9fa] rounded-full p-1.5 shadow-inner">
                        <button class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-xs font-bold shadow-sm hover:bg-gray-50">-</button>
                        <span class="text-sm font-black w-4 text-center">1</span>
                        <button class="w-8 h-8 flex items-center justify-center bg-[#1a1c1e] text-white rounded-full text-xs font-bold shadow-md hover:bg-black">+</button>
                    </div>
                </div>
            </div>

            {{-- Checkout Area --}}
            <div class="mt-8 pt-8 border-t-2 border-dashed border-gray-100 space-y-4">
                <div class="flex justify-between text-gray-400 font-bold">
                    <span>Subtotal</span>
                    <span class="text-[#1a1c1e]">£8.98</span>
                </div>
                <div class="flex justify-between text-gray-400 font-bold">
                    <span>Service Charge (20%)</span>
                    <span class="text-[#1a1c1e]">£0.50</span>
                </div>
                <div class="flex justify-between text-2xl font-black text-[#1a1c1e] pt-4">
                    <span>Total</span>
                    <span>£9.48</span>
                </div>
                <button class="w-full bg-blue-950 hover:bg-blue-900 text-white font-black py-5 rounded-4xl mt-6 transition-all shadow-[0_20px_50px_rgba(99,102,241,0.2)] active:scale-[0.98]">
                    Continue to Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection