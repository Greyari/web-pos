@extends('layouts.app')

@section('title', 'Manajemen Inventory')

@section('content')
<div class="px-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                Manajemen Inventory
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola produk komponen PC
            </p>
        </div>

        <a
            href="{{ route('products.create') }}"
            class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-sm hover:bg-slate-800 transition">
            <i class="fas fa-plus text-xs"></i>
            Tambah Produk
        </a>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-6">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama produk, kategori, atau spesifikasi..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-200">
                </div>

                <div class="md:col-span-4">
                    <select name="category" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-200">
                        <option value="">Semua Kategori</option>
                        @foreach(['Processor', 'VGA Card', 'RAM', 'Storage', 'Motherboard', 'Power Supply', 'Casing'] as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button
                        type="submit"
                        class="w-full px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm hover:bg-slate-800 transition">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- PRODUCTS GRID --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($products as $product)
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">
            <div class="p-5">
                <div class="flex items-start justify-between gap-4">

                    {{-- LEFT: Product Info --}}
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            {{-- Category Badge --}}
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                                    @php
                                        $icons = [
                                            'Processor' => 'fa-microchip',
                                            'VGA Card' => 'fa-desktop',
                                            'RAM' => 'fa-memory',
                                            'Storage' => 'fa-hdd',
                                            'Motherboard' => 'fa-server',
                                            'Power Supply' => 'fa-plug',
                                            'Casing' => 'fa-box'
                                        ];
                                        $icon = $icons[$product->category] ?? 'fa-cube';
                                    @endphp
                                    <i class="fas {{ $icon }} text-slate-600"></i>
                                </div>
                            </div>

                            {{-- Product Details --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-slate-800">
                                        {{ $product->name }}
                                    </h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs bg-slate-100 text-slate-600">
                                        {{ $product->category }}
                                    </span>
                                </div>

                                {{-- Specifications --}}
                                @if($product->category)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @php
                                            $specs = [];

                                            // Processor
                                            if($product->category === 'Processor') {
                                                if($product->socket) $specs[] = ['icon' => 'fa-bolt', 'label' => "Socket: {$product->socket}"];
                                                if($product->tdp) $specs[] = ['icon' => 'fa-fire', 'label' => "{$product->tdp}W TDP"];
                                            }

                                            // Motherboard
                                            if($product->category === 'Motherboard') {
                                                if($product->socket) $specs[] = ['icon' => 'fa-bolt', 'label' => "Socket: {$product->socket}"];
                                                if($product->chipset) $specs[] = ['icon' => 'fa-microchip', 'label' => $product->chipset];
                                                if($product->ram_type) $specs[] = ['icon' => 'fa-memory', 'label' => "{$product->ram_type} ({$product->ram_slots} slots)"];
                                                if($product->form_factor) $specs[] = ['icon' => 'fa-cube', 'label' => $product->form_factor];
                                            }

                                            // RAM
                                            if($product->category === 'RAM') {
                                                if($product->ram_generation) $specs[] = ['icon' => 'fa-memory', 'label' => $product->ram_generation];
                                                if($product->ram_speed) $specs[] = ['icon' => 'fa-tachometer-alt', 'label' => "{$product->ram_speed}MHz"];
                                                if($product->ram_capacity) $specs[] = ['icon' => 'fa-database', 'label' => "{$product->ram_capacity}GB"];
                                            }

                                            // VGA Card
                                            if($product->category === 'VGA Card') {
                                                if($product->vga_power_consumption) $specs[] = ['icon' => 'fa-fire', 'label' => "{$product->vga_power_consumption}W"];
                                                if($product->vga_power_connector) $specs[] = ['icon' => 'fa-plug', 'label' => $product->vga_power_connector];
                                            }

                                            // Storage
                                            if($product->category === 'Storage') {
                                                if($product->storage_type) $specs[] = ['icon' => 'fa-hdd', 'label' => $product->storage_type];
                                                if($product->storage_capacity) $specs[] = ['icon' => 'fa-database', 'label' => "{$product->storage_capacity}GB"];
                                                if($product->storage_interface) $specs[] = ['icon' => 'fa-link', 'label' => $product->storage_interface];
                                            }

                                            // Power Supply
                                            if($product->category === 'Power Supply') {
                                                if($product->psu_wattage) $specs[] = ['icon' => 'fa-bolt', 'label' => "{$product->psu_wattage}W"];
                                                if($product->psu_efficiency) $specs[] = ['icon' => 'fa-award', 'label' => $product->psu_efficiency];
                                            }

                                            // Casing
                                            if($product->category === 'Casing') {
                                                if($product->form_factor) $specs[] = ['icon' => 'fa-cube', 'label' => $product->form_factor];
                                                if($product->max_gpu_length) $specs[] = ['icon' => 'fa-ruler', 'label' => "GPU: {$product->max_gpu_length}mm"];
                                            }
                                        @endphp

                                        @foreach($specs as $spec)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs bg-slate-50 text-slate-600">
                                                <i class="fas {{ $spec['icon'] }} text-[10px]"></i>
                                                {{ $spec['label'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Description --}}
                                @if($product->description)
                                    <p class="text-sm text-slate-500 mt-2 line-clamp-1">
                                        {{ $product->description }}
                                    </p>
                                @endif

                                {{-- Suppliers --}}
                                <div class="mt-3">
                                    <div class="text-xs text-slate-500 mb-1.5">Supplier:</div>
                                    @forelse($product->suppliers as $supplier)
                                        <div class="inline-flex items-center gap-2 text-sm mr-3">
                                            <span class="text-slate-700">{{ $supplier->nama_supplier }}</span>
                                            <span class="px-2 py-0.5 rounded-full text-xs
                                                {{ $supplier->pivot->stock < 10
                                                    ? 'bg-red-100 text-red-600'
                                                    : 'bg-green-100 text-green-600' }}">
                                                {{ $supplier->pivot->stock }} unit
                                            </span>
                                        </div>
                                    @empty
                                        <span class="text-sm italic text-slate-400">
                                            Belum ada supplier
                                        </span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Price & Actions --}}
                    <div class="flex flex-col items-end gap-3">
                        {{-- Total Stock --}}
                        @php $totalStock = $product->suppliers->sum('pivot.stock'); @endphp
                        <div class="text-right">
                            <div class="text-xs text-slate-500 mb-1">Total Stok</div>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold
                                {{ $totalStock < 10
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-green-100 text-green-700'
                                }}">
                                {{ $totalStock }}
                            </span>
                        </div>

                        {{-- Price --}}
                        <div class="text-right">
                            <div class="text-xs text-slate-500 mb-1">Harga Termurah</div>
                            <div class="text-lg font-bold text-slate-900">
                                Rp {{ number_format($product->suppliers->min('pivot.harga_jual'), 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                                title="Edit">
                                <i class="fas fa-pen text-sm"></i>
                            </a>

                            <button
                                type="button"
                                onclick="openModal('delete-{{ $product->id }}')"
                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition"
                                title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DELETE MODAL --}}
        <x-modal id="delete-{{ $product->id }}" size="sm">
            <div class="flex flex-col items-center text-center">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation text-red-600"></i>
                </div>

                <h2 class="text-lg font-semibold mb-1">
                    Hapus Produk
                </h2>

                <p class="text-sm text-slate-500 mb-6">
                    Yakin ingin menghapus
                    <span class="font-medium text-slate-800">
                        {{ $product->name }}
                    </span>?
                    <br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex w-full gap-3">
                    <button
                        type="button"
                        onclick="closeModal('delete-{{ $product->id }}')"
                        class="flex-1 py-2 px-4 rounded-xl border text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button
                            class="w-full py-2 text-sm rounded-xl bg-red-600 text-white hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
        @empty
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <i class="fas fa-box-open text-4xl text-slate-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Produk</h3>
            <p class="text-sm text-slate-500 mb-4">
                Mulai tambahkan produk komponen PC pertama Anda
            </p>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-sm hover:bg-slate-800">
                <i class="fas fa-plus"></i>
                Tambah Produk
            </a>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($products->hasPages())
    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
