@extends('layouts.app')

@section('title', 'Manajemen Inventory')

@section('content')
<div class="px-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">
            Manajemen Inventory
        </h1>

        <a
            href="{{ route('products.create') }}"
            class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-sm hover:bg-slate-800 transition">
            <i class="fas fa-plus text-xs"></i>
            Tambah Produk
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-6">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="flex gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama produk atau kategori..."
                    class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-200">
                <button
                    type="submit"
                    class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm hover:bg-slate-800 transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 text-left font-medium">Produk</th>
                    <th class="px-6 py-4 text-left font-medium">Kategori</th>
                    <th class="px-6 py-4 text-left font-medium">Supplier</th>
                    <th class="px-6 py-4 text-left font-medium">Stok</th>
                    <th class="px-6 py-4 text-left font-medium">Harga</th>
                    <th class="px-6 py-4 text-right font-medium">Aksi</th>
                </tr>
            </thead>

            <tbody class="">
                @foreach($products as $product)
                <tr class="hover:bg-slate-50 transition border-b border-gray-200">

                    {{-- NAME --}}
                    <td class="px-6 py-4 font-medium text-slate-800">
                        {{ $product->name }}
                    </td>

                    {{-- CATEGORY --}}
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs bg-slate-100 text-slate-600">
                            {{ $product->category }}
                        </span>
                    </td>

                    {{-- SUPPLIER --}}
                    <td class="px-6 py-4 text-slate-600">
                        @forelse($product->suppliers as $supplier)
                        <div class="text-sm">
                            {{ $supplier->nama_supplier }}
                            <span class="text-slate-400">
                                ({{ $supplier->pivot->stock }})
                            </span>
                        </div>
                        @empty
                        <span class="italic text-slate-400 text-sm">
                            Belum ada supplier
                        </span>
                        @endforelse
                    </td>

                    {{-- STOCK --}}
                    <td class="px-6 py-4">
                        @php $totalStock = $product->suppliers->sum('pivot.stock'); @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $totalStock < 10
                                ? 'bg-red-100 text-red-600'
                                : 'bg-green-100 text-green-600'
                            }}">
                            {{ $totalStock }}
                        </span>
                    </td>

                    {{-- PRICE --}}
                    <td class="px-6 py-4 text-slate-600">
                        Rp {{ number_format($product->suppliers->min('pivot.harga_jual')) }}
                    </td>

                    {{-- ACTION --}}
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center gap-3">
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="text-slate-500 hover:text-slate-900 transition"
                                title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <button
                                type="button"
                                onclick="openModal('delete-{{ $product->id }}')"
                                class="text-red-500 hover:text-red-700 transition"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

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
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection