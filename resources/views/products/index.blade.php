@extends('layouts.app')

@section('title', 'Manajemen Inventory')

@section('content')
<div class="px-5">
    <div class="flex justify-between items-center mb-2 ">
        <h1 class="text-2xl font-semibold mb-6">Manajemen Inventory</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-950 text-white px-4 py-2 rounded-lg hover:bg-blue-900">
            <i class="fas fa-plus mr-2"></i>Produk
        </a>
    </div>

    <div class="mb-6">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="placeholder:text-sm flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit" class="bg-blue-950 text-white px-6 py-2 rounded-lg hover:bg-blue-900">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg border border-gray-200  shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100  text-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Suppliers</th>
                    <th class="px-4 py-3 text-left">Total Stok</th>
                    <th class="px-4 py-3 text-left">Harga Range</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-600 text-sm">{{ $product->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                            {{ $product->category }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col gap-1">
                            @foreach($product->suppliers as $supplier)
                            <div class="text-sm">
                                <span class="font-medium text-gray-600 text-sm">{{ $supplier->nama_supplier }}</span>
                                <span class="text-gray-500">(Stock: {{ $supplier->pivot->stock }})</span>
                            </div>
                            @endforeach
                            @if($product->suppliers->isEmpty())
                            <span class="text-gray-400 text-sm italic">Belum ada supplier</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @php
                        $totalStock = $product->suppliers->sum('pivot.stock');
                        @endphp
                        <span class="px-3 py-1 rounded font-semibold text-gray-600 text-sm {{ $totalStock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $totalStock }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-sm">
                        @if($product->suppliers->isNotEmpty())
                        @php
                        $minPrice = $product->suppliers->min('pivot.harga_jual');
                        $maxPrice = $product->suppliers->max('pivot.harga_jual');
                        @endphp
                        <div class="text-sm">
                            @if($minPrice == $maxPrice)
                            <span class="font-semibold">Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                            @else
                            <span class="font-semibold">Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                            <span class="text-gray-500">-</span>
                            <span class="font-semibold">Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini beserta semua data supplier?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        Tidak ada produk ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection