@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Informasi Produk -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Informasi Produk</h2>

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
                        <option value="Processor" {{ old('category', $product->category) == 'Processor' ? 'selected' : '' }}>Processor</option>
                        <option value="VGA Card" {{ old('category', $product->category) == 'VGA Card' ? 'selected' : '' }}>VGA Card</option>
                        <option value="RAM" {{ old('category', $product->category) == 'RAM' ? 'selected' : '' }}>RAM</option>
                        <option value="Storage" {{ old('category', $product->category) == 'Storage' ? 'selected' : '' }}>Storage</option>
                        <option value="Motherboard" {{ old('category', $product->category) == 'Motherboard' ? 'selected' : '' }}>Motherboard</option>
                        <option value="Power Supply" {{ old('category', $product->category) == 'Power Supply' ? 'selected' : '' }}>Power Supply</option>
                        <option value="Casing" {{ old('category', $product->category) == 'Casing' ? 'selected' : '' }}>Casing</option>
                    </select>
                    @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full px-4 py-2 border rounded-lg"
                    >{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <!-- Supplier & Pricing -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Supplier & Harga</h2>
                    <button
                        type="button"
                        onclick="addSupplier()"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm"
                    >
                        + Tambah Supplier
                    </button>
                </div>

                @error('suppliers')
                <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                @enderror

                <div id="suppliers-container">
                    @php
                        $existingSuppliers = old('suppliers', $product->suppliers->map(function($s) {
                            return [
                                'supplier_id' => $s->id,
                                'stock' => $s->pivot->stock,
                                'harga_beli' => $s->pivot->harga_beli,
                                'harga_jual' => $s->pivot->harga_jual,
                            ];
                        })->toArray());
                    @endphp

                    @foreach($existingSuppliers as $index => $supplierData)
                    <div class="supplier-row border rounded-lg p-4 mb-4 bg-gray-50" data-index="{{ $index }}">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-gray-700">Supplier #{{ $index + 1 }}</h3>
                            <button
                                type="button"
                                onclick="removeSupplier({{ $index }})"
                                class="text-red-600 hover:text-red-800 text-sm remove-btn"
                            >
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Supplier</label>
                                <select
                                    name="suppliers[{{ $index }}][supplier_id]"
                                    class="w-full px-4 py-2 border rounded-lg @error('suppliers.'.$index.'.supplier_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $supplierData['supplier_id'] == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('suppliers.'.$index.'.supplier_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Stock</label>
                                <input
                                    type="number"
                                    name="suppliers[{{ $index }}][stock]"
                                    value="{{ $supplierData['stock'] }}"
                                    class="w-full px-4 py-2 border rounded-lg @error('suppliers.'.$index.'.stock') border-red-500 @enderror"
                                    min="0"
                                    required
                                >
                                @error('suppliers.'.$index.'.stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Harga Beli</label>
                                <input
                                    type="number"
                                    name="suppliers[{{ $index }}][harga_beli]"
                                    value="{{ $supplierData['harga_beli'] }}"
                                    class="w-full px-4 py-2 border rounded-lg harga-beli @error('suppliers.'.$index.'.harga_beli') border-red-500 @enderror"
                                    step="0.01"
                                    min="0"
                                    required
                                    onkeyup="calculateMargin({{ $index }})"
                                >
                                @error('suppliers.'.$index.'.harga_beli')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Harga Jual</label>
                                <input
                                    type="number"
                                    name="suppliers[{{ $index }}][harga_jual]"
                                    value="{{ $supplierData['harga_jual'] }}"
                                    class="w-full px-4 py-2 border rounded-lg harga-jual @error('suppliers.'.$index.'.harga_jual') border-red-500 @enderror"
                                    step="0.01"
                                    min="0"
                                    required
                                    onkeyup="calculateMargin({{ $index }})"
                                >
                                @error('suppliers.'.$index.'.harga_jual')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-blue-200 rounded p-2 text-sm">
                                    <span class="text-gray-600">Margin: </span>
                                    <span class="font-semibold text-blue-700 margin-display">
                                        Rp {{ number_format($supplierData['harga_jual'] - $supplierData['harga_beli'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if(empty($existingSuppliers))
                    <div class="supplier-row border rounded-lg p-4 mb-4 bg-gray-50" data-index="0">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-gray-700">Supplier #1</h3>
                            <button
                                type="button"
                                onclick="removeSupplier(0)"
                                class="text-red-600 hover:text-red-800 text-sm hidden remove-btn"
                            >
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Supplier</label>
                                <select
                                    name="suppliers[0][supplier_id]"
                                    class="w-full px-4 py-2 border rounded-lg"
                                    required
                                >
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Stock</label>
                                <input type="number" name="suppliers[0][stock]" value="0" class="w-full px-4 py-2 border rounded-lg" min="0" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Harga Beli</label>
                                <input type="number" name="suppliers[0][harga_beli]" class="w-full px-4 py-2 border rounded-lg harga-beli" step="0.01" min="0" required onkeyup="calculateMargin(0)">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Harga Jual</label>
                                <input type="number" name="suppliers[0][harga_jual]" class="w-full px-4 py-2 border rounded-lg harga-jual" step="0.01" min="0" required onkeyup="calculateMargin(0)">
                            </div>

                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-blue-200 rounded p-2 text-sm">
                                    <span class="text-gray-600">Margin: </span>
                                    <span class="font-semibold text-blue-700 margin-display">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Update Produk
                </button>
                <a href="{{ route('products.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let supplierIndex = {{ count($existingSuppliers) > 0 ? count($existingSuppliers) : 1 }};

function addSupplier() {
    const container = document.getElementById('suppliers-container');
    const newRow = `
        <div class="supplier-row border rounded-lg p-4 mb-4 bg-gray-50" data-index="${supplierIndex}">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-gray-700">Supplier #${supplierIndex + 1}</h3>
                <button
                    type="button"
                    onclick="removeSupplier(${supplierIndex})"
                    class="text-red-600 hover:text-red-800 text-sm remove-btn"
                >
                    Hapus
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Nama Supplier</label>
                    <select
                        name="suppliers[${supplierIndex}][supplier_id]"
                        class="w-full px-4 py-2 border rounded-lg"
                        required
                    >
                        <option value="">Pilih Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Stock</label>
                    <input type="number" name="suppliers[${supplierIndex}][stock]" value="0" class="w-full px-4 py-2 border rounded-lg" min="0" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Harga Beli</label>
                    <input type="number" name="suppliers[${supplierIndex}][harga_beli]" class="w-full px-4 py-2 border rounded-lg harga-beli" step="0.01" min="0" required onkeyup="calculateMargin(${supplierIndex})">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Harga Jual</label>
                    <input type="number" name="suppliers[${supplierIndex}][harga_jual]" class="w-full px-4 py-2 border rounded-lg harga-jual" step="0.01" min="0" required onkeyup="calculateMargin(${supplierIndex})">
                </div>

                <div class="md:col-span-2">
                    <div class="bg-blue-50 border border-blue-200 rounded p-2 text-sm">
                        <span class="text-gray-600">Margin: </span>
                        <span class="font-semibold text-blue-700 margin-display">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', newRow);
    supplierIndex++;
    updateRemoveButtons();
}

function removeSupplier(index) {
    const row = document.querySelector(`[data-index="${index}"]`);
    if (row) {
        row.remove();
        updateRemoveButtons();
    }
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.supplier-row');
    const removeButtons = document.querySelectorAll('.remove-btn');

    if (rows.length <= 1) {
        removeButtons.forEach(btn => btn.classList.add('hidden'));
    } else {
        removeButtons.forEach(btn => btn.classList.remove('hidden'));
    }
}

function calculateMargin(index) {
    const row = document.querySelector(`[data-index="${index}"]`);
    if (!row) return;

    const hargaBeli = parseFloat(row.querySelector('.harga-beli').value) || 0;
    const hargaJual = parseFloat(row.querySelector('.harga-jual').value) || 0;
    const margin = hargaJual - hargaBeli;
    const marginDisplay = row.querySelector('.margin-display');

    marginDisplay.textContent = 'Rp ' + margin.toLocaleString('id-ID');
    marginDisplay.className = 'font-semibold ' + (margin >= 0 ? 'text-green-700' : 'text-red-700');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons();
});
</script>
@endsection
