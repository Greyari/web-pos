@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Tambah Produk</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border rounded-lg @error('category') border-red-500 @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Processor">Processor</option>
                    <option value="VGA Card">VGA Card</option>
                    <option value="RAM">RAM</option>
                    <option value="Storage">Storage</option>
                    <option value="Motherboard">Motherboard</option>
                    <option value="Power Supply">Power Supply</option>
                    <option value="Casing">Casing</option>
                </select>
                @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Harga</label>
                <input
                    type="number"
                    name="price"
                    value="{{ old('price') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('price') border-red-500 @enderror"
                    required
                >
                @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Stok</label>
                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('stock') border-red-500 @enderror"
                    required
                >
                @error('stock')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full px-4 py-2 border rounded-lg"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('products.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
