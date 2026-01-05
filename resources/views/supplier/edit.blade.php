@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Supplier</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('supplier.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Supplier</label>
                <input
                    type="text"
                    name="nama_supplier"
                    value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                    class="w-full px-4 py-2 border rounded-lg @error('nama_supplier') border-red-500 @enderror"
                    required
                >
                @error('nama_supplier')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <input
                    type="text"
                    name="alamat"
                    value="{{ old('alamat', $supplier->alamat)}}"
                    class="w-full px-4 py-2 border rounded-lg @error('alamat') border-red-500 @enderror"
                    required
                >
                @error('alamat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('supplier.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
