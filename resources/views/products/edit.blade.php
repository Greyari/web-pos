@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
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
                    <option value="Processor" @selected(old('category', $product->category) === 'Processor')>Processor</option>
                    <option value="VGA Card" @selected(old('category', $product->category) === 'VGA Card')>VGA Card</option>
                    <option value="RAM" @selected(old('category', $product->category) === 'RAM')>RAM</option>
                    <option value="Storage" @selected(old('category', $product->category) === 'Storage')>Storage</option>
                    <option value="Motherboard" @selected(old('category', $product->category) === 'Motherboard')>Motherboard</option>
                    <option value="Power Supply" @selected(old('category', $product->category) === 'Power Supply')>Power Supply</option>
                    <option value="Casing" @selected(old('category', $product->category) === 'Casing')>Casing</option>
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
                    value="{{ old('price', $product->price) }}"
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
                    value="{{ old('stock', $product->stock) }}"
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
                >{{ old('description', $product->description) }}</textarea>
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
